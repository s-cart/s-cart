<?php
#app/Models/ShopProduct.php
namespace App\Models;

use App\Models\ShopAttributeGroup;
use App\Models\ShopCategory;
use App\Models\ShopProductCategory;
use App\Models\ShopProductDescription;
use App\Models\ShopProductGroup;
use App\Models\ShopProductPromotion;
use App\Models\ShopTax;
use DB;
use Illuminate\Database\Eloquent\Model;
use Cache;
use App\Models\ModelTrait;
class ShopProduct extends Model
{
    use ModelTrait;
    public $table = SC_DB_PREFIX.'shop_product';
    protected $guarded = [];

    protected $connection = SC_CONNECTION;

    protected  $sc_kind = 'all'; // 0:single, 1:bundle, 2:group
    protected  $sc_property = 'all'; // 0:physical, 1:download, 2:only view, 3: Service
    protected  $sc_promotion = 0; // 1: only produc promotion,
    protected  $sc_array_ID = []; // array ID product
    protected  $sc_category = []; // array category id
    protected  $sc_brand = []; // array brand id
    protected  $sc_supplier = []; // array supplier id

    protected $getListFull = null;
    
    public function brand()
    {
        return $this->belongsTo(ShopBrand::class, 'brand_id', 'id');
    }
    public function categories()
    {
        return $this->belongsToMany(ShopCategory::class, ShopProductCategory::class, 'product_id', 'category_id');
    }
    public function stories()
    {
        return $this->belongsToMany(AdminStore::class, ShopProductStore::class, 'product_id', 'store_id');
    }
    public function groups()
    {
        return $this->hasMany(ShopProductGroup::class, 'group_id', 'id');
    }
    public function builds()
    {
        return $this->hasMany(ShopProductBuild::class, 'build_id', 'id');
    }
    public function images()
    {
        return $this->hasMany(ShopProductImage::class, 'product_id', 'id');
    }

    public function descriptions()
    {
        return $this->hasMany(ShopProductDescription::class, 'product_id', 'id');
    }

    public function promotionPrice()
    {
        return $this->hasOne(ShopProductPromotion::class, 'product_id', 'id');
    }
    public function attributes()
    {
        return $this->hasMany(ShopProductAttribute::class, 'product_id', 'id');
    }

    /*
    *Get final price
    */
    public function getFinalPrice()
    {
        $promotion = $this->processPromotionPrice();
        if ($promotion != -1) {
            return $promotion;
        } else {
            return $this->price;
        }
    }

    /*
    *Get final price with tax
    */
    public function getFinalPriceTax()
    {
        return sc_tax_price($this->getFinalPrice(), $this->getTaxValue());
    }


    /**
     * [showPrice description]
     * @return [type]           [description]
     */
    public function showPrice()
    {
        if (!sc_config('product_price')) {
            return false;
        }
        $price = $this->price;
        $priceFinal = $this->getFinalPrice();
        // Process with tax
        return  view('templates.'.sc_store('template').'.common.show_price', 
            [
                'price' => $price,
                'priceFinal' => $priceFinal,
                'kind' => $this->kind,
            ])->render();
    }

    /**
     * [showPriceDetail description]
     *
     *
     * @return  [type]             [return description]
     */
    public function showPriceDetail()
    {
        if (!sc_config('product_price')) {
            return false;
        }
        $price = $this->price;
        $priceFinal = $this->getFinalPrice();
        // Process with tax
        return  view('templates.'.sc_store('template').'.common.show_price_detail', 
        [
            'price' => $price,
            'priceFinal' => $priceFinal,
            'kind' => $this->kind,
        ])->render();
    }

