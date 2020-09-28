<?php
#app/Models/ShopStoreCss.php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ShopStoreCss extends Model
{
    protected $primaryKey = 'store_id';
    public $incrementing  = false;
    protected $guarded    = [];
    public $timestamps    = false;
    public $table = SC_DB_PREFIX.'shop_store_css';
    protected $connection = SC_CONNECTION;
}
