<?php
#app/Http/Admin/Controllers/AdminConfigController.php
namespace App\Admin\Controllers;

use App\Http\Controllers\Controller;
use App\Models\AdminConfig;
use App\Admin\AdminConfigTrait;
class AdminConfigController extends Controller
{
    use AdminConfigTrait;
    public function index()
    {
        $data = [
            'title' => trans('config.admin.title'),
            'subTitle' => '',
            'icon' => 'fa fa-indent',        ];
        $obj = (new AdminConfig)->whereIn('code', ['config', 'display', 'env'])
                ->orderBy('sort', 'desc')
                ->get()
                ->groupBy('code');
        $data['configs'] = $obj;

        return view('admin.screen.config')
            ->with($data);
    }

}
