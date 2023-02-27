<?php
namespace App\Pmo\Front\Models;

use App\Pmo\Front\Models\ShopCategoryDescription;
use App\Pmo\Front\Models\ShopProduct;
use App\Pmo\Front\Models\ShopStore;
use Illuminate\Database\Eloquent\Model;


class ShopCategory extends Model
{
    
    use \App\Pmo\Front\Models\ModelTrait;
    use \App\Pmo\Front\Models\UuidTrait;
    
    public $table = SC_DB_PREFIX . 'shop_category';
    protected $guarded = [];
    protected $connection = SC_CONNECTION;

    protected $sc_parent = ''; // category id parent
    protected $sc_top = 'all'; // 1 - category display top, 0 -non top, all - all

    public function products()
    {
        return $this->belongsToMany(ShopProduct::class, SC_DB_PREFIX . 'shop_product_category', 'category_id', 'product_id');
    }
    public function stores()
    {
        return $this->belongsToMany(ShopStore::class, ShopCategoryStore::class, 'category_id', 'store_id');
    }

    public function descriptions()
    {
        return $this->hasMany(ShopCategoryDescription::class, 'category_id', 'id');
    }
    //Function get text description
    public function getText()
    {
        return $this->descriptions()->where('lang', sc_get_locale())->first();
    }
    public function getTitle()
    {
        return $this->getText()->title ?? '';
    }
    public function getDescription()
    {
        return $this->getText()->description ?? '';
    }
    public function getKeyword()
    {
        return $this->getText()->keyword?? '';
    }
    //End  get text description

    /**
     * Get category parent
     */
    public function getParent()
    {
        return $this->getDetail($this->parent);
    }

