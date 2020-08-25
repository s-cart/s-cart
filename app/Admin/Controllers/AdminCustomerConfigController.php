<?php
#app/Http/Admin/Controllers/AdminCustomerConfigController.php
namespace App\Admin\Controllers;

use App\Http\Controllers\Controller;
use App\Models\AdminConfig;
use Illuminate\Http\Request;
use App\Admin\AdminConfigTrait;
class AdminCustomerConfigController extends Controller
{
    use AdminConfigTrait;
    public function index()
    {

        $data = [
            'title' => trans('customer.config_manager.title'),
            'subTitle' => '',
            'icon' => 'fa fa-indent',        ];

        $obj = (new AdminConfig)
            ->where('code', 'customer_config_attribute')
            ->where('store_id', 0)
            ->orderBy('sort', 'desc')
            ->get()
            ->keyBy('key')
            ->toArray();
        $objRequired = (new AdminConfig)
            ->where('code', 'customer_config_attribute_required')
            ->where('store_id', 0)
            ->orderBy('sort', 'desc')
            ->get()
            ->keyBy('key')
            ->toArray();
        $data['configs'] = $obj;
        $data['configsRequired'] = $objRequired;


        return view('admin.screen.customer_config')
            ->with($data);
    }

}
