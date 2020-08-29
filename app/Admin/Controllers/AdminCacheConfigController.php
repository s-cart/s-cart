<?php
#app/Http/Admin/Controllers/AdminCacheConfigController.php
namespace App\Admin\Controllers;

use App\Http\Controllers\Controller;
use App\Models\AdminConfig;
use App\Models\ShopLanguage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
class AdminCacheConfigController extends Controller
{
    public function index()
    {

        $data = [
            'title' => trans('cache.config_manager.title'),
            'subTitle' => '',
            'icon' => 'fa fa-indent',        ];

        $obj = (new AdminConfig)
            ->where('code', 'cache')
            ->where('store_id', 0)
            ->orderBy('sort', 'desc')
            ->get();
        $data['configs'] = $obj;
        return view('admin.screen.cache_config')
            ->with($data);
    }

    /**
     * Clear cache
     *
     * @return  json
     */
    public function clearCache() {
        $arrCacheLocal = $this->cacheMapLocal();
        $data = request()->all();
        $action = $data['action']??'';
        try {
            if ($action == 'cache_all') {
                Cache::flush();
            } else {
                Cache::forget($action);
                if (!empty($arrCacheLocal[$action])) {
                    foreach ($arrCacheLocal[$action] as  $cacheIndex) {
                        Cache::forget($cacheIndex);
                    }
                }
            }
            $error = 0;
            $msg = '';
        } catch (\Throwable $e) {
            $error = 1;
            $msg = $e->getMessage();
        }

        return response()->json(
            [
                'error' => $error,
                'msg' => $msg,
                'action' => $action,
            ]
        );
    }

    /**
     * Mapping cache local
     *
     * @return  [type]  [return description]
     */
    public function cacheMapLocal() {
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

        return $arrCacheLocal;
    }
}
