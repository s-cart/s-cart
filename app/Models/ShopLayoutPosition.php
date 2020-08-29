<?php
#app/Models/ShopLayoutPosition.php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ShopLayoutPosition extends Model
{
    public $timestamps = false;
    public $table = SC_DB_PREFIX.'shop_layout_position';
    protected $connection = SC_CONNECTION;
    
    public static function getPositions()
    {
        return self::pluck('name', 'key')->all();
    }
}
