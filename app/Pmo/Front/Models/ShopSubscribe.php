<?php
#S-Cart/Core/Front/Models/ShopSubscribe.php
namespace App\Pmo\Front\Models;

use Illuminate\Database\Eloquent\Model;

class ShopSubscribe extends Model
{
    use \App\Pmo\Front\Models\ModelTrait;
    use \App\Pmo\Front\Models\UuidTrait;

    public $table = SC_DB_PREFIX.'shop_subscribe';
    protected $guarded      = [];
    protected $connection = SC_CONNECTION;

    protected static function boot()
    {
        parent::boot();
        // before delete() method call this
        static::deleting(
            function ($model) {
            //
            }
        );
        //Uuid
        static::creating(function ($model) {
            if (empty($model->{$model->getKeyName()})) {
                $model->{$model->getKeyName()} = sc_generate_id($type = 'shop_subscribe');
            }
        });
    }
}
