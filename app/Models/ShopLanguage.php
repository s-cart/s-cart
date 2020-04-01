<?php
#app/Models/ShopLanguage.php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ShopLanguage extends Model
{
    public $table = SC_DB_PREFIX.'shop_language';
    public $timestamps                = false;
    protected $guarded                = [];
    private static $getLanguages      = null;
    private static $getArrayLanguages = null;
    private static $getCodeActive = null;
    protected $connection = SC_CONNECTION;

    public static function getList()
    {
        if (self::$getLanguages == null) {
            self::$getLanguages = self::where('status', 1)
                ->get()
                ->keyBy('code');
        }
        return self::$getLanguages;
    }

    public static function getCodeActive()
    {
        if (self::$getCodeActive == null) {
            self::$getCodeActive = self::where('status', 1)->pluck('name', 'code')->all();
        }
        return self::$getCodeActive;
    }

    public static function getArray()
    {
        if (self::$getArrayLanguages == null) {
            self::$getArrayLanguages = self::pluck('name', 'code')->all();
        }
        return self::$getArrayLanguages;
    }
    protected static function boot() {
        parent::boot();
        static::deleting(function ($model) {
            if(in_array($model->id, SC_GUARD_LANGUAGE)){
                return false;
            }
        });
    }
}
