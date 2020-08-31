<?php
#app/Models/ShopNewsStore.php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ShopNewsStore extends Model
{
    protected $primaryKey = ['store_id', 'news_id'];
    public $incrementing  = false;
    protected $guarded    = [];
    public $timestamps    = false;
    public $table = SC_DB_PREFIX.'shop_news_store';
    protected $connection = SC_CONNECTION;
}
