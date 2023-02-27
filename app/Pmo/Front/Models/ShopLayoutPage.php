<?php
#s-pmo/Core/Front/Models/ShopLayoutPage.php
namespace App\Pmo\Front\Models;

use Illuminate\Database\Eloquent\Model;

class ShopLayoutPage extends Model
{
    use \App\Pmo\Front\Models\ModelTrait;

    public $table = SC_DB_PREFIX.'shop_layout_page';
    protected $connection = SC_CONNECTION;

    public static function getPages()
    {
        return self::pluck('name', 'key')->all();
    }

    //Function get text description
    protected static function boot()
    {
        parent::boot();
        // before delete() method call this
        static::deleting(
            function ($obj) {
                //
            }
        );
    }
}
