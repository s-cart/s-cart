<?php
#app/Models/ShopLength.php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ShopLength extends Model
{
    public $timestamps     = false;
    public $table = SC_DB_PREFIX.'shop_length';
    protected $connection = SC_CONNECTION;
    protected $guarded           = [];
    protected static $getList = null;

    public static function getListAll()
    {
        if (!self::$getList) {
            self::$getList = self::pluck('description', 'name')->all();
        }
        return self::$getList;
    }
}
