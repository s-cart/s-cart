<?php
#S-Cart/Core/Front/Models/ShopCustomFieldDetail.php
namespace App\Pmo\Front\Models;

use Illuminate\Database\Eloquent\Model;
use Cache;

class ShopCustomFieldDetail extends Model
{
    use \App\Pmo\Front\Models\ModelTrait;
    use \App\Pmo\Front\Models\UuidTrait;
    
    public $table          = SC_DB_PREFIX.'shop_custom_field_detail';
    protected $connection  = SC_CONNECTION;
    protected $guarded     = [];

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
                $model->{$model->getKeyName()} = sc_generate_id($type = 'CFD');
            }
        });
    }
}
