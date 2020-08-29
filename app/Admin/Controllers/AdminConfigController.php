<?php
#app/Http/Admin/Controllers/AdminConfigController.php
namespace App\Admin\Controllers;

use App\Http\Controllers\Controller;
use App\Models\AdminConfig;
class AdminConfigController extends Controller
{
    public function index()
    {
        $data = [
            'title' => trans('config.admin.title'),
            'subTitle' => '',
            'icon' => 'fa fa-indent',        ];
        $obj = (new AdminConfig)->whereIn('code', ['admin_config', 'display_config', 'env_global'])
                ->orderBy('sort', 'desc')
                ->get()
                ->groupBy('code');
        $data['configs'] = $obj;

        return view('admin.screen.config')
            ->with($data);
    }

    /*
    Update value config
    */
    public function updateInfo()
    {
        $data = request()->all();
        $name = $data['name'];
        $value = $data['value'];
        $storeId = $data['storeId'] ?? 0;
        try {
            AdminConfig::where('key', $name)
                ->where('store_id', $storeId)
                ->update(['value' => $value]);
            $error = 0;
            $msg = trans('admin.update_success');
        } catch (\Throwable $e) {
            $error = 1;
            $msg = $e->getMessage();
        }
        return response()->json([
            'error' => $error,
                'field' => $name,
                'value' => $value,
                'msg' => $msg,
            ]
        );

    }

    /*
    Delete list item
    Need mothod destroy to boot deleting in model
    */
    public function deleteList()
    {
        if (!request()->ajax()) {
            $error = 1;
            $msg = 'Method not allow!';
        } else {
            $ids = request('ids');
            $arrID = explode(',', $ids);
            try {
                AdminConfig::destroy($arrID);
                $error = 0;
                $msg = '';
            } catch (\Throwable $e) {
                $error = 1;
                $msg = $e->getMessage();
            }
            return response()->json(['error' => $error, 'msg' => $msg]);
        }
    }

}
