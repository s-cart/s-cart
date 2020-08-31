<?php
#app/Http/Admin/Controllers/AdminOrderConfigController.php
namespace App\Admin\Controllers;

use App\Http\Controllers\Controller;
use App\Models\AdminConfig;
class AdminOrderConfigController extends Controller
{
    public function index()
    {
        $data = [
            'title' => trans('order.admin.config_title'),
            'subTitle' => '',
            'icon' => 'fa fa-indent',        ];

        $orderConfig = (new AdminConfig)
            ->where('code', 'order_config')
            ->orderBy('sort', 'desc')->get();
        $data['configs'] = $orderConfig;
        return view('admin.screen.order_config')
            ->with($data);
    }

}