    /**
     * Get product detail
     * @param  [string] $key [description]
     * @param  [string] $type id, sku, alias
     * @param  [''|int] $status 
     * '' if is all status
     * @return [type]     [description]
     */
    public function getDetail($key = null, $type = null,  $status = 1)
    {
        if (empty($key)) {
            return null;
        }
        $tableDescription = (new ShopProductDescription)->getTable();
        $product = $this
            ->leftJoin($tableDescription, $tableDescription . '.product_id', $this->getTable() . '.id')
            ->where($tableDescription . '.lang', sc_get_locale());

        //Get product active for store
        $tablePTS = (new ShopProductStore)->getTable();
        $product = $product->leftJoin($tablePTS, $tablePTS . '.product_id', $this->getTable() . '.id');
        $product = $product->whereIn($tablePTS . '.store_id', [config('app.storeId'), 0]);
        //End store

        if (empty($type)) {
            $product = $product->where('id', (int)$key);  
        } elseif ($type == 'alias') {
            $product = $product->where('alias', $key);
        } elseif ($type == 'sku') {
            $product = $product->where('sku', $key);
        } else {
            return null;
        }
        if ($status) {
            $product = $product->where('status', (int)$status);
        }
        
        $product = $product
            ->with('images')
            ->with('promotionPrice');
        $product = $product->first();
        return $product;
    }

    protected static function boot()
    {
        parent::boot();
        // before delete() method call this
        static::deleting(function ($product) {
            $product->images()->delete();
            $product->descriptions()->delete();
            $product->promotionPrice()->delete();
            $product->groups()->delete();
            $product->attributes()->delete();
            $product->builds()->delete();
            $product->categories()->detach();
            $product->stories()->detach();
            }
        );
    }

    /*
    *Get thumb
    */
    public function getThumb()
    {
        return sc_image_get_path_thumb($this->image);
    }

    /*
    *Get image
    */
    public function getImage()
    {
        return sc_image_get_path($this->image);

    }

    /**
     * [getUrl description]
     * @return [type] [description]
     */
    public function getUrl()
    {
        return route('product.detail', ['alias' => $this->alias]);
    }


    /**
     * [getArrayProductName description]
     * @return [type] [description]
     */
    public static function getArrayProductName()
    {
        $products = self::select('id', 'sku')->get();
        $arrProduct = [];
        foreach ($products as $key => $product) {
            $arrProduct[$product->id] = $product->getFull()['name'] . ' (' . $product->sku . ')';
        }
        return $arrProduct;
    }

    /**
     * [getPercentDiscount description]
     * @return [type] [description]
     */
    public function getPercentDiscount()
    {
        return round((($this->price - $this->getFinalPrice()) / $this->price) * 100);
    }

    public function renderAttributeDetails()
    {
        return  view('templates.'.sc_store('template').'.common.render_attribute', 
        [
            'details' => $this->attributes()->get()->groupBy('attribute_group_id'),
            'groups' => ShopAttributeGroup::getListAll(),
        ]);
    }

    /**
     * Render html option price in admin
     *
     * @param   [type]$currency  [$currency description]
     * @param   nul   $rate      [$rate description]
     * @param   null             [ description]
     *
     * @return  [type]           [return description]
     */
    public function renderAttributeDetailsAdmin($currency = nul, $rate = null)
    {
        $html = '';
        $details = $this->attributes()->get()->groupBy('attribute_group_id');
        $groups = ShopAttributeGroup::getListAll();
        foreach ($details as $groupId => $detailsGroup) {
            $html .= '<br><b><label>' . $groups[$groupId] . '</label></b>: ';
            foreach ($detailsGroup as $k => $detail) {
                $valueOption = $detail->name.'__'.$detail->add_price;
                $html .= '<label class="radio-inline"><input ' . (($k == 0) ? "checked" : "") . ' type="radio" name="add_att[' . $this->id . '][' . $groupId . ']" value="' . $valueOption . '">' . sc_render_option_price($valueOption, $currency, $rate) . '</label> ';
            }
        }
        return $html;
    }

//Scort
    public function scopeSort($query, $sortBy = null, $sortOrder = 'desc')
    {
        $sortBy = $sortBy ?? 'id';
        return $query->orderBy($sortBy, $sortOrder);
    }

    /**
    *Condition:
    * -Active
    * -In of stock or allow order out of stock
    * -Date availabe
    * -Not SC_PRODUCT_GROUP
    */
    public function allowSale()
    {
        if (!sc_config('product_price')) {
            return false;
        }
        if ($this->sc_status &&
            (sc_config('product_preorder') == 1 || $this->date_available === null || date('Y-m-d H:i:s') >= $this->date_available) 
            && (sc_config('product_buy_out_of_stock') || $this->stock || empty(sc_config('product_stock'))) 
            && $this->kind != SC_PRODUCT_GROUP
        ) {
            return true;
        } else {
            return false;
        }
    }

