<?php
#app/Models/ShopBannerStore.php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ShopBannerStore extends Model
{
    protected $primaryKey = ['store_id', 'banner_id'];
    public $incrementing  = false;
    protected $guarded    = [];
    public $timestamps    = false;
    public $table = SC_DB_PREFIX.'shop_banner_store';
    protected $connection = SC_CONNECTION;
}
