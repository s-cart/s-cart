<?php
#app/Plugins/Cms/Content/Models/CmsCategory.php
namespace App\Plugins\Cms\Content\Models;

use App\Plugins\Cms\Content\Models\CmsCategoryDescription;
use App\Plugins\Cms\Content\Models\CmsContent;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;
use SCart\Core\Front\Models\ModelTrait;

class CmsCategory extends Model
{
    use ModelTrait;

    public $timestamps = false;
    public $table = SC_DB_PREFIX.'cms_category';
    protected $guarded = [];
    protected $connection = SC_CONNECTION;

    protected  $sc_parent = ''; // category id parent

    public function descriptions()
    {
        return $this->hasMany(CmsCategoryDescription::class, 'category_id', 'id');
    }
    public function contents()
    {
        return $this->hasMany(CmsContent::class, 'category_id', 'id');
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
    public function getDetail($key, $type = null)
    {
        if(empty($key)) {
            return null;
        }

        $tableDescription = (new CmsCategoryDescription)->getTable();

        //description
        $category = $this
            ->leftJoin($tableDescription, $tableDescription . '.category_id', $this->getTable() . '.id')
            ->where($tableDescription . '.lang', sc_get_locale())
            ->where($this->getTable() . '.store_id', config('app.storeId'));

        if ($type == null) {
            $category = $category->where('id', (int) $key);
        } else {
            $category = $category->where($type, $key);
        }
        $category = $category->where('status', 1);

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
    }

    public function install()
    {
        $this->uninstall();

        Schema::create($this->table, function (Blueprint $table) {
            $table->increments('id');
            $table->string('image', 100)->nullable();
            $table->integer('parent')->default(0);
            $table->string('alias', 120)->index();
            $table->integer('store_id')->default(1)->index();
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

        DB::connection(SC_CONNECTION)->table($this->table)->insert(
            [
                ['id' => '1', 'alias'=> 'demo-category-1', 'image' => '/data/cms-image/cms.jpg', 'parent' => '0', 'sort' => '0', 'status' => '1', 'store_id' => 1],
                ['id' => '2', 'alias'=> 'demo-category-2', 'image' => '/data/cms-image/cms.jpg', 'parent' => '0', 'sort' => '0', 'status' => '1', 'store_id' => 1],
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
                $sql->where($tableDescription . '.title', 'like', '%' . $this->sc_keyword . '%');
            });
        }

        $query = $query->where('status', 1)
        ->where('store_id', config('app.storeId'));

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
