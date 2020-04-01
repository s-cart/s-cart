<?php
#app/Models/ShopProductAttribute.php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ShopProductAttribute extends Model
{
    public $timestamps = false;
    public $table = SC_DB_PREFIX.'shop_product_attribute';
    protected $guarded = [];
    protected $connection = SC_CONNECTION;
    public function attGroup()
    {
        return $this->belongsTo(ShopAttributeGroup::class, 'attribute_group_id', 'id');
    }
}
