<?php
#app/Models/ShopTax.php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ShopTax extends Model
{
    public $timestamps = false;
    public $table = SC_DB_PREFIX.'shop_tax';
    protected $guarded = [];
    private static $getList = null;
    protected $connection = SC_CONNECTION;

    public static function getList()
    {
        if (self::$getList == null) {
            self::$getList = self::get()->keyBy('id');
        }
        return self::$getList;
    }
}
