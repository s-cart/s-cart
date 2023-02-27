<?php
#s-pmo/Core/Front/Models/ShopBannerType.php
namespace App\Pmo\Front\Models;

use Illuminate\Database\Eloquent\Model;

class ShopBannerType extends Model
{
    use \App\Pmo\Front\Models\ModelTrait;
    
    public $table = SC_DB_PREFIX.'shop_banner_type';
    protected $guarded   = [];
    protected $connection = SC_CONNECTION;
}