    /*
    Check promotion price
    */
    public function processPromotionPrice()
    {
        $promotion = $this->promotionPrice;
        if ($promotion) {
            if (($promotion['date_end'] >= date("Y-m-d") || $promotion['date_end'] === null)
                && ($promotion['date_start'] <= date("Y-m-d") || $promotion['date_start'] === null)
                && $promotion['status_promotion'] = 1) {
                return $promotion['price_promotion'];
            }
        }

        return -1;
    }

    /*
    Upate stock, sold
     */
    public static function updateStock($product_id, $qty_change)
    {
        $item = self::find($product_id);
        if ($item) {
            $item->stock = $item->stock - $qty_change;
            $item->sold = $item->sold + $qty_change;
            $item->save();

            //Process build
            $product = self::find($product_id);
            if ($product->kind == SC_PRODUCT_BUILD) {
                foreach ($product->builds as $key => $build) {
                    $productBuild = $build->product;
                    $productBuild->stock -= $qty_change * $build->quantity;
                    $productBuild->sold += $qty_change * $build->quantity;
                    $productBuild->save();
                }
            }

        }

    }

    /**
     * Get list product
     *
     * @param   array  $arrOpt
     * Example: ['status' => 1, 'top' => 1]
     * @param   array  $arrSort
     * Example: ['sortBy' => 'id', 'sortOrder' => 'asc']
     * @param   array  $arrLimit  [$arrLimit description]
     * Example: ['step' => 0, 'limit' => 20]
     * @return  [type]             [return description]
     */
    public function getListAll($arrOpt = [], $arrSort = [], $arrLimit = [])
    {
        $sortBy = $arrSort['sortBy'] ?? 'sort';
        $sortOrder = $arrSort['sortOrder'] ?? 'asc';
        $step = $arrLimit['step'] ?? 0;
        $limit = $arrLimit['limit'] ?? 0;

        $data = $this->sort($sortBy, $sortOrder);
        if (count($arrOpt = [])) {
            foreach ($arrOpt as $key => $value) {
                $data = $data->where($key, $value);
            }
        }
        if ((int)$limit) {
            $start = $step * $limit;
            $data = $data->offset((int)$start)->limit((int)$limit);
        }

        $data = $data->get()->keyBy('id');

        return $data;
    }

    /**
     * Process list full product
     *
     * @return  [type]  [return description]
     */
    public static function getListFull()
    {
        if (sc_config_global('cache_status') && sc_config_global('cache_product')) {
            if (!Cache::has('cache_product')) {
                if (self::$getListFull === null) {
                    self::$getListFull = self::get()->keyBy('id')->toJson();
                }
                Cache::put('cache_product', self::$getListFull, $seconds = sc_config_global('cache_time')?:600);
            }
            return Cache::get('cache_product');
        } else {
            if (self::$getListFull === null) {
                self::$getListFull = self::get()->keyBy('id')->toJson();
            }
            return self::$getListFull;
        }
    }

    /**
     * Start new process get data
     *
     * @return  new model
     */
    public function start() {
        return new ShopProduct;
    }
    
    /**
     * Set product kind
     */
    private function setKind($kind) {
        if ($kind === 'all') {
            $this->sc_kind = $kind;
        } else {
            $this->sc_kind = (int)$kind;
        }
        return $this;
    }

    /**
     * Set property product
     */
    private function setVirtual($property) {
        if ($property === 'all') {
            $this->sc_property = $property;
        } else {
            $this->sc_property = (int)$property;
        }
        return $this;
    }

    /**
     * Set array category 
     *
     * @param   [array|int]  $category 
     *
     */
    private function setCategory($category) {
        if (is_array($category)) {
            $this->sc_category = $category;
        } else {
            $this->sc_category = array((int)$category);
        }
        return $this;
    }

    /**
     * Set array brand 
     *
     * @param   [array|int]  $brand 
     *
     */
    private function setBrand($brand) {
        if (is_array($brand)) {
            $this->sc_brand = $brand;
        } else {
            $this->sc_brand = array((int)$brand);
        }
        return $this;
    }

