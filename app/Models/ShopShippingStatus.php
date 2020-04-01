<?php
#App\Models\ShopShippingStatus.php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ShopShippingStatus extends Model
{
    public $timestamps  = false;
    public $table = SC_DB_PREFIX.'shop_shipping_status';
    protected $guarded           = [];
    protected static $listStatus = null;
    protected $connection = SC_CONNECTION;
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
