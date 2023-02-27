<?php
#s-pmo/Core/Front/Models/ShopPageStore.php
namespace App\Pmo\Front\Models;

use Illuminate\Database\Eloquent\Model;

class ShopPageStore extends Model
{
    use \App\Pmo\Front\Models\ModelTrait;
    
    protected $primaryKey = ['store_id', 'page_id'];
    public $incrementing  = false;
    protected $guarded    = [];
    public $timestamps    = false;
    public $table = SC_DB_PREFIX.'shop_page_store';
    protected $connection = SC_CONNECTION;
}
