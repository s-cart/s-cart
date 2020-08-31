<?php
#app/Models/ShopCategoryStore.php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ShopCategoryStore extends Model
{
    protected $primaryKey = ['store_id', 'category_id'];
    public $incrementing  = false;
    protected $guarded    = [];
    public $timestamps    = false;
    public $table = SC_DB_PREFIX.'shop_category_store';
    protected $connection = SC_CONNECTION;
}
