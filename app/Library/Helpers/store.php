<?php
use Illuminate\Support\Str;
/**
 * Get list store
 */
if (!function_exists('sc_get_list_code_store') && !in_array('sc_get_list_code_store', config('helper_except', []))) {
    function sc_get_list_code_store()
    {
        return \App\Pmo\Admin\Models\AdminStore::getListStoreCode();
    }
}


/**
 * Get domain from code
 */
if (!function_exists('sc_get_domain_from_code') && !in_array('sc_get_domain_from_code', config('helper_except', []))) {
    function sc_get_domain_from_code(string $code = null):string
    {
        $domainList = \App\Pmo\Admin\Models\AdminStore::getStoreDomainByCode();
        if (!empty($domainList[$code])) {
            return 'http://'.$domainList[$code];
        } else {
            return url('/');
        }
    }
}

/**
 * Get domain root
 */
if (!function_exists('sc_get_domain_root') && !in_array('sc_get_domain_root', config('helper_except', []))) {
    function sc_get_domain_root():string
    {
        $store = \App\Pmo\Admin\Models\AdminStore::find(SC_ID_ROOT);
        return $store->domain;
    }
}

/**
 * Check store is partner
 */
if (!function_exists('sc_store_is_partner') && !in_array('sc_store_is_partner', config('helper_except', []))) {
    function sc_store_is_partner(string $storeId):bool
    {
        $store = \App\Pmo\Admin\Models\AdminStore::find($storeId);
        if (!$store) {
            return false;
        }
        return $store->partner || $storeId == SC_ID_ROOT;
    }
}

/**
 * Check store is root
 */
if (!function_exists('sc_store_is_root') && !in_array('sc_store_is_root', config('helper_except', []))) {
    function sc_store_is_root(string $storeId):bool
    {
        return  $storeId == SC_ID_ROOT;
    }
}


//======== store info============

/**
 * Get list store of product detail
 */
if (!function_exists('sc_get_list_store_of_product_detail') && !in_array('sc_get_list_store_of_product_detail', config('helper_except', []))) {
    function sc_get_list_store_of_product_detail($pId):array
    {
        return \App\Pmo\Front\Models\ShopProductStore::where('product_id', $pId)
        ->pluck('store_id')
        ->toArray();
    }
}


/**
 * Get list store of discount detail
 */
if (!function_exists('sc_get_list_store_of_discount_detail') && !in_array('sc_get_list_store_of_discount_detail', config('helper_except', []))) {
    function sc_get_list_store_of_discount_detail($dId):array
    {
        return \App\Plugins\Total\Discount\Models\ShopDiscountStore::where('discount_id', $dId)
            ->pluck('store_id')
            ->toArray();
    }
}


/**
 * Get store list of brands
 */
if (!function_exists('sc_get_list_store_of_brand') && !in_array('sc_get_list_store_of_brand', config('helper_except', []))) {
    function sc_get_list_store_of_brand(array $arrBrandId)
    {
        $tableStore = (new \App\Pmo\Admin\Models\AdminStore)->getTable();
        $tableBrandStore = (new \App\Pmo\Front\Models\ShopBrandStore)->getTable();
        return \App\Pmo\Front\Models\ShopBrandStore::select($tableStore.'.code', $tableStore.'.id', 'brand_id')
            ->leftJoin($tableStore, $tableStore.'.id', $tableBrandStore.'.store_id')
            ->whereIn('brand_id', $arrBrandId)
            ->get()
            ->groupBy('brand_id');
    }
}


/**
 * Get list store of brand detail
 */
if (!function_exists('sc_get_list_store_of_brand_detail') && !in_array('sc_get_list_store_of_brand_detail', config('helper_except', []))) {
    function sc_get_list_store_of_brand_detail($cId):array
    {
        return \App\Pmo\Front\Models\ShopBrandStore::where('brand_id', $cId)
            ->pluck('store_id')
            ->toArray();
    }
}

/**
 * Get store list of banners
 */
if (!function_exists('sc_get_list_store_of_banner') && !in_array('sc_get_list_store_of_banner', config('helper_except', []))) {
    function sc_get_list_store_of_banner(array $arrBannerId)
    {
        $tableStore = (new \App\Pmo\Admin\Models\AdminStore)->getTable();
        $tableBannerStore = (new \App\Pmo\Front\Models\ShopBannerStore)->getTable();
        return \App\Pmo\Front\Models\ShopBannerStore::select($tableStore.'.code', $tableStore.'.id', 'banner_id')
            ->leftJoin($tableStore, $tableStore.'.id', $tableBannerStore.'.store_id')
            ->whereIn('banner_id', $arrBannerId)
            ->get()
            ->groupBy('banner_id');
    }
}

