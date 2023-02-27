<?php
#s-pmo/Core/Front/Models/ShopProductImage.php
namespace App\Pmo\Front\Models;

use Illuminate\Database\Eloquent\Model;

class ShopProductImage extends Model
{
    use \App\Pmo\Front\Models\ModelTrait;
    use \App\Pmo\Front\Models\UuidTrait;

    public $timestamps = false;
    public $table = SC_DB_PREFIX.'shop_product_image';
    protected $guarded = [];
    protected $connection = SC_CONNECTION;

    /*
    Get thumb
     */
    public function getThumb()
    {
        return sc_image_get_path_thumb($this->image);
    }

    /*
    Get image
     */
    public function getImage()
    {
        return sc_image_get_path($this->image);
    }

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
                $model->{$model->getKeyName()} = sc_generate_id($type = 'shop_product_image');
            }
        });
    }
}
