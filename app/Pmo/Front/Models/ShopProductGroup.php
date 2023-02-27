<?php
#s-pmo/Core/Front/Models/ShopProductGroup.php
namespace App\Pmo\Front\Models;

use Illuminate\Database\Eloquent\Model;
use App\Pmo\Front\Models\ShopProduct;

class ShopProductGroup extends Model
{
    use \App\Pmo\Front\Models\ModelTrait;
    
    protected $primaryKey = ['group_id', 'product_id'];
    public $incrementing  = false;
    protected $guarded    = [];
    public $timestamps    = false;
    public $table = SC_DB_PREFIX.'shop_product_group';
    protected $connection = SC_CONNECTION;

    public function product()
    {
        return $this->belongsTo(ShopProduct::class, 'product_id', 'id');
    }
}
