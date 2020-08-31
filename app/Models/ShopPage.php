<?php
#app/Models/ShopPage.php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Cache;
use App\Models\ModelTrait;
class ShopPage extends Model
{
    use ModelTrait;

    public $timestamps     = false;
    public $table          = SC_DB_PREFIX.'shop_page';
    protected $connection  = SC_CONNECTION;
    protected $guarded     = [];

    protected static $getListFull = null;
    public function descriptions()
    {
        return $this->hasMany(ShopPageDescription::class, 'page_id', 'id');
    }
    public function stories()
    {
        return $this->belongsToMany(AdminStore::class, ShopPageStore::class, 'page_id', 'store_id');
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
        return route('page.detail', ['alias' => $this->alias]);
    }

    /**
     * Get page detail
     *
     * @param   [string]  $key     [$key description]
     * @param   [string]  $type  [id, alias]
     *
     */
    public function getDetail($key, $type = null, $status = 1)
    {
        if (empty($key)) {
            return null;
        }
        $tableDescription = (new ShopPageDescription)->getTable();
        $page = $this
            ->leftJoin($tableDescription, $tableDescription . '.page_id', $this->getTable() . '.id')
            ->where($tableDescription . '.lang', sc_get_locale());

        //Get news active for store
        $tablePTS = (new ShopPageStore)->getTable();
        $page = $page->leftJoin($tablePTS, $tablePTS . '.page_id', $this->getTable() . '.id');
        $page = $page->whereIn($tablePTS . '.store_id', [config('app.storeId'), 0]);
        //End store

        if ($type === null) {
            $page = $page->where('id', (int) $key);
        } else {
            $page = $page->where($type, $key);
        }
        if ($status == 1) {
            $page = $page->where('status', 1);
        }
        return $page->first();
    }

    protected static function boot()
    {
        parent::boot();
        // before delete() method call this
        static::deleting(function ($page) {
            $page->descriptions()->delete();
            $page->stories()->detach();
            }
        );
    }


    /**
     * Get list page
     *
     * @param  array  $arrOpt
     * Example: ['status' => 1, 'top' => 1]
     * @param  array  $arrSort
     * Example: ['sortBy' => 'id', 'sortOrder' => 'asc']
     * @param   array  $arrLimit  [$arrLimit description]
     * Example: ['step' => 0, 'limit' => 20]
     * @return  [type]             [return description]
     */
    public function getListAll($arrOpt = [], $arrSort = [], $arrLimit = [])
    {
        $sortBy = $arrSort['sortBy'] ?? null;
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
        $data = $data->get()->groupBy('id');

        return $data;
    }

    /**
     * Process list full page
     *
     * @return  [type]  [return description]
     */
    public static function getListFull()
    {
        if (sc_config_global('cache_status') && sc_config_global('cache_page')) {
            if (!Cache::has('cache_page')) {
                if (self::$getListFull === null) {
                    self::$getListFull = self::get()->keyBy('id')->toJson();
                }
                Cache::put('cache_page', self::$getListFull, $seconds = sc_config_global('cache_time')?:600);
            }
            return Cache::get('cache_page');
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
        return new ShopPage;
    }

    /**
     * build Query
     */
    public function buildQuery() {
        $tableDescription = (new ShopPageDescription)->getTable();

        //description
        $query = $this
            ->leftJoin($tableDescription, $tableDescription . '.page_id', $this->getTable() . '.id')
            ->where($tableDescription . '.lang', sc_get_locale());
        //search keyword
        if ($this->sc_keyword !='') {
            $query = $query->where(function ($sql) use($tableDescription){
                $sql->where($tableDescription . '.title', 'like', '%' . $this->sc_keyword . '%')
                ->orWhere($tableDescription . '.keyword', 'like', '%' . $this->sc_keyword . '%')
                ->orWhere($tableDescription . '.description', 'like', '%' . $this->sc_keyword . '%');
            });
        }

        //Get news active for store
        $tablePTS = (new ShopPageStore)->getTable();
        $query = $query->leftJoin($tablePTS, $tablePTS . '.page_id', $this->getTable() . '.id');
        $query = $query->whereIn($tablePTS . '.store_id', [config('app.storeId'), 0]);
        //End store

        if ($this->sc_status !== 'all') {
            $query = $query->where('status', $this->sc_status);
        }

        if (count($this->sc_moreWhere)) {
            foreach ($this->sc_moreWhere as $key => $where) {
                if (count($where)) {
                    $query = $query->where($where[0], $where[1], $where[2]);
                }
            }
        }

        if ($this->random) {
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

        return $query;
    }
}
