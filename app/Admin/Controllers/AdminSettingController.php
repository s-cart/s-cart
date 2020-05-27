<?php
#app/Http/Admin/Controllers/AdminSettingController.php
namespace App\Admin\Controllers;

use App\Http\Controllers\Controller;
use App\Models\AdminConfig;
use App\Models\ShopCurrency;
use App\Models\ShopLanguage;
use App\Admin\AdminConfigTrait;
class AdminSettingController extends Controller
{
    use AdminConfigTrait;
    public function index()
    {
        $languages = ShopLanguage::getCodeActive();
        $currencies = ShopCurrency::getCodeActive();
        $data = [
            'title' => trans('setting.admin.title'),
            'subTitle' => '',
            'icon' => 'fa fa-indent',        ];
        foreach (timezone_identifiers_list() as $key => $value) {
            $timezones[$value] = $value;
        }
        $data['timezones'] = $timezones;
        $data['languages'] = $languages;
        $data['currencies'] = $currencies;
        $obj = (new AdminConfig)->whereIn('code', ['config', 'display', 'env'])
                ->orderBy('sort', 'desc')
                ->get()
                ->groupBy('code');
        $data['configs'] = $obj;

        return view('admin.screen.setting')
            ->with($data);
    }

}