    /**
     * Set product promotion 
     *
     */
    private function setPromotion() {
        $this->sc_promotion = 1;
        return $this;
    }

    /**
     * Set array ID product 
     *
     * @param   [array|int]  $arrID 
     *
     */
    private function setArrayID($arrID) {
        if (is_array($arrID)) {
            $this->sc_array_ID = $arrID;
        } else {
            $this->sc_array_ID = array((int)$arrID);
        }
        return $this;
    }

    
    /**
     * Set array supplier 
     *
     * @param   [array|int]  $supplier 
     *
     */
    private function setSupplier($supplier) {
        if (is_array($supplier)) {
            $this->sc_supplier = $supplier;
        } else {
            $this->sc_supplier = array((int)$supplier);
        }
        return $this;
    }

    /**
     * Product hot
     */
    public function getProductHot() {
        return $this->getProductPromotion();
    }

    /**
     * Product build
     */
    public function getProductBuild() {
        $this->setStatus(1);
        $this->setKind(SC_PRODUCT_BUILD);
        return $this;
    }

    /**
     * Product group
     */
    public function getProductGroup() {
        $this->setStatus(1);
        $this->setKind(SC_PRODUCT_GROUP);
        return $this;
    }

    /**
     * Product single
     */
    public function getProductSingle() {
        $this->setStatus(1);
        $this->setKind(SC_PRODUCT_SINGLE);
        return $this;
    }

    /**
     * Get product to array Catgory
     * @param   [array|int]  $arrCategory 
     */
    public function getProductToCategory($arrCategory) {
        $this->setStatus(1);
        $this->setCategory($arrCategory);
        return $this;
    }

    /**
     * Get product to array Brand
     * @param   [array|int]  $arrBrand 
     */
    public function getProductToBrand($arrBrand) {
        $this->setStatus(1);
        $this->setBrand($arrBrand);
        return $this;
    }
    
    /**
     * Get product to array Supplier
     * @param   [array|int]  $arrSupplier 
     */
    public function getProductToSupplier($arrSupplier) {
        $this->setStatus(1);
        $this->setSupplier($arrSupplier);
        return $this;
    }


    /**
     * Get product latest
     */
    public function getProductLatest() {
        $this->setStatus(1);
        $this->setLimit(10);
        $this->setSort(['id', 'desc']);
        return $this;
    }

    /**
     * Get product last view
     */
    public function getProductLastView() {
        $this->setStatus(1);
        $this->setLimit(10);
        $this->setSort(['date_available', 'desc']);
        return $this;
    }

    /**
     * Get product best sell
     */
    public function getProductBestSell() {
        $this->setStatus(1);
        $this->setLimit(10);
        $this->setSort(['sold', 'desc']);
        return $this;
    }

    /**
     * Get product promotion
     */
    public function getProductPromotion() {
        $this->setStatus(1);
        $this->setLimit(10);
        $this->setPromotion();
        return $this;
    }

    /**
     * Get product from list ID product
     *
     * @param   [array]  $arrID  array id product
     *
     * @return  [type]          [return description]
     */
    public function getProductFromListID($arrID) {
        $this->setStatus(1);
        if (is_array($arrID)) {
            $this->setArrayID($arrID);
        }
        return $this;
    }

