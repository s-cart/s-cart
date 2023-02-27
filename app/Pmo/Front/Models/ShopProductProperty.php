<?php
#S-Cart/Core/Front/Models/ShopProductProperty.php
namespace App\Pmo\Front\Models;

use Illuminate\Database\Eloquent\Model;

class ShopProductProperty extends Model
{
    use \App\Pmo\Front\Models\ModelTrait;
    
    public $table = SC_DB_PREFIX.'shop_product_property';
    protected $guarded   = [];
    protected $connection = SC_CONNECTION;
}
