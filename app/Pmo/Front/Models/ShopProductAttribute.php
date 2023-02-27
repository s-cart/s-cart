<?php
#s-pmo/Core/Front/Models/ShopProductAttribute.php
namespace App\Pmo\Front\Models;

use Illuminate\Database\Eloquent\Model;

class ShopProductAttribute extends Model
{
    use \App\Pmo\Front\Models\ModelTrait;
    public $timestamps    = false;
    public $table = SC_DB_PREFIX.'shop_product_attribute';
    protected $guarded = [];
    protected $connection = SC_CONNECTION;
    public function attGroup()
    {
        return $this->belongsTo(ShopAttributeGroup::class, 'attribute_group_id', 'id');
    }
}
