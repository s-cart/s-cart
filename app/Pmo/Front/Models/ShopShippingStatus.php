<?php
#App\Pmo\Front\Models\ShopShippingStatus.php
namespace App\Pmo\Front\Models;

use Illuminate\Database\Eloquent\Model;

class ShopShippingStatus extends Model
{
    use \App\Pmo\Front\Models\ModelTrait;
    
    public $table = SC_DB_PREFIX.'shop_shipping_status';
    protected $guarded           = [];
    protected static $listStatus = null;
    protected $connection = SC_CONNECTION;
    public static function getIdAll()
    {
        if (!self::$listStatus) {
            self::$listStatus = self::pluck('name', 'id')->all();
        }
        return self::$listStatus;
    }
}
