<?php
#S-Cart/Core/Front/Models/ShopCustomField.php
namespace App\Pmo\Front\Models;

use Illuminate\Database\Eloquent\Model;
use App\Pmo\Front\Models\ShopCustomFieldDetail;

class ShopCustomField extends Model
{
    use \App\Pmo\Front\Models\ModelTrait;
    use \App\Pmo\Front\Models\UuidTrait;
    
    public $table          = SC_DB_PREFIX.'shop_custom_field';
    protected $connection  = SC_CONNECTION;
    protected $guarded     = [];

    public function details()
    {
        $data  = (new ShopCustomFieldDetail)->where('custom_field_id', $this->id)
            ->get();
        return $data;
    }

    /**
     * Get custom fields
     */
    public function getCustomField($type)
    {
        return $this->where('type', $type)
            ->where('status', 1)
            ->get();
    }

    //Function get text description
    protected static function boot()
    {
        parent::boot();
        // before delete() method call this
        static::deleting(
            function ($obj) {
                //
            }
        );

        //Uuid
        static::creating(function ($model) {
            if (empty($model->{$model->getKeyName()})) {
                $model->{$model->getKeyName()} = sc_generate_id($type = 'shop_custom_field');
            }
        });
    }
}
