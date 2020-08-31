<?php
#app/Http/Admin/Controllers/AdminProductConfigController.php
namespace App\Admin\Controllers;

use App\Http\Controllers\Controller;
use App\Models\AdminConfig;
use App\Models\ShopTax;
class AdminProductConfigController extends Controller
{
    public function index()
    {
        $taxs = ShopTax::pluck('name', 'id')->toArray();
        $taxs[0] = trans('tax.admin.non_tax');
        $data = [
            'title' => trans('product.config_manager.title'),
            'subTitle' => '',
            'icon' => 'fa fa-indent',        
        ];
        $productConfig = (new AdminConfig)
            ->where('code', 'product_config')
            ->where('store_id', 0)
            ->orderBy('sort', 'desc')
            ->get()
            ->keyBy('key')
            ->toArray();
        $productConfigAttribute = (new AdminConfig)
            ->where('code', 'product_config_attribute')
            ->where('store_id', 0)
            ->orderBy('sort', 'desc')
            ->get()
            ->keyBy('key')
            ->toArray();
        $productConfigAttributeRequired = (new AdminConfig)
            ->where('code', 'product_config_attribute_required')
            ->where('store_id', 0)
            ->orderBy('sort', 'desc')
            ->get()
            ->keyBy('key')
            ->toArray();
        $data['productConfig'] = $productConfig;
        $data['productConfigAttribute'] = $productConfigAttribute;
        $data['productConfigAttributeRequired'] = $productConfigAttributeRequired;
        $data['taxs'] = $taxs;

        return view('admin.screen.product_config')
            ->with($data);
    }

}
