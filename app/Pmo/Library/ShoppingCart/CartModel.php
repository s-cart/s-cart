<?php
namespace App\Pmo\Library\ShoppingCart;

use Illuminate\Database\Eloquent\Model;

class CartModel extends Model
{
    protected $primaryKey = null;
    public $incrementing  = false;
    public $table = SC_DB_PREFIX.'shop_shoppingcart';
    protected $guarded = [];
    protected $connection = SC_CONNECTION;
}
