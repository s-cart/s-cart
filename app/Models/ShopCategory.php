<?php
#app/Models/ShopCategory.php
namespace App\Models;

use App\Models\ShopCategoryDescription;
use App\Models\ShopProduct;
use Cache;
use Illuminate\Database\Eloquent\Model;
use App\Models\ModelTrait;

class ShopCategory extends Model
{
    use ModelTrait;

    public $timestamps = false;
    public $table = SC_DB_PREFIX . 'shop_category';
    protected $guarded = [];
    protected $connection = SC_CONNECTION;

    protected  $sc_parent = ''; // category id parent
    protected  $sc_top = 'all'; // 1 - category display top, 0 -non top, all - all

    protected static $getListTitle = null;
    protected static $getListFull = null;

    public function products()
    {
        return $this->belongsToMany(ShopProduct::class, SC_DB_PREFIX . 'shop_product_category', 'category_id', 'product_id');
    }

    public function descriptions()
    {
        return $this->hasMany(ShopCategoryDescription::class, 'category_id', 'id');
    }
    public function stories()
    {
        return $this->belongsToMany(AdminStore::class, ShopCategoryStore::class, 'category_id', 'store_id');
    }
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
            $category->stories()->detach();
        });
    }


    /**
     * Get all ID category children of parent
     * @param  integer $parent     [description]
     * @param  [type]  &$arrayID      [description]
     * @param  [object]  $categories [description]
     * @return [array]              [description]
     */
    public function getIdCategories($parent = 0, &$arrayID = [], $categories = [])
    {
        $categories = $categories ?? $this->getListAll();
        $arrayID = $arrayID ?? [];
        $lisCategory = $categories[$parent] ?? [];
        if (count($lisCategory)) {
            foreach ($lisCategory as $category) {
                $arrayID[] = $category['id'];
                if (!empty($categories[$category['id']])) {
                    $this->getIdCategories($category['id'], $arrayID, $categories);
                }
            }
        }
        return $arrayID;
    }

    /**
     * Get tree categories
     *
     * @param   [type]  $parent      [$parent description]
     * @param   [type]  &$tree       [&$tree description]
     * @param   [type]  $categories  [$categories description]
     * @param   [type]  &$st         [&$st description]
     *
     * @return  [type]               [return description]
     */
    public function getTreeCategories($parent = 0, &$tree = [], $categories = null, &$st = '')
    {
        $categories = $categories ?? $this->getListAll();
        $tree = $tree ?? [];
        $lisCategory = $categories[$parent] ?? [];
        if ($lisCategory) {
            foreach ($lisCategory as $category) {
                $tree[$category['id']] = $st . $category['title'];
                if (!empty($categories[$category['id']])) {
                    $st .= '--';
                    $this->getTreeCategories($category['id'], $tree, $categories, $st);
                    $st = '';
                }
            }
        }
        return $tree;
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

    public function getUrl()
    {
        return route('category.detail', ['alias' => $this->alias]);
    }

    //Scort
    public function scopeSort($query, $sortBy = null, $sortOrder = 'desc')
    {
        $sortBy = $sortBy ?? 'sort';
        return $query->orderBy($sortBy, $sortOrder);
    }

    /**
     * Get list category
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
        $tableDescription = (new ShopCategoryDescription)->getTable();

        $sortBy = $arrSort['sortBy'] ?? null;
        $sortOrder = $arrSort['sortOrder'] ?? 'asc';
        $step = $arrLimit['step'] ?? 0;
        $limit = $arrLimit['limit'] ?? 0;

        $data = $this
            ->leftJoin($tableDescription, $tableDescription . '.category_id', $this->getTable() . '.id')
            ->where($tableDescription . '.lang', sc_get_locale());

        $data = $data->sort($sortBy, $sortOrder);
        if(count($arrOpt = [])) {
            foreach ($arrOpt as $key => $value) {
                $data = $data->where($key, $value);
            }
        }
        if((int)$limit) {
            $start = $step * $limit;
            $data = $data->offset((int)$start)->limit((int)$limit);
        }
        $data = $data->get()->groupBy('parent');

        return $data;
    }

    /**
     * Get array title category
     * user for admin 
     *
     * @return  [type]  [return description]
     */
    public static function getListTitle()
    {
        if (sc_config_global('cache_status') && sc_config_global('cache_category')) {
            if (!Cache::has('cache_category_'.sc_get_locale())) {
                if (self::$getListTitle === null) {
                    self::$getListTitle = (new ShopCategoryDescription)->where('lang', sc_get_locale())
                        ->pluck('title', 'category_id')->toArray();
                }
                Cache::put('cache_category_'.sc_get_locale(), self::$getListTitle, $seconds = sc_config_global('cache_time')?:600);
            }
            return Cache::get('cache_category_'.sc_get_locale());
        } else {
            if (self::$getListTitle === null) {
                self::$getListTitle = (new ShopCategoryDescription)->where('lang', sc_get_locale())
                    ->pluck('title', 'category_id')->toArray();
            }
            return self::$getListTitle;
        }
    }


    /**
     * Process list full cactegory
     *
     * @return  [type]  [return description]
     */
    public static function getListFull()
    {
        if (sc_config_global('cache_status') && sc_config_global('cache_category')) {
            if (!Cache::has('cache_category')) {
                if (self::$getListFull === null) {
                    self::$getListFull = self::get()->keyBy('id')->toJson();
                }
                Cache::put('cache_category', self::$getListFull, $seconds = sc_config_global('cache_time')?:600);
            }
            return Cache::get('cache_category');
        } else {
            if (self::$getListFull === null) {
                self::$getListFull = self::get()->keyBy('id')->toJson();
            }
            return self::$getListFull;
        }
    }


    /**
     * Get categoy detail
     *
     * @param   [string]  $key     [$key description]
     * @param   [string]  $type  [id, alias]
     *
     */
    public function getDetail($key, $type = null, $status = 1)
    {
        if(empty($key)) {
            return null;
        }
        $tableDescription = (new ShopCategoryDescription)->getTable();
        $category = $this
            ->leftJoin($tableDescription, $tableDescription . '.category_id', $this->getTable() . '.id')
            ->where($tableDescription . '.lang', sc_get_locale());

        //Get category active for store
        $tableCTS = (new ShopCategoryStore)->getTable();
        $category = $category->leftJoin($tableCTS, $tableCTS . '.category_id', $this->getTable() . '.id');
        $category = $category->whereIn($tableCTS . '.store_id', [config('app.storeId'), 0]);
        //End store

        if ($type === null) {
            $category = $category->where('id', (int) $key);
        } else {
            $category = $category->where($type, $key);
        }
        if ($status == 1) {
            $category = $category->where('status', 1);
        }
        return $category->first();
    }


    /**
     * Start new process get data
     *
     * @return  new model
     */
    public function start() {
        return new ShopCategory;
    }

    /**
     * Set category parent
     */
    public function setParent($parent) {
        $this->sc_parent = (int)$parent;
        return $this;
    }

    /**
     * Set top value
     */
    private function setTop($top) {
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
    public function getCategoryRoot() {
        $this->setParent(0);
        $this->setStatus(1);
        return $this;
    }

    /**
     * Category top
     */
    public function getCategoryTop() {
        $this->setTop(1);
        $this->setStatus(1);
        return $this;
    }

    /**
     * build Query
     */
    public function buildQuery() {
        $tableDescription = (new ShopCategoryDescription)->getTable();

        //description
        $query = $this
            ->leftJoin($tableDescription, $tableDescription . '.category_id', $this->getTable() . '.id')
            ->where($tableDescription . '.lang', sc_get_locale());
        //search keyword
        if ($this->sc_keyword !='') {
            $query = $query->where(function ($sql) use($tableDescription){
                $sql->where($tableDescription . '.title', 'like', '%' . $this->sc_keyword . '%')
                ->orWhere($tableDescription . '.keyword', 'like', '%' . $this->sc_keyword . '%')
                ->orWhere($tableDescription . '.description', 'like', '%' . $this->sc_keyword . '%');
            });
        }

        //Get category active for store
        $tableCTS = (new ShopCategoryStore)->getTable();
        $query = $query->leftJoin($tableCTS, $tableCTS . '.category_id', $this->getTable() . '.id');
        $query = $query->whereIn($tableCTS . '.store_id', [config('app.storeId'), 0]);
        //End store

        if ($this->sc_status !== 'all') {
            $query = $query->where('status', $this->sc_status);
        }

        if ($this->sc_parent !== '') {
            $query = $query->where('parent', $this->sc_parent);
        }

        if ($this->sc_top !== 'all') {
            $query = $query->where('top', $this->sc_top);
        }

        if (count($this->sc_moreWhere)) {
            foreach ($this->sc_moreWhere as $key => $where) {
                if(count($where)) {
                    $query = $query->where($where[0], $where[1], $where[2]);
                }
            }
        }

        if ($this->sc_random) {
            $query = $query->inRandomOrder();
        } else {
            if (is_array($this->sc_sort) && count($this->sc_sort)) {
                foreach ($this->sc_sort as  $rowSort) {
                    if(is_array($rowSort) && count($rowSort) == 2) {
                        $query = $query->sort($rowSort[0], $rowSort[1]);
                    }
                }
            }
        }

        return $query;
    }
}
