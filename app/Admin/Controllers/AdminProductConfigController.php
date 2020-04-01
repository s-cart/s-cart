<?php
#app/Http/Admin/Controllers/AdminProductConfigController.php
namespace App\Admin\Controllers;

use App\Http\Controllers\Controller;
use App\Models\AdminConfig;
use Illuminate\Http\Request;
use App\Admin\AdminConfigTrait;
class AdminProductConfigController extends Controller
{
    use AdminConfigTrait;
    public function index()
    {

        $data = [
            'title' => trans('product.config_manager.title'),
            'subTitle' => '',
            'icon' => 'fa fa-indent',
        ];

        $obj = (new AdminConfig)
            ->where('code', 'product')
            ->orderBy('sort', 'desc')->get();
        $data['configs'] = $obj;

        return view('admin.screen.product_config')
            ->with($data);
    }

}
