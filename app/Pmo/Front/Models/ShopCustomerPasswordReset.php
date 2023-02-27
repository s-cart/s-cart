<?php
#s-pmo/Core/Front/Models/ShopCustomerPasswordReset.php
namespace App\Pmo\Front\Models;

use Illuminate\Database\Eloquent\Model;

class ShopCustomerPasswordReset extends Model
{
    use \App\Pmo\Front\Models\ModelTrait;
    
    protected $primaryKey = ['token'];
    public $incrementing  = false;
    protected $guarded    = [];
    public $timestamps    = false;
    public $table = SC_DB_PREFIX.'shop_password_resets';
    protected $connection = SC_CONNECTION;
}
