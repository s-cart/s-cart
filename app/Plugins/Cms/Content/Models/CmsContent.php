<?php
#app/Plugins/Cms/Content/Models/CmsContent.php
namespace App\Plugins\Cms\Content\Models;

use App\Plugins\Cms\Content\Models\CmsCategory;
use App\Plugins\Cms\Content\Models\CmsImage;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Cache;
use App\Admin\Models\AdminStore;
use Illuminate\Support\Facades\DB;
use App\Models\ModelTrait;

class CmsContent extends Model
{
    use ModelTrait;

    public $table = SC_DB_PREFIX.'cms_content';
    protected $guarded = [];
    protected $connection = SC_CONNECTION;

    protected  $sc_category = []; 

    protected static $getListFull = null;

    public function category()
    {
        return $this->belongsTo(CmsCategory::class, 'category_id', 'id');
    }

    public function stories()
    {
        return $this->belongsToMany(AdminStore::class, $this->table.'_store', 'content_id', 'store_id');
    }

    public function descriptions()
    {
        return $this->hasMany(CmsContentDescription::class, 'content_id', 'id');
    }
    public function images()
    {
        return $this->hasMany(CmsImage::class, 'content_id', 'id');
    }

    protected static function boot()
    {
        parent::boot();
        // before delete() method call this
        static::deleting(function ($content) {
            //Delete content descrition
            $content->descriptions()->delete();
            $content->stories()->detach();
        });
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

    /**
     * [getUrl description]
     * @return [type] [description]
     */
    public function getUrl()
    {
        return sc_route('cms.content', ['alias' => $this->alias]);
    }

    //Scort
    public function scopeSort($query, $column = null)
    {
        $column = $column ?? 'sort';
        return $query->orderBy($column, 'asc')->orderBy('id', 'desc');
    }

    /**
     * Get news detail
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
        $tableDescription = (new CmsContentDescription)->getTable();

        $content = $this
            ->leftJoin($tableDescription, $tableDescription . '.content_id', $this->getTable() . '.id')
            ->where($tableDescription . '.lang', sc_get_locale());

        //Get content active for store
        $tableNTS = $this->table.'_store';
        $content = $content->leftJoin($tableNTS, $tableNTS . '.content_id', $this->getTable() . '.id');
        $content = $content->whereIn($tableNTS . '.store_id', [config('app.storeId'), 0]);
        //End store


        if ($type == null) {
            $content = $content->where('id', (int) $key);
        } else {
            $content = $content->where($type, $key);
        }
        if ($status == 1) {
            $content = $content->where('status', 1);
        }
        return $content->first();
    }

    /**
     * Get list cms content
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

        $data = $this->sort($sortBy, $sortOrder);
        if(count($arrOpt = [])) {
            foreach ($arrOpt as $key => $value) {
                $data = $data->where($key, $value);
            }
        }
        if((int)$limit) {
            $start = $step * $limit;
            $data = $data->offset((int)$start)->limit((int)$limit);
        }
        $data = $data->get()->groupBy('id');

        return $data;
    }

    /**
     * Process list full cms content
     *
     * @return  [type]  [return description]
     */
    public static function getListFull()
    {
        if (sc_config_global('cache_status') && sc_config_global('cache_content_cms')) {
            if (!Cache::has('cache_content_cms')) {
                if (self::$getListFull === null) {
                    self::$getListFull = self::get()->keyBy('id')->toJson();
                }
                Cache::put('cache_content_cms', self::$getListFull, $seconds = sc_config_global('cache_time')?:600);
            }
            return Cache::get('cache_content_cms');
        } else {
            if (self::$getListFull === null) {
                self::$getListFull = self::get()->keyBy('id')->toJson();
            }
            return self::$getListFull;
        }
    }


//=========================

    public function uninstall()
    {
        if (Schema::hasTable($this->table)) {
            Schema::drop($this->table);
        }
        if (Schema::hasTable($this->table.'_store')) {
            Schema::drop($this->table.'_store');
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
            $table->integer('category_id')->default(0);
            $table->string('image', 100)->nullable();
            $table->string('alias', 120)->unique();
            $table->tinyInteger('sort')->default(0);
            $table->tinyInteger('status')->default(0);
            $table->timestamp('created_at')->nullable();
            $table->timestamp('updated_at')->nullable();
        });

        Schema::create($this->table.'_description', function (Blueprint $table) {
            $table->integer('content_id');
            $table->string('lang', 10);
            $table->string('title', 200)->nullable();
            $table->string('keyword', 200)->nullable();
            $table->string('description', 300)->nullable();
            $table->text('content')->nullable();
            $table->primary(['content_id', 'lang']);
        });

        Schema::create($this->table.'_store', function (Blueprint $table) {
            $table->integer('content_id');
            $table->integer('store_id');
            $table->primary(['content_id', 'store_id']);
            }
        );

        DB::connection(SC_CONNECTION)->table($this->table)->insert(
            [
                ['id' => 1, 'alias' =>  'demo-alias-content-1', 'image' => '/data/cms-image/cms_content_1.jpg', 'category_id' => 1,  'sort' => 0, 'status' => '1', 'created_at' => date("Y-m-d")],                    
                ['id' => 2, 'alias' =>  'demo-alias-content-2', 'image' => '/data/cms-image/cms_content_2.jpg', 'category_id' => 1,  'sort' => 0, 'status' => '1', 'created_at' => date("Y-m-d")],                    
            ]
        );

        DB::connection(SC_CONNECTION)->table($this->table.'_description')->insert(
            [
                ['content_id' => '1', 'lang' => 'en', 'title' => 'Demo cms content 1', 'keyword' => '', 'description' => '', 'content' => '<p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.<img alt="" src="/data/cms-image/cms.jpg" style="width: 262px; height: 262px; float: right; margin: 10px;" /></p>
                <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.</p>'],
                ['content_id' => '1', 'lang' => 'vi', 'title' => 'Demo cms content 1', 'keyword' => '', 'description' => '', 'content' => '<p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.<img alt="" src="/data/cms-image/cms.jpg" style="width: 262px; height: 262px; float: right; margin: 10px;" /></p>
                <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.</p>'],
                ['content_id' => '2', 'lang' => 'en', 'title' => 'Demo cms content 2', 'keyword' => '', 'description' => '', 'content' => '<p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.<img alt="" src="/data/cms-image/cms.jpg" style="width: 262px; height: 262px; float: right; margin: 10px;" /></p>
                <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.</p>'],
                ['content_id' => '2', 'lang' => 'vi', 'title' => 'Demo cms content 2', 'keyword' => '', 'description' => '', 'content' => '<p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.<img alt="" src="/data/cms-image/cms.jpg" style="width: 262px; height: 262px; float: right; margin: 10px;" /></p>
                <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.</p>'],
            ]
        );
        DB::connection(SC_CONNECTION)->table($this->table.'_store')->insert(
            [
                ['content_id' => '1', 'store_id' => '0'],
                ['content_id' => '2', 'store_id' => '0'],
            ]
        );
    }


    /**
     * Start new process get data
     *
     * @return  new model
     */
    public function start() {
        return new CmsContent;
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
     * Get content to array Catgory
     * @param   [array|int]  $arrCategory 
     */
    public function getContentToCategory($arrCategory) {
        $this->setStatus(1);
        $this->setCategory($arrCategory);
        return $this;
    }

    /**
     * build Query
     */
    public function buildQuery() {
        $tableDescription = (new CmsContentDescription)->getTable();

        //description
        $query = $this
            ->leftJoin($tableDescription, $tableDescription . '.content_id', $this->getTable() . '.id')
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
        $query = $query->leftJoin($tableNTS, $tableNTS . '.content_id', $this->getTable() . '.id');
        $query = $query->whereIn($tableNTS . '.store_id', [config('app.storeId'), 0]);
        //End store

        if (count($this->sc_category)) {
            $query = $query->whereIn('category_id', $this->sc_category);
        }

        if ($this->sc_status !== 'all') {
            $query = $query->where('status', $this->sc_status);
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
