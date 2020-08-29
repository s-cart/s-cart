<?php
#app/Http/Admin/Controllers/AdminUrlConfigController.php
namespace App\Admin\Controllers;

use App\Http\Controllers\Controller;
use App\Models\AdminConfig;
class AdminUrlConfigController extends Controller
{
    public function index()
    {
        $data = [
            'title' => trans('admin.config_url'),
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
