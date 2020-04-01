<?php
#app/Models/ShopProductCategory.php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ShopProductCategory extends Model
{
    protected $primaryKey = ['category_id', 'product_id'];
    public $incrementing  = false;
    protected $guarded    = [];
    public $timestamps    = false;
    public $table = SC_DB_PREFIX.'shop_product_category';
    protected $connection = SC_CONNECTION;
}
