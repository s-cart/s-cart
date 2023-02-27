<?php
#s-pmo/Core/Front/Models/ShopProductCategory.php
namespace App\Pmo\Front\Models;

use Illuminate\Database\Eloquent\Model;

class ShopProductCategory extends Model
{
    use \App\Pmo\Front\Models\ModelTrait;
    
    protected $primaryKey = ['category_id', 'product_id'];
    public $incrementing  = false;
    protected $guarded    = [];
    public $timestamps    = false;
    public $table = SC_DB_PREFIX.'shop_product_category';
    protected $connection = SC_CONNECTION;
}
