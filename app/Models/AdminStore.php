<?php
#app/Models/AdminStore.php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AdminStore extends Model
{
    public $timestamps = false;
    public $table = SC_DB_PREFIX.'admin_store';
    protected $guarded = [];
    protected static $getAll = null;
    protected $connection = SC_CONNECTION;
    
    public function descriptions()
    {
        return $this->hasMany(AdminStoreDescription::class, 'config_id', 'id');
    }
    public static function getData($id = 1)
    {
        if (self::$getAll == null) {
            self::$getAll = self::with('descriptions')->find($id);
        }
        return self::$getAll;
    }
}
