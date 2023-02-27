<?php

use App\Pmo\Front\Models\ShopLanguage;
use \Illuminate\Support\Facades\Cache;

if (!function_exists('sc_clear_cache') && !in_array('sc_clear_cache', config('helper_except', []))) {
    /**
     * Clear cache
     *
     * @param   [string]  $domain
     *
     * @return  [string]         [$domain]
     */
    function sc_clear_cache($typeCache = 'cache_all', $storeId = null)
    {
        try {
            $storeI = $storeId ?? session('adminStoreId');
            if ($typeCache == 'cache_all') {
                Cache::flush();
            } else {
                $arrCacheLocal = [];
                $arrLang = ShopLanguage::getCodeAll();
                foreach ($arrLang as $code => $name) {
                    $arrCacheLocal['cache_category'][] = 'cache_category_'.$code;
                    $arrCacheLocal['cache_product'][] = 'cache_product_'.$code;
                    $arrCacheLocal['cache_news'][] = 'cache_news_'.$code;
                    $arrCacheLocal['cache_category_cms'][] = 'cache_category_cms_'.$code;
                    $arrCacheLocal['cache_content_cms'][] = 'cache_content_cms_'.$code;
                    $arrCacheLocal['cache_page'][] = 'cache_page_'.$code;
                }
                Cache::forget($typeCache);
                if (!empty($arrCacheLocal[$typeCache])) {
                    foreach ($arrCacheLocal[$typeCache] as  $cacheIndex) {
                        Cache::forget($cacheIndex);
                        Cache::forget($storeI.'_'.$cacheIndex);
                    }
                }
            }
            $response = ['error' => 0, 'msg' => 'Clear success!', 'action' => $typeCache];
        } catch (\Throwable $e) {
            $response = ['error' => 1, 'msg' => $e->getMessage(), 'action' => $typeCache];
        }
        return $response;
    }
}

if (!function_exists('sc_set_cache') && !in_array('sc_set_cache', config('helper_except', []))) {
    /**
     * [sc_set_cache description]
     *
     * @param   [string]$cacheIndex  [$cacheIndex description]
     * @param   [type]$value       [$value description]
     * @param   [seconds]$time        [$time description]
     * @param   null               [ description]
     *
     * @return  [type]             [return description]
     */
    function sc_set_cache($cacheIndex, $value, $time = null)
    {
        if (empty($cacheIndex)) {
            return ;
        }
        $seconds = $time ?? (sc_config_global('cache_time') ?? 600);
        
        Cache::put($cacheIndex, $value, $seconds);
    }
}