/**
 * Get list store of banner detail
 */
if (!function_exists('sc_get_list_store_of_banner_detail') && !in_array('sc_get_list_store_of_banner_detail', config('helper_except', []))) {
    function sc_get_list_store_of_banner_detail($bId):array
    {
        return \App\Pmo\Front\Models\ShopBannerStore::where('banner_id', $bId)
            ->pluck('store_id')
            ->toArray();
    }
}

/**
 * Get store list of news
 */
if (!function_exists('sc_get_list_store_of_news') && !in_array('sc_get_list_store_of_news', config('helper_except', []))) {
    function sc_get_list_store_of_news(array $arrNewsId)
    {
        $tableStore = (new \App\Pmo\Admin\Models\AdminStore)->getTable();
        $tableNewsStore = (new \App\Pmo\Front\Models\ShopNewsStore)->getTable();
        return \App\Pmo\Front\Models\ShopNewsStore::select($tableStore.'.code', $tableStore.'.id', 'news_id')
            ->leftJoin($tableStore, $tableStore.'.id', $tableNewsStore.'.store_id')
            ->whereIn('news_id', $arrNewsId)
            ->get()
            ->groupBy('news_id');
    }
}

/**
 * Get list store of news detail
 */
if (!function_exists('sc_get_list_store_of_news_detail') && !in_array('sc_get_list_store_of_news_detail', config('helper_except', []))) {
    function sc_get_list_store_of_news_detail($nId):array
    {
        return \App\Pmo\Front\Models\ShopNewsStore::where('news_id', $nId)
            ->pluck('store_id')
            ->toArray();
    }
}

/**
 * Get store list of pages
 */
if (!function_exists('sc_get_list_store_of_page') && !in_array('sc_get_list_store_of_page', config('helper_except', []))) {
    function sc_get_list_store_of_page(array $arrPageId)
    {
        $tableStore = (new \App\Pmo\Admin\Models\AdminStore)->getTable();
        $tablePageStore = (new \App\Pmo\Front\Models\ShopPageStore)->getTable();
        return \App\Pmo\Front\Models\ShopPageStore::select($tableStore.'.code', $tableStore.'.id', 'page_id')
            ->leftJoin($tableStore, $tableStore.'.id', $tablePageStore.'.store_id')
            ->whereIn('page_id', $arrPageId)
            ->get()
            ->groupBy('page_id');
    }
}

/**
 * Get list store of page detail
 */
if (!function_exists('sc_get_list_store_of_page_detail') && !in_array('sc_get_list_store_of_page_detail', config('helper_except', []))) {
    function sc_get_list_store_of_page_detail($pId):array
    {
        return \App\Pmo\Front\Models\ShopPageStore::where('page_id', $pId)
            ->pluck('store_id')
            ->toArray();
    }
}

/**
 * Get store list of links
 */
if (!function_exists('sc_get_list_store_of_link') && !in_array('sc_get_list_store_of_link', config('helper_except', []))) {
    function sc_get_list_store_of_link($arrLinkId)
    {
        $tableStore = (new \App\Pmo\Admin\Models\AdminStore)->getTable();
        $tableLinkStore = (new \App\Pmo\Front\Models\ShopLinkStore)->getTable();
        return \App\Pmo\Front\Models\ShopLinkStore::select($tableStore.'.code', $tableStore.'.id', 'link_id')
            ->leftJoin($tableStore, $tableStore.'.id', $tableLinkStore.'.store_id')
            ->whereIn('link_id', $arrLinkId)
            ->get()
            ->groupBy('link_id');
    }
}

/**
 * Get list store of link detail
 */
if (!function_exists('sc_get_list_store_of_link_detail') && !in_array('sc_get_list_store_of_link_detail', config('helper_except', []))) {
    function sc_get_list_store_of_link_detail($cId)
    {
        return \App\Pmo\Front\Models\ShopLinkStore::where('link_id', $cId)
            ->pluck('store_id')
            ->toArray();
    }
}

/**
 * Get store list of orders
 */
if (!function_exists('sc_get_list_store_of_order') && !in_array('sc_get_list_store_of_order', config('helper_except', []))) {
    function sc_get_list_store_of_order(array $arrOrderId)
    {
        $tableStore = (new \App\Pmo\Admin\Models\AdminStore)->getTable();
        $tableOrder = (new \App\Pmo\Front\Models\ShopOrder)->getTable();
        return \App\Pmo\Front\Models\ShopOrder::select($tableStore.'.code', $tableOrder.'.id')
            ->leftJoin($tableStore, $tableStore.'.id', $tableOrder.'.store_id')
            ->whereIn($tableOrder.'.id', $arrOrderId)
            ->get()
            ->groupBy('id');
    }
}

