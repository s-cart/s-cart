<?php
#S-Cart/Core/Front/Models/ShopStoreCss.php
namespace App\Pmo\Front\Models;

use Illuminate\Database\Eloquent\Model;

class ShopStoreCss extends Model
{
    use \App\Pmo\Front\Models\ModelTrait;

    protected $primaryKey = 'store_id';
    public $incrementing  = false;
    protected $guarded    = [];
    public $table = SC_DB_PREFIX.'shop_store_css';
    protected $connection = SC_CONNECTION;

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
