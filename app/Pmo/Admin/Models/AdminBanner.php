<?php

namespace App\Pmo\Admin\Models;

use App\Pmo\Front\Models\ShopBanner;
use App\Pmo\Front\Models\ShopBannerStore;

class AdminBanner extends ShopBanner
{
    /**
     * Get banner detail in admin
     *
     * @param   [type]  $id  [$id description]
     *
     * @return  [type]       [return description]
     */
    public static function getBannerAdmin($id, $storeId = null)
    {
        $data = self::where('id', $id);
        if ($storeId) {
            $tableBannerStore = (new ShopBannerStore)->getTable();
            $tableBanner = (new ShopBanner)->getTable();
            $data = $data->leftJoin($tableBannerStore, $tableBannerStore . '.banner_id', $tableBanner . '.id');
            $data = $data->where($tableBannerStore . '.store_id', $storeId);
        }
        $data = $data->first();
        return $data;
    }

    /**
     * Get list banner in admin
     *
     * @param   [array]  $dataSearch  [$dataSearch description]
     *
     * @return  [type]               [return description]
     */
    public static function getBannerListAdmin(array $dataSearch, $storeId = null)
    {
        $sort_order       = $dataSearch['sort_order'] ?? '';
        $arrSort          = $dataSearch['arrSort'] ?? '';
        $keyword          = $dataSearch['keyword'] ?? '';
        $bannerList = (new ShopBanner);
        $tableBanner = $bannerList->getTable();
        if ($storeId) {
            $tableBannerStore = (new ShopBannerStore)->getTable();
            $bannerList = $bannerList->leftJoin($tableBannerStore, $tableBannerStore . '.banner_id', $tableBanner . '.id');
            $bannerList = $bannerList->where($tableBannerStore . '.store_id', $storeId);
        }
        if ($keyword) {
            $bannerList->where($tableBanner.'.title', 'like', '%'.$keyword.'%');
        }
        if ($sort_order && array_key_exists($sort_order, $arrSort)) {
            $field = explode('__', $sort_order)[0];
            $sort_field = explode('__', $sort_order)[1];
            $bannerList = $bannerList->sort($field, $sort_field);
        } else {
            $bannerList = $bannerList->sort($tableBanner.'.created_at', 'desc');
        }
        $bannerList = $bannerList->paginate(20);

        return $bannerList;
    }

    /**
     * Create a new banner
     *
     * @param   array  $dataCreate  [$dataCreate description]
     *
     * @return  [type]              [return description]
     */
    public static function createBannerAdmin(array $dataCreate)
    {
        return self::create($dataCreate);
    }
}