    protected static function boot()
    {
        parent::boot();
        // before delete() method call this
        static::deleting(function ($category) {
            //Delete category descrition
            $category->descriptions()->delete();
            $category->products()->detach();
            $category->stores()->detach();

            //Delete custom field
            (new ShopCustomFieldDetail)
            ->join(SC_DB_PREFIX.'shop_custom_field', SC_DB_PREFIX.'shop_custom_field.id', SC_DB_PREFIX.'shop_custom_field_detail.custom_field_id')
            ->where(SC_DB_PREFIX.'shop_custom_field_detail.rel_id', $category->id)
            ->where(SC_DB_PREFIX.'shop_custom_field.type', 'shop_category')
            ->delete();


        });
        //Uuid
        static::creating(function ($model) {
            if (empty($model->{$model->getKeyName()})) {
                $model->{$model->getKeyName()} = sc_generate_id($type = 'shop_category');
            }
        });
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

    public function getUrl($lang = null)
    {
        return sc_route('category.detail', ['alias' => $this->alias, 'lang' => $lang ?? app()->getLocale()]);
    }

    
    public function scopeSort($query, $sortBy = null, $sortOrder = 'asc')
    {
        $sortBy = $sortBy ?? 'sort';
        return $query->orderBy($sortBy, $sortOrder);
    }

    /**
     * Get categoy detail
     *
     * @param   [string]  $key     [$key description]
     * @param   [string]  $type  [id, alias]
     * @param   [int]  $checkActive
     *
     */
    public function getDetail($key, $type = null, $checkActive = 1)
    {
        if (empty($key)) {
            return null;
        }
        $storeId = config('app.storeId');
        $tableDescription = (new ShopCategoryDescription)->getTable();
        $dataSelect = $this->getTable().'.*, '.$tableDescription.'.*';
        $category = $this->selectRaw($dataSelect)
            ->leftJoin($tableDescription, $tableDescription . '.category_id', $this->getTable() . '.id')
            ->where($tableDescription . '.lang', sc_get_locale());

        if (sc_check_multi_store_installed()) {
            $tableCategoryStore = (new ShopCategoryStore)->getTable();
            $tableStore = (new ShopStore)->getTable();
            $category = $category->join($tableCategoryStore, $tableCategoryStore.'.category_id', $this->getTable() . '.id');
            $category = $category->join($tableStore, $tableStore . '.id', $tableCategoryStore.'.store_id');
            $category = $category->where($tableStore . '.status', '1');
            $category = $category->where($tableCategoryStore.'.store_id', $storeId);
        }

        if ($type === null) {
            $category = $category->where($this->getTable().'.id', $key);
        } else {
            $category = $category->where($type, $key);
        }
        if ($checkActive) {
            $category = $category->where($this->getTable() .'.status', 1);
        }
        return $category->first();
    }
    


    /**
     * Start new process get data
     *
     * @return  new model
     */
    public function start()
    {
        return new ShopCategory;
    }

    /**
     * Set category parent
     */
    public function setParent($parent)
    {
        $this->sc_parent = $parent;
        return $this;
    }

    /**
     * Set top value
     */
    private function setTop($top)
    {
        if ($top === 'all') {
            $this->sc_top = $top;
        } else {
            $this->sc_top = (int)$top ? 1 : 0;
        }
        return $this;
    }

    /**
     * Category root
     */
    public function getCategoryRoot()
    {
        $this->setParent(0);
        return $this;
    }

    /**
     * Category top
     */
    public function getCategoryTop()
    {
        $this->setTop(1);
        return $this;
    }

    /**
     * build Query
     */
    public function buildQuery()
    {
        $storeId = config('app.storeId');
        $tableDescription = (new ShopCategoryDescription)->getTable();
        $dataSelect = $this->getTable().'.*, '.$tableDescription.'.*';
        //description
        $query = $this->selectRaw($dataSelect)
            ->leftJoin($tableDescription, $tableDescription . '.category_id', $this->getTable() . '.id')
            ->where($tableDescription . '.lang', sc_get_locale());
        //search keyword
        if ($this->sc_keyword !='') {
            $query = $query->where(function ($sql) use ($tableDescription) {
                $sql->where($tableDescription . '.title', 'like', '%' . $this->sc_keyword . '%')
                ->orWhere($tableDescription . '.keyword', 'like', '%' . $this->sc_keyword . '%')
                ->orWhere($tableDescription . '.description', 'like', '%' . $this->sc_keyword . '%');
            });
        }

        if (sc_check_multi_store_installed()) {
            $tableCategoryStore = (new ShopCategoryStore)->getTable();
            $tableStore = (new ShopStore)->getTable();
            $query = $query->join($tableCategoryStore, $tableCategoryStore.'.category_id', $this->getTable() . '.id');
            $query = $query->join($tableStore, $tableStore . '.id', $tableCategoryStore.'.store_id');
            $query = $query->where($tableStore . '.status', '1');
            $query = $query->where($tableCategoryStore.'.store_id', $storeId);
        }

        $query = $query->where($this->getTable().'.status', 1);

        if ($this->sc_parent !== '') {
            $query = $query->where($this->getTable().'.parent', $this->sc_parent);
        }

        if ($this->sc_top !== 'all') {
            $query = $query->where($this->getTable().'.top', $this->sc_top);
        }

        /**
        Note: sc_moreWhere will remove in the next version
         */
        if (count($this->sc_moreWhere)) {
            foreach ($this->sc_moreWhere as $key => $where) {
                if (count($where)) {
                    $query = $query->where($where[0], $where[1], $where[2]);
                }
            }
        }
        $query = $this->processMoreQuery($query);
        

        if ($this->sc_random) {
            $query = $query->inRandomOrder();
        } else {
            $ckeckSort = false;
            if (is_array($this->sc_sort) && count($this->sc_sort)) {
                foreach ($this->sc_sort as  $rowSort) {
                    if (is_array($rowSort) && count($rowSort) == 2) {
                        if ($rowSort[0] == 'sort') {
                            $ckeckSort = true;
                        }
                        $query = $query->sort($rowSort[0], $rowSort[1]);
                    }
                }
            }
            //Use field "sort" if haven't above
            if (!$ckeckSort) {
                $query = $query->orderBy($this->getTable().'.sort', 'asc');
            }
            //Default, will sort id
            $query = $query->orderBy($this->getTable().'.id', 'desc');
        }

        return $query;
    }

    /**
     * Get list id sub categories, including itself
     *
     * @param   string  $cId  [$cId description]
     *
     * @return  array         [return description]
     */
    public function getListSub(string $cId):array {
        $arrayReturn = [$cId];
        $arrayMid = $this->where('parent', $cId)->pluck('id')->toArray();
        $arraySmall = $this->whereIn('parent', $arrayMid)->pluck('id')->toArray();
        return array_merge($arrayReturn, $arrayMid, $arraySmall);
    }
}
