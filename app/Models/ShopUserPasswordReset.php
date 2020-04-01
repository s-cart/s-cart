<?php
#app/Models/ShopUserPasswordReset.php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ShopUserPasswordReset extends Model
{
    protected $primaryKey = ['token'];
    public $incrementing  = false;
    protected $guarded    = [];
    public $timestamps    = false;
    public $table = SC_DB_PREFIX.'shop_password_resets';
    protected $connection = SC_CONNECTION;
}