/**
 * Get store list of categories
 */
if (!function_exists('sc_get_list_store_of_category') && !in_array('sc_get_list_store_of_category', config('helper_except', []))) {
    function sc_get_list_store_of_category(array $arrCategoryId)
    {
        $tableStore = (new \App\Pmo\Admin\Models\AdminStore)->getTable();
        $tableCategoryStore = (new \App\Pmo\Front\Models\ShopCategoryStore)->getTable();
        return \App\Pmo\Front\Models\ShopCategoryStore::select($tableStore.'.code', $tableStore.'.id', 'category_id')
            ->leftJoin($tableStore, $tableStore.'.id', $tableCategoryStore.'.store_id')
            ->whereIn('category_id', $arrCategoryId)
            ->get()
            ->groupBy('category_id');
    }
}


/**
 * Get list store of category detail
 */
if (!function_exists('sc_get_list_store_of_category_detail') && !in_array('sc_get_list_store_of_category_detail', config('helper_except', []))) {
    function sc_get_list_store_of_category_detail($cId):array
    {
        return \App\Pmo\Front\Models\ShopCategoryStore::where('category_id', $cId)
            ->pluck('store_id')
            ->toArray();
    }
}

if (!function_exists('sc_process_domain_store') && !in_array('sc_process_domain_store', config('helper_except', []))) {
    /**
     * Process domain store
     *
     * @param   [string]  $domain
     *
     * @return  [string]         [$domain]
     */
    function sc_process_domain_store(string $domain = null)
    {
        $domain = str_replace(['http://', 'https://'], '', $domain);
        $domain = Str::lower($domain);
        $domain = rtrim($domain, '/');
        return $domain;
    }
}

if (!function_exists('sc_check_multi_shop_installed') && !in_array('sc_check_multi_shop_installed', config('helper_except', []))) {
/**
 * Check plugin multi shop installed
 *
 * @return
 */
    function sc_check_multi_shop_installed()
    {
        return 
        sc_config_global('MultiVendorPro') 
        || sc_config_global('MultiVendor') 
        || sc_config_global('B2B') 
        || sc_config_global('MultiStorePro')
        || sc_config_global('MultiStore');
    }
}

if (!function_exists('sc_check_multi_vendor_installed') && !in_array('sc_check_multi_vendor_installed', config('helper_except', []))) {
    /**
     * Check plugin multi vendor installed
     *
     * @return
     */
        function sc_check_multi_vendor_installed()
        {
            return sc_config_global('MultiVendorPro') || sc_config_global('B2B') || sc_config_global('MultiVendor');
        }
}

if (!function_exists('sc_check_multi_store_installed') && !in_array('sc_check_multi_store_installed', config('helper_except', []))) {
    /**
     * Check plugin multi store installed
     *
     * @return
     */
        function sc_check_multi_store_installed()
        {
            return sc_config_global('MultiStorePro');
        }
}

if (!function_exists('sc_link_vendor') && !in_array('sc_link_vendor', config('helper_except', []))) {
    /**
     * Link vendor
     *
     * @return
     */
        function sc_link_vendor(string $code = null)
        {
            $link = sc_route('home');
            if (sc_config_global('MultiVendorPro')) {
                $link = sc_route('MultiVendorPro.detail', ['code' => $code]);
            }
            if (sc_config_global('MultiVendor')) {
                $link = sc_route('MultiVendor.detail', ['code' => $code]);
            }
            if (sc_config_global('B2B')) {
                $link = sc_route('B2B.detail', ['code' => $code]);
            }
            return $link;
        }
}


if (!function_exists('sc_path_vendor') && !in_array('sc_path_vendor', config('helper_except', []))) {
    /**
     * Path vendor
     *
     * @return
     */
        function sc_path_vendor()
        {
            $path = 'vendor';
            if (sc_config_global('MultiVendorPro')) {
                $path = config('MultiVendorPro.front_path');
            }
            if (sc_config_global('MultiVendor')) {
                $path = config('MultiVendor.front_path');
            }
            if (sc_config_global('B2B')) {
                $path = config('B2B.front_path');
            }
            return $path;
        }
}

/**
 * Get sum amount order
 * From S-Cart 6.9
 */
if (!function_exists('sc_get_sum_amount_order') && !in_array('sc_get_sum_amount_order', config('helper_except', []))) {
    function sc_get_sum_amount_order($storeId = null)
    {
        return  (new \App\Pmo\Admin\Models\AdminOrder)->getSumAmountOrder($storeId);
    }
}