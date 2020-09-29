<?php
#app/Plugins/Cms/Content/Models/CmsCategory.php
namespace App\Plugins\Cms\Content\Models;

use App\Plugins\Cms\Content\Models\CmsCategoryDescription;
use App\Plugins\Cms\Content\Models\CmsContent;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use App\Admin\Models\AdminStore;
use App\Models\ModelTrait;
use Illuminate\Support\Facades\DB;
use Cache;

class CmsCategory extends Model
{
    use ModelTrait;

    public $timestamps = false;
    public $table = SC_DB_PREFIX.'cms_category';
    protected $guarded = [];
    protected $connection = SC_CONNECTION;

    protected  $sc_parent = ''; // category id parent
    protected static $getListTitle = null;
    protected static $getListFull = null;

    public function descriptions()
    {
        return $this->hasMany(CmsCategoryDescription::class, 'category_id', 'id');
    }
    public function contents()
    {
        return $this->hasMany(CmsContent::class, 'category_id', 'id');
    }

    public function stories()
    {
        return $this->belongsToMany(AdminStore::class, $this->table.'_store', 'category_id', 'store_id');
    }


/**
 * Get category parent
 * @return [type]     [description]
 */
    public function getParent()
    {
        return $this->getDetail($this->parent);

    }

     /**
     * Get list category cms
     *
     * @param   array  $arrOpt
     * Example: ['status' => 1, 'top' => 1]
     * @param   array  $arrSort
     * Example: ['sortBy' => 'id', 'sortOrder' => 'asc']
     * @param   array  $arrLimit  [$arrLimit description]
     * Example: ['step' => 0, 'limit' => 20]
     * @return  [type]             [return description]
     */
    public function getList($arrOpt = [], $arrSort = [], $arrLimit = [])
    {
        $sortBy = $arrSort['sortBy'] ?? null;
        $sortOrder = $arrSort['sortOrder'] ?? 'asc';
        $step = $arrLimit['step'] ?? 0;
        $limit = $arrLimit['limit'] ?? 0;

        $tableDescription = (new CmsCategoryDescription)->getTable();

        //description
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
        if (sc_config_global('cache_status') && sc_config_global('cache_category_cms')) {
            if (!Cache::has('cache_category_cms_'.sc_get_locale())) {
                if (self::$getListTitle === null) {
                    self::$getListTitle = (new CmsCategoryDescription)->where('lang', sc_get_locale())
                        ->pluck('title', 'category_id')->toArray();
                }
                Cache::put('cache_category_cms_'.sc_get_locale(), self::$getListTitle, $seconds = sc_config_global('cache_time')?:600);
            }
            return Cache::get('cache_category_cms_'.sc_get_locale());
        } else {
            if (self::$getListTitle === null) {
                self::$getListTitle = (new CmsCategoryDescription)->where('lang', sc_get_locale())
                    ->pluck('title', 'category_id')->toArray();
            }
            return self::$getListTitle;
        }
    }



    /**
     * Process list full cactegory cms
     *
     * @return  [type]  [return description]
     */
    public static function getListFull()
    {
        if (sc_config_global('cache_status') && sc_config_global('cache_category_cms')) {
            if (!Cache::has('cache_category_cms')) {
                if (self::$getListFull === null) {
                    self::$getListFull = self::get()->keyBy('id')->toJson();
                }
                Cache::put('cache_category_cms', self::$getListFull, $seconds = sc_config_global('cache_time')?:600);
            }
            return Cache::get('cache_category_cms');
        } else {
            if (self::$getListFull === null) {
                self::$getListFull = self::get()->keyBy('id')->toJson();
            }
            return self::$getListFull;
        }
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
        $categories = $categories ?? $this->getList();
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
    Get thumb
    */
    public function getThumb()
    {
        return sc_image_get_path_thumb($this->image);
    }

    /*
    Get image
    */
    public function getImage()
    {
        return sc_image_get_path($this->image);

    }

    public function getUrl()
    {
        return sc_route('cms.category', ['alias' => $this->alias]);
    }


    protected static function boot()
    {
        parent::boot();
        // before delete() method call this
        static::deleting(function ($category) {
            //Delete category descrition
            $category->descriptions()->delete();
            $category->stories()->detach();
        });
    }

//Scort
    public function scopeSort($query, $column = null)
    {
        $column = $column ?? 'sort';
        return $query->orderBy($column, 'asc')->orderBy('id', 'desc');
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

        $tableDescription = (new CmsCategoryDescription)->getTable();

        //description
        $category = $this
            ->leftJoin($tableDescription, $tableDescription . '.category_id', $this->getTable() . '.id')
            ->where($tableDescription . '.lang', sc_get_locale());

        //Get content active for store
        $tableNTS = $this->table.'_store';
        $category = $category->leftJoin($tableNTS, $tableNTS . '.category_id', $this->getTable() . '.id');
        $category = $category->whereIn($tableNTS . '.store_id', [config('app.storeId'), 0]);
        //End store

        if ($type == null) {
            $category = $category->where('id', (int) $key);
        } else {
            $category = $category->where($type, $key);
        }
        if ($status == 1) {
            $category = $category->where('status', 1);
        }
        return $category->first();
    }

//=========================

    public function uninstall()
    {
        if (Schema::hasTable($this->table)) {
            Schema::drop($this->table);
        }

        if (Schema::hasTable($this->table.'_description')) {
            Schema::drop($this->table.'_description');
        }

        if (Schema::hasTable($this->table.'_store')) {
            Schema::drop($this->table.'_store');
        }
        
    }

    public function install()
    {
        $this->uninstall();

        Schema::create($this->table, function (Blueprint $table) {
            $table->increments('id');
            $table->string('image', 100)->nullable();
            $table->integer('parent')->default(0);
            $table->string('alias', 120)->unique();
            $table->tinyInteger('sort')->default(0);
            $table->tinyInteger('status')->default(0);
        });

        Schema::create($this->table.'_description', function (Blueprint $table) {
            $table->integer('category_id');
            $table->string('lang', 10);
            $table->string('title', 200)->nullable();
            $table->string('keyword', 200)->nullable();
            $table->string('description', 300)->nullable();
            $table->primary(['category_id', 'lang']);
        });

        Schema::create($this->table.'_store', function (Blueprint $table) {
            $table->integer('category_id');
            $table->integer('store_id');
            $table->primary(['category_id', 'store_id']);
            }
        );

        DB::connection(SC_CONNECTION)->table($this->table)->insert(
            [
                ['id' => '1', 'alias'=> 'demo-category-1', 'image' => '/data/cms-image/cms.jpg', 'parent' => '0', 'sort' => '0', 'status' => '1'],
                ['id' => '2', 'alias'=> 'demo-category-2', 'image' => '/data/cms-image/cms.jpg', 'parent' => '0', 'sort' => '0', 'status' => '1'],
            ]
        );

        DB::connection(SC_CONNECTION)->table($this->table.'_description')->insert(
            [
                ['category_id' => '1', 'lang' => 'en', 'title' => 'Category CMS 1', 'keyword' => '', 'description' => ''],
                ['category_id' => '1', 'lang' => 'vi', 'title' => 'Danh mục CMS 1', 'keyword' => '', 'description' => ''],
                ['category_id' => '2', 'lang' => 'en', 'title' => 'Category CMS 2', 'keyword' => '', 'description' => ''],
                ['category_id' => '2', 'lang' => 'vi', 'title' => 'Danh mục CMS 2', 'keyword' => '', 'description' => ''],
            ]
        );
        DB::connection(SC_CONNECTION)->table($this->table.'_store')->insert(
            [
                ['category_id' => '1', 'store_id' => '0'],
                ['category_id' => '2', 'store_id' => '0'],
            ]
        );
    }
    /**
     * Start new process get data
     *
     * @return  new model
     */
    public function start() {
        return new CmsCategory;
    }

    /**
     * Set category parent
     */
    public function setParent($parent) {
        if ($parent === 'all') {
            $this->sc_parent = $parent;
        } else {
            $this->sc_parent = (int)$parent;
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
     * build Query
     */
    public function buildQuery() {
        $tableDescription = (new CmsCategoryDescription)->getTable();

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

        //Get content active for store
        $tableNTS = $this->table.'_store';
        $query = $query->leftJoin($tableNTS, $tableNTS . '.category_id', $this->getTable() . '.id');
        $query = $query->whereIn($tableNTS . '.store_id', [config('app.storeId'), 0]);
        //End store

        if ($this->sc_status !== 'all') {
            $query = $query->where('status', $this->sc_status);
        }

        if ($this->sc_parent !== 'all') {
            $query = $query->where('parent', $this->sc_parent);
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
