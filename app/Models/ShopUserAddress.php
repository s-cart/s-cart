<?php
#app/Models/ShopUserAddress.php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ShopUserAddress extends Model
{
    protected $guarded    = [];
    public $timestamps    = false;
    public $table = SC_DB_PREFIX.'shop_user_address';
    protected $connection = SC_CONNECTION;
}
