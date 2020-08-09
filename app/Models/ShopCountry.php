<?php
#app/Models/ShopCountry.php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Cache;

class ShopCountry extends Model
{
    public $table = SC_DB_PREFIX.'shop_country';
    public $timestamps               = false;
    private static $getListCountries = null;
    protected $connection = SC_CONNECTION;

    public static function getListAll()
    {
        if (self::$getListCountries == null) {
            self::$getListCountries = self::get()->keyBy('code');
        }
        return self::$getListCountries;
    }

    public static function getCodeAll()
    {
        if (!Cache::has('cache_country')) {
            $allCode = self::pluck('name', 'code')->all();
            Cache::put('cache_country', $allCode, $seconds = sc_config('cache_time')?:600);
        }
        return Cache::get('cache_country');
    }
}
