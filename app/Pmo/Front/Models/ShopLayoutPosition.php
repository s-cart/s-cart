<?php
#S-Cart/Core/Front/Models/ShopLayoutPosition.php
namespace App\Pmo\Front\Models;

use Illuminate\Database\Eloquent\Model;

class ShopLayoutPosition extends Model
{
    use \App\Pmo\Front\Models\ModelTrait;
    
    public $table = SC_DB_PREFIX.'shop_layout_position';
    protected $connection = SC_CONNECTION;
    
    public static function getPositions()
    {
        return self::pluck('name', 'key')->all();
    }
}
