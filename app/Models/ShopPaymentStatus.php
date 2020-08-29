<?php
#app/Models/ShopPaymentStatus.php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ShopPaymentStatus extends Model
{
    public $timestamps  = false;
    public $table = SC_DB_PREFIX.'shop_payment_status';
    protected $guarded   = [];
    protected $connection = SC_CONNECTION;
    protected static $listStatus = null;
    public static function getIdAll()
    {
        if (!self::$listStatus) {
            self::$listStatus = self::pluck('name', 'id')->all();
        }
        return self::$listStatus;
    }
}
