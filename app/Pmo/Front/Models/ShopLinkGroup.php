<?php
#s-pmo/Core/Front/Models/ShopLinkGroup.php
namespace App\Pmo\Front\Models;

use Illuminate\Database\Eloquent\Model;

class ShopLinkGroup extends Model
{
    use \App\Pmo\Front\Models\ModelTrait;
    
    public $table = SC_DB_PREFIX.'shop_link_group';
    protected $guarded   = [];
    protected $connection = SC_CONNECTION;
}
