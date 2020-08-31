<?php
#app/Models/ShopSubscribe.php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ShopSubscribe extends Model
{
    public $table = SC_DB_PREFIX.'shop_subscribe';
    protected $guarded      = [];
    protected $connection = SC_CONNECTION;
    private static $getList = null;
    public static function getListAll()
    {
        if (self::$getList === null) {
            self::$getList = self::get()->keyBy('id');
        }
        return self::$getList;
    }
}
