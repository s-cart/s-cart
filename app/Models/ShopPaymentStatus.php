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
    public static function getListStatus()
    {
        if (!self::$listStatus) {
            self::$listStatus = self::pluck('name', 'id')->all();
        }
        return self::$listStatus;
    }
    public static function mapValue()
    {
        $listStatus = self::getListStatus();
        $new_arr    = [];
        foreach ($listStatus as $key => $value) {
            $new_arr[] = ['value' => $key, 'text' => $value];
        }
        return $new_arr;
    }
}
