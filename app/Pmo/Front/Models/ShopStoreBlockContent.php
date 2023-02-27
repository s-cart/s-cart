<?php
#S-Cart/Core/Front/Models/ShopStoreBlockContent.php
namespace App\Pmo\Front\Models;

use Illuminate\Database\Eloquent\Model;
use App\Pmo\Front\Models\ShopStore;
class ShopStoreBlockContent extends Model
{
    use \App\Pmo\Front\Models\ModelTrait;
    use \App\Pmo\Front\Models\UuidTrait;

    public $table = SC_DB_PREFIX.'shop_store_block';
    protected $guarded = [];
    private static $getLayout = null;
    protected $connection = SC_CONNECTION;
    public $incrementing  = false;
    
    public static function getLayout()
    {
        if (self::$getLayout === null) {
            $store = ShopStore::find(config('app.storeId'));
            $template = '';
            if ($store) {
                $template = $store->template;
            }
            self::$getLayout = self::where('status', 1)
                ->where('store_id', config('app.storeId'))
                ->where('template', $template)
                ->orderBy('sort', 'asc')
                ->get()
                ->groupBy('position');
        }
        return self::$getLayout;
    }

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
                $model->{$model->getKeyName()} = sc_generate_id($type = 'shop_store_block');
            }
        });
    }
}
