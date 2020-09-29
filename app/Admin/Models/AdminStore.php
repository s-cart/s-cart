<?php
#app/Admin/Models/AdminStore.php
namespace App\Admin\Models;

use App\Models\ShopStore;
use App\Models\ShopStoreDescription;

class AdminStore extends ShopStore
{
    
    /**
     * Get all template used
     *
     * @return  [type]  [return description]
     */
    public static function getAllTemplateUsed() {
        return self::pluck('template')->all();
    }

    public static function insertDescription(array $data) {
        return ShopStoreDescription::insert($data);
    }

    public static function updateDescription(array $data) {
        return ShopStoreDescription::where('store_id', $data['storeId'])
        ->where('lang', $data['lang'])
        ->update([$data['name'] => $data['value']]);
    }
}
