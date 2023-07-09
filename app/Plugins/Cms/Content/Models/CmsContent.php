<?php
#app/Plugins/Cms/Content/Models/CmsContent.php
namespace App\Plugins\Cms\Content\Models;

use App\Plugins\Cms\Content\Models\CmsCategory;
use App\Plugins\Cms\Content\Models\CmsImage;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;
use SCart\Core\Front\Models\ModelTrait;

class CmsContent extends Model
{
    use ModelTrait;
    use \SCart\Core\Front\Models\UuidTrait;
    
    public $table = SC_DB_PREFIX.'cms_content';
    protected $guarded = [];
    protected $connection = SC_CONNECTION;

    protected  $sc_category = []; 

    public function category()
    {
        return $this->belongsTo(CmsCategory::class, 'category_id', 'id');
    }

    public function descriptions()
    {
        return $this->hasMany(CmsContentDescription::class, 'content_id', 'id');
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
    public function getContent()
    {
        return $this->getText()->content;
    }
    //End  get text description

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
        });

        //Uuid
        static::creating(function ($model) {
            if (empty($model->{$model->getKeyName()})) {
                $model->{$model->getKeyName()} = sc_generate_id($type = 'cms_content');
            }
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
    public function getUrl($lang = null)
    {
        return sc_route('cms.content', ['category' => $this->category->alias, 'alias' => $this->alias, 'lang' => $lang ?? app()->getLocale()]);
    }

    //Scort
    public function scopeSort($query, $sortBy = null, $sortOrder = 'asc')
    {
        $sortBy = $sortBy ?? 'sort';
        return $query->orderBy($sortBy, $sortOrder);
    }

    /**
     * Get news detail
     *
     * @param   [string]  $key     [$key description]
     * @param   [string]  $type  [id, alias]
     * @param   [int]  $checkActive
     *
     */
    public function getDetail($key, $type = null, $checkActive = 1)
    {
        if(empty($key)) {
            return null;
        }
        $tableDescription = (new CmsContentDescription)->getTable();

        $content = $this
            ->leftJoin($tableDescription, $tableDescription . '.content_id', $this->getTable() . '.id')
            ->where($tableDescription . '.lang', sc_get_locale());

        if ($type == null) {
            $content = $content->where('id', $key);
        } else {
            $content = $content->where($type, $key);
        }
        if ($checkActive) {
            $content = $content->where('status', 1);
        }
        $content = $content->where('store_id', config('app.storeId'));
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
            $table->uuid('id')->primary();
            $table->uuid('category_id')->default(0);
            $table->string('image', 100)->nullable();
            $table->string('alias', 120)->index();
            $table->tinyInteger('sort')->default(0);
            $table->tinyInteger('status')->default(0);
            $table->uuid('store_id')->default(1)->index();
            $table->timestamp('created_at')->nullable();
            $table->timestamp('updated_at')->nullable();
        });

        Schema::create($this->table.'_description', function (Blueprint $table) {
            $table->uuid('content_id');
            $table->string('lang', 10);
            $table->string('title', 300)->nullable();
            $table->string('keyword', 200)->nullable();
            $table->string('description', 500)->nullable();
            $table->mediumText('content')->nullable();
            $table->primary(['content_id', 'lang']);
        });

        DB::connection(SC_CONNECTION)->table($this->table)->insert(
            [
                ['id' => 1, 'alias' =>  'demo-alias-content-1', 'image' => '/data/cms-image/cms_content_1.jpg', 'category_id' => 1,  'sort' => 0, 'status' => '1', 'created_at' => date("Y-m-d"), 'store_id' => 1],                    
                ['id' => 2, 'alias' =>  'demo-alias-content-2', 'image' => '/data/cms-image/cms_content_2.jpg', 'category_id' => 1,  'sort' => 0, 'status' => '1', 'created_at' => date("Y-m-d"), 'store_id' => 1],                    
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
            $this->sc_category = array($category);
        }
        return $this;
    }

    /**
     * Get content to array Catgory
     * @param   [array|int]  $arrCategory 
     */
    public function getContentToCategory($arrCategory) {
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
                $sql->where($tableDescription . '.title', 'like', '%' . $this->sc_keyword . '%');
            });
        }

        if (count($this->sc_category)) {
            $query = $query->whereIn('category_id', $this->sc_category);
        }

        $query = $query->where('status', 1)
            ->where('store_id', config('app.storeId'));

        $query = $this->processMoreQuery($query);
        
        if ($this->sc_random) {
            $query = $query->inRandomOrder();
        } else {
            $checkSort = false;
            if (is_array($this->sc_sort) && count($this->sc_sort)) {
                foreach ($this->sc_sort as  $rowSort) {
                    if (is_array($rowSort) && count($rowSort) == 2) {
                        if ($rowSort[0] == 'sort') {
                            $checkSort = true;
                        }
                        $query = $query->sort($rowSort[0], $rowSort[1]);
                    }
                }
            }
        }

        //Use field "sort" if haven't above
        if (empty($checkSort)) {
            $query = $query->orderBy($this->getTable().'.sort', 'asc');
        }
        //Default, will sort id
        $query = $query->orderBy($this->getTable().'.id', 'desc');

        return $query;
    }    

    /**
     * Get list content with category alias
     *
     * @param   string  $aliasCategory  [$aliasCategory description]
     *
     * @return  [type]                  [return description]
     */
    public function getContentWithAliasCategory(string $aliasCategory) {
        $tableDescription = (new CmsContentDescription)->getTable();
        $tableCmsCategory = (new CmsCategory)->getTable();
        $content = $this
        ->selectRaw($this->getTable().'.*, '.$tableDescription.'.*')
        ->leftJoin($tableCmsCategory, $tableCmsCategory . '.id', $this->getTable() . '.category_id')
        ->leftJoin($tableDescription, $tableDescription . '.content_id', $this->getTable() . '.id')
        ->where($tableDescription . '.lang', sc_get_locale())
        ->where($tableCmsCategory . '.alias', $aliasCategory)
        ->where($this->getTable() . '.status', 1)
        ->get();
        return $content;
    }
}
