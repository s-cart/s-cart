<?php
#app/Models/ShopCountry.php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ShopCountry extends Model
{
    public $table = SC_DB_PREFIX.'shop_country';
    public $timestamps               = false;
    private static $getCountries     = null;
    private static $getListCountries = null;
    protected $connection = SC_CONNECTION;

    public static function getList()
    {
        if (self::$getListCountries == null) {
            self::$getListCountries = self::get()->keyBy('code');
        }
        return self::$getListCountries;
    }

    public static function getArray()
    {
        if (self::$getCountries == null) {
            self::$getCountries = self::pluck('name', 'code')->all();
        }
        return self::$getCountries;
    }

    public static function mapValue()
    {
        $listCountry = self::getArray();
        $new_arr     = [];
        foreach ($listCountry as $key => $value) {
            $new_arr[] = ['value' => $key, 'text' => $value];
        }
        return $new_arr;
    }
}
