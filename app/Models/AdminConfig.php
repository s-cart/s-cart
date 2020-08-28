<?php
#app/Models/AdminConfig.php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Cache;
class AdminConfig extends Model
{
    public $timestamps = false;
    public $table = SC_DB_PREFIX.'admin_config';
    protected $guarded = [];

    protected static $getAll = null;
    protected static $getAllGlobal = null;
    protected static $getAllStore = null;
    protected $connection = SC_CONNECTION;

    /**
     * get Plugin installed
     * @param  [type]  $code      Payment, Shipping,..
     * @param  boolean $onlyActive
     * @return [type]              [description]
     */
    public static function getPluginCode($code = null, $onlyActive = true)
    {
        if($code === null) {
            $query =  self::where('group', 'Plugins');
        } else {
            $code = sc_word_format_class($code);
            $query =  self::where('group', 'Plugins')->where('code', $code);
        }
        if ($onlyActive) {
            $query = $query->where('value', 1);
        }
        $return = $query->orderBy('sort', 'asc')
            ->get()->keyBy('key');
        return $return;
    }

    /**
     * get Group
     * @param  [string]  $group
     * @param  [string]  $suffix
     * @return [type]              [description]
     */
    public static function getGroup($group = null, $suffix = null)
    {
        if ($group === null) {
            return [];
        }
        $return =  self::where('group', $group);
        if ($suffix) {
            $return = $return->orWhere('group', $group.'__'.$suffix);
        }
        $return = $return->orderBy('sort','desc')->pluck('value')->all();
        if ($return) {
            return $return;
        } else {
            return [];
        }
    }

/**
 * [getAll description]
 *
 * @param[int] $store  [$store description]
 *
 * @return [type]          [return description]
 */
    public static function getListAll()
    {
        if (self::$getAll === null) {
            self::$getAll = self::where('store_id', '<>', 0)
                ->get()
                ->keyBy('store_id');
        }
        return self::$getAll;
    }

    /**
     * [getAllGlobal description]
     *
     * @return  [type]  [return description]
     */
    public static function getAllGlobal()

    {
        if (self::$getAllGlobal === null) {
            self::$getAllGlobal = self::where('store_id', 0)
                ->pluck('value', 'key')
                ->all();
        }
        return self::$getAllGlobal;
    }

    /**
     * [getAllStore description]
     *
     * @param   [type]  $storeId  [$storeId description]
     *
     * @return  [type]            [return description]
     */
    public static function getAllStore($storeId) {
        if (self::$getAllStore === null) {
            self::$getAllStore = self::where('store_id', $storeId)
                ->pluck('value', 'key')
                ->all();
        }
        return self::$getAllStore;
    }
}
