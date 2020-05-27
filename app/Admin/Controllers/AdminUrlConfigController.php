<?php
#app/Http/Admin/Controllers/AdminUrlConfigController.php
namespace App\Admin\Controllers;

use App\Http\Controllers\Controller;
use App\Models\AdminConfig;
use App\Admin\AdminConfigTrait;
class AdminUrlConfigController extends Controller
{
    use AdminConfigTrait;
    public function index()
    {
        $data = [
            'title' => trans('url.config_manager.title'),
            'subTitle' => '',
            'icon' => 'fa fa-indent',        ];

        $obj = (new AdminConfig)->where('code', 'env')
            ->orderBy('sort', 'desc')
            ->get();
        $data['configs'] = $obj;

        return view('admin.screen.url_config')
            ->with($data);
    }

}
