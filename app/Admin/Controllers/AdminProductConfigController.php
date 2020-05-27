<?php
#app/Http/Admin/Controllers/AdminProductConfigController.php
namespace App\Admin\Controllers;

use App\Http\Controllers\Controller;
use App\Models\AdminConfig;
use App\Models\ShopTax;
use App\Admin\AdminConfigTrait;
class AdminProductConfigController extends Controller
{
    use AdminConfigTrait;
    public function index()
    {
        $taxs = ShopTax::pluck('name', 'id')->toArray();
        $taxs[0] = trans('tax.admin.non_tax');
        $data = [
            'title' => trans('product.config_manager.title'),
            'subTitle' => '',
            'icon' => 'fa fa-indent',        ];

        $obj = (new AdminConfig)
            ->where('code', 'product')
            ->orderBy('sort', 'desc')->get();
        $data['configs'] = $obj;
        $data['taxs'] = $taxs;

        return view('admin.screen.product_config')
            ->with($data);
    }

}