    /**
     * build Query
     */
    public function buildQuery() {

        $tableDescription = (new ShopProductDescription)->getTable();

        //description
        $query = $this
            ->leftJoin($tableDescription, $tableDescription . '.product_id', $this->getTable() . '.id')
            ->where($tableDescription . '.lang', sc_get_locale());
        //search keyword
        if ($this->sc_keyword !='') {
            $query = $query->where(function ($sql) use($tableDescription){
                $sql->where($tableDescription . '.name', 'like', '%' . $this->sc_keyword . '%')
                    ->orWhere($tableDescription . '.keyword', 'like', '%' . $this->sc_keyword . '%')
                    ->orWhere($tableDescription . '.description', 'like', '%' . $this->sc_keyword . '%')
                    ->orWhere($this->getTable() . '.sku', 'like', '%' . $this->sc_keyword . '%');
            });
        }

        //Promotion
        if ($this->sc_promotion == 1) {
            $tablePromotion = (new ShopProductPromotion)->getTable();
            $query = $query->join(
                $tablePromotion,
                $this->getTable() . '.id', '=', $tablePromotion . '.product_id')
                ->where($tablePromotion . '.status_promotion', 1)
                ->where(function ($query) use($tablePromotion){
                    $query->where($tablePromotion . '.date_end', '>=', date("Y-m-d"))
                        ->orWhereNull($tablePromotion . '.date_end');
                })
                ->where(function ($query) use($tablePromotion){
                    $query->where($tablePromotion . '.date_start', '<=', date("Y-m-d"))
                        ->orWhereNull($tablePromotion . '.date_start');
                });
        }

        $query = $query->with('promotionPrice');
            

        if (count($this->sc_category)) {
            $tablePTC = (new ShopProductCategory)->getTable();
            $query = $query->leftJoin($tablePTC, $tablePTC . '.product_id', $this->getTable() . '.id');
            $query = $query->whereIn($tablePTC . '.category_id', $this->sc_category);
        }

        //Get product active for store
        $tablePTS = (new ShopProductStore)->getTable();
        $query = $query->leftJoin($tablePTS, $tablePTS . '.product_id', $this->getTable() . '.id');
        $query = $query->whereIn($tablePTS . '.store_id', [config('app.storeId'), 0]);
        //End store

        if (count($this->sc_array_ID)) {
            $query = $query->whereIn('id', $this->sc_array_ID);
        }

        if ($this->sc_status !== 'all') {
            $query = $query->where('status', $this->sc_status);
        }

        if ($this->sc_kind !== 'all') {
            $query = $query->where('kind', $this->sc_kind);
        }

        
        if ($this->sc_property !== 'all') {
            $query = $query->where('property', $this->sc_property);
        }

        if (count($this->sc_brand)) {
            $query = $query->whereIn('brand_id', $this->sc_brand);
        }

        if (count($this->sc_supplier)) {

            foreach ($this->sc_supplier as  $supplier_id) {
                $query = $query->where(function($query) use($supplier_id){
                $query->where('supplier_id', $supplier_id)
                      ->orWhere('supplier_id', 'like', $supplier_id.',%')
                      ->orWhere('supplier_id', 'like', '%,'.$supplier_id.',%')
                      ->orWhere('supplier_id', 'like', '%,'.$supplier_id);
                });
            }
        }

        if (count($this->sc_moreWhere)) {
            foreach ($this->sc_moreWhere as $key => $where) {
                if (count($where)) {
                    $query = $query->where($where[0], $where[1], $where[2]);
                }
            }
        }

        if ($this->sc_random) {
            $query = $query->inRandomOrder();
        } else {
            if (is_array($this->sc_sort) && count($this->sc_sort)) {
                foreach ($this->sc_sort as  $rowSort) {
                    if (is_array($rowSort) && count($rowSort) == 2) {
                        $query = $query->sort($rowSort[0], $rowSort[1]);
                    }
                }
            }
        }

        //Hidden product out of stock
        if (empty(sc_config('product_display_out_of_stock')) && !empty(sc_config('product_stock'))) {
            $query = $query->where('stock', '>', 0);
        }

        return $query;
    }

    /**
     * Get tax ID
     *
     * @return  [type]  [return description]
     */
    public function getTaxId() {
        if (!ShopTax::checkStatus()) {
            return 0;
        }
        if ($this->tax_id == 'auto') {
            return ShopTax::checkStatus();
        } else {
            $arrTaxList = ShopTax::getListAll();
            if ($this->tax_id == 0 || !$arrTaxList->has($this->tax_id)) {
                return 0;
            }
        }
        return $this->tax_id;
    }

    /**
     * Get value tax (%)
     *
     * @return  [type]  [return description]
     */
    public function getTaxValue() {
        $taxId = $this->getTaxId();
        if ($taxId) {
            $arrValue = ShopTax::getArrayValue();
            return $arrValue[$taxId] ?? 0;
        } else {
            return 0;
        }
    }

}
