<?php
#app/Models/ShopProductPromotion.php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\ShopProduct;
class ShopProductPromotion extends Model
{
    public $table = SC_DB_PREFIX.'shop_product_promotion';
    protected $guarded    = [];
    protected $primaryKey = ['product_id'];
    public $incrementing  = false;
    protected $connection = SC_CONNECTION;

    public function product()
    {
        return $this->belongsTo(ShopProduct::class, 'product_id', 'id');
    }

}
