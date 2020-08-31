<?php
#app/Models/ShopProductStore.php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ShopProductStore extends Model
{
    protected $primaryKey = ['store_id', 'product_id'];
    public $incrementing  = false;
    protected $guarded    = [];
    public $timestamps    = false;
    public $table = SC_DB_PREFIX.'shop_product_store';
    protected $connection = SC_CONNECTION;
}
