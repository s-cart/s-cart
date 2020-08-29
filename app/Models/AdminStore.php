<?php
#app/Models/AdminStore.php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Cache;
class AdminStore extends Model
{
    public $timestamps = false;
    public $table = SC_DB_PREFIX.'admin_store';
    protected $guarded = [];
    protected static $getAll = null;
    protected $connection = SC_CONNECTION;
    
    public function descriptions()
    {
        return $this->hasMany(AdminStoreDescription::class, 'store_id', 'id');
    }

    public function products()
    {
        return $this->belongsToMany(ShopProduct::class, ShopProductStore::class, 'store_id', 'product_id');
    }

    public function categories()
    {
        return $this->belongsToMany(ShopCategory::class, ShopCategoryStore::class, 'store_id', 'category_id');
    }


    public function banners()
    {
        return $this->belongsToMany(ShopBanner::class, ShopBannerStore::class, 'store_id', 'banner_id');
    }

    public function news()
    {
        return $this->belongsToMany(ShopNews::class, ShopNewsStore::class, 'store_id', 'news_id');
    }

    public function pages()
    {
        return $this->belongsToMany(ShopPage::class, ShopPageStore::class, 'store_id', 'page_id');
    }


    protected static function boot()
    {
        parent::boot();
        // before delete() method call this
        static::deleting(function ($store) {
            //Store id 1 is default
            if ($store->id == 1) {
                return false;
            }
            //Delete store descrition
            $store->descriptions()->delete();
            $store->products()->delete();
            $store->categories()->delete();
            $store->banners()->delete();
            $store->news()->delete();
            $store->pages()->delete();
            AdminConfig::where('store_id', $store->id)->delete();
        });
    }


    /**
     * [getAll description]
     *
     * @return  [type]  [return description]
     */
    public static function getListAll()
    {
        if (self::$getAll === null) {
            self::$getAll = self::with('descriptions')
                ->get()
                ->keyBy('id');
        }
        return self::$getAll;
    }

    /**
     * Get all template used
     *
     * @return  [type]  [return description]
     */
    public static function getAllTemplateUsed() {
        return self::pluck('template')->all();
    }

    /**
     * Get all domain and id store
     *
     * @return  [array]  [return description]
     */
    public static function getDomain()
    {
        return self::where('status', 1)
            ->pluck('domain', 'id')
            ->all();
    }

}
