<?php
#app/Models/AdminConfig.php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AdminConfig extends Model
{
    public $timestamps = false;
    public $table = SC_DB_PREFIX.'admin_config';
    protected static $getAll = null;
    protected $connection = SC_CONNECTION;

    /**
     * get Plugin installed
     * @param  [type]  $code      Payment, Shipping,..
     * @param  boolean $onlyActive
     * @return [type]              [description]
     */
    public static function getPluginCode($code = null, $onlyActive = true)
    {
        if($code == null) {
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

    public static function getAll()
    {
        if (self::$getAll == null) {
            self::$getAll = self::pluck('value', 'key')->all();
        }
        return self::$getAll;
    }

}
