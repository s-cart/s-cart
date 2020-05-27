<?php
#app/Http/Admin/Controllers/AdminCacheConfigController.php
namespace App\Admin\Controllers;

use App\Http\Controllers\Controller;
use App\Models\AdminConfig;
use Illuminate\Http\Request;
use App\Admin\AdminConfigTrait;
use Illuminate\Support\Facades\Cache;
class AdminCacheConfigController extends Controller
{
    use AdminConfigTrait;
    public function index()
    {

        $data = [
            'title' => trans('cache.config_manager.title'),
            'subTitle' => '',
            'icon' => 'fa fa-indent',        ];

        $obj = (new AdminConfig)
            ->where('code', 'cache')
            ->orderBy('sort', 'desc')->get();
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

        $data = request()->all();
        $action = $data['action']??'';
        try {
            if ($action == 'cache_all') {
                Cache::flush();
            } else {
                Cache::forget($action);
            }
            $error = 0;
            $msg = '';
        } catch (\Exception $e) {
            $error = 1;
            $msg = $e->getMessage();
        }

        return response()->json([
            'error' => $error,
            'msg' => $msg,
            'action' => $action,
        ]);
    }

}
