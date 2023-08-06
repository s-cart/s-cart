<?php
namespace App\Plugins\Total\Discount\Models;

use Illuminate\Database\Eloquent\Model;

class ShopDiscountStore extends Model
{
    use \SCart\Core\Front\Models\UuidTrait;
    
    protected $primaryKey = ['store_id', 'discount_id'];
    public $incrementing  = false;
    protected $guarded    = [];
    public $timestamps    = false;
    public $table = SC_DB_PREFIX.'shop_discount_store';
    protected $connection = SC_CONNECTION;

    protected static function boot()
    {
        parent::boot();
        // before delete() method call this
        static::deleting(function ($model) {
            //
        });
    }
}
