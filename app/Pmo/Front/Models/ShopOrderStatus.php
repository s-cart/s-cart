<?php
#S-Cart/Core/Front/Models/ShopOrderStatus.php
namespace App\Pmo\Front\Models;

use Illuminate\Database\Eloquent\Model;

class ShopOrderStatus extends Model
{
    use \App\Pmo\Front\Models\ModelTrait;
    
    public $table = SC_DB_PREFIX.'shop_order_status';
    protected $connection = SC_CONNECTION;
    protected $guarded           = [];
    protected static $listStatus = null;

    public static function getIdAll()
    {
        if (!self::$listStatus) {
            self::$listStatus = self::pluck('name', 'id')->all();
        }
        return self::$listStatus;
    }
}
