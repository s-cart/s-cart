<?php
#S-Cart/Core/Front/Models/ShopWeight.php
namespace App\Pmo\Front\Models;

use Illuminate\Database\Eloquent\Model;

class ShopWeight extends Model
{
    use \App\Pmo\Front\Models\ModelTrait;
    
    public $table = SC_DB_PREFIX.'shop_weight';
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
