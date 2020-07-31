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
        return $this->hasMany(AdminStoreDescription::class, 'config_id', 'id');
    }

    /**
     * [getAll description]
     *
     * @return  [type]  [return description]
     */
    public static function getAll()
    {
        if (sc_config('cache_status', 0) && sc_config('cache_store', 0)) {
            if (!Cache::has('cache_store')) {
                if (self::$getAll == null) {
                    self::$getAll = self::with('descriptions')->get()->groupBy('id');
                }
                Cache::put('cache_store', self::$getAll, $seconds = sc_config('cache_time', 0)?:600);
            }
            return Cache::get('cache_store');
        } else {
            if (self::$getAll == null) {
                self::$getAll = self::with('descriptions')->get()->groupBy('id');
            }
            return self::$getAll;
        }
    }

    /**
     * Get all domain and id store
     *
     * @return  [array]  [return description]
     */
    public static function getDomain()
    {
        return self::where('status', 1)->pluck('domain', 'id')->all();
    }
}
