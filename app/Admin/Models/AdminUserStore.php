<?php
#app/Models/AdminUserStore.php
namespace App\Admin\Models;

use Illuminate\Database\Eloquent\Model;

class AdminUserStore extends Model
{
    protected $primaryKey = ['store_id', 'user_id'];
    public $incrementing  = false;
    protected $guarded    = [];
    public $timestamps    = false;
    public $table = SC_DB_PREFIX.'admin_user_store';
    protected $connection = SC_CONNECTION;
}
