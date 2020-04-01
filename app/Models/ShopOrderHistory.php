<?php
#app/Models/ShopOrderHistory.php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ShopOrderHistory extends Model
{
    public $table = SC_DB_PREFIX.'shop_order_history';
    protected $connection = SC_CONNECTION;
	const CREATED_AT = 'add_date';
	const UPDATED_AT = null;
    protected $guarded           = [];
}
