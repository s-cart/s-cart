<?php
#app/Models/AdminStore.php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Cache;
class AdminStore extends Model
{
    public $timestamps = false;
    public $table = SC_DB_PREFIX.'admin_store';
    protected $guarded = [];
    protected static $getAll = null;
    protected $connection = SC_CONNECTION;
    
    public function descriptions()
    {
        return $this->hasMany(AdminStoreDescription::class, 'store_id', 'id');
    }

    protected static function boot()
    {
        parent::boot();
        // before delete() method call this
        static::deleting(function ($store) {
            //Store id 1 is default
            if ($store->id == 1) {
                return false;
            }
            //Delete store descrition
            $store->descriptions()->delete();
        });
    }


    /**
     * [getAll description]
     *
     * @return  [type]  [return description]
     */
    public static function getListAll()
    {
        if (sc_config_global('cache_status') && sc_config_global('cache_store')) {
            if (!Cache::has('cache_store')) {
                if (self::$getAll == null) {
                    self::$getAll = self::with('descriptions')
                        ->get()
                        ->keyBy('id');
                }
                Cache::put('cache_store', self::$getAll, $seconds = sc_config_global('cache_time')?:600);
            }
            return Cache::get('cache_store');
        } else {
            if (self::$getAll == null) {
                self::$getAll = self::with('descriptions')
                    ->get()
                    ->keyBy('id');
            }
            return self::$getAll;
        }
    }

    /**
     * Get all template used
     *
     * @return  [type]  [return description]
     */
    public static function getAllTemplateUsed() {
        return self::pluck('template')->all();
    }

    /**
     * Get all domain and id store
     *
     * @return  [array]  [return description]
     */
    public static function getDomain()
    {
        return self::where('status', 1)
            ->pluck('domain', 'id')
            ->all();
    }

}
