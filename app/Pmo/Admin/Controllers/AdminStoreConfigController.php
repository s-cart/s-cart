<?php
namespace App\Pmo\Admin\Controllers;

use App\Pmo\Admin\Controllers\RootAdminController;
use App\Pmo\Front\Models\ShopLanguage;
use App\Pmo\Front\Models\ShopCurrency;
use App\Pmo\Admin\Models\AdminConfig;
use App\Pmo\Admin\Models\AdminTemplate;
use App\Pmo\Admin\Models\AdminPage;
use App\Pmo\Front\Models\ShopTax;

class AdminStoreConfigController extends RootAdminController
{
    public $templates;
    public $currencies;
    public $languages;
    public $timezones;

    public function __construct()
    {
        parent::__construct();
        foreach (timezone_identifiers_list() as $key => $value) {
            $timezones[$value] = $value;
        }
        $this->templates = (new AdminTemplate)->getListTemplateActive();
        $this->currencies = ShopCurrency::getCodeActive();
        $this->languages = ShopLanguage::getListActive();
        $this->timezones = $timezones;
    }

    public function index()
    {
        $id = session('adminStoreId');
        $data = [
            'title' => sc_language_render('admin.menu_titles.config_store_default'),
            'subTitle' => '',
            'icon' => 'fas fa-cogs',
        ];

        // Customer config
        $dataCustomerConfig = [
            'code' => 'customer_config_attribute',
            'storeId' => $id,
            'keyBy' => 'key',
        ];
        $customerConfigs = AdminConfig::getListConfigByCode($dataCustomerConfig);
        
        $dataCustomerConfigRequired = [
            'code' => 'customer_config_attribute_required',
            'storeId' => $id,
            'keyBy' => 'key',
        ];
        $customerConfigsRequired = AdminConfig::getListConfigByCode($dataCustomerConfigRequired);
        //End customer

        //Product config
        $taxs = ShopTax::pluck('name', 'id')->toArray();
        $taxs[0] = sc_language_render('admin.tax.non_tax');

        $productConfigQuery = [
            'code' => 'product_config',
            'storeId' => $id,
            'keyBy' => 'key',
        ];
        $productConfig = AdminConfig::getListConfigByCode($productConfigQuery);

        $productConfigAttributeQuery = [
            'code' => 'product_config_attribute',
            'storeId' => $id,
            'keyBy' => 'key',
        ];
        $productConfigAttribute = AdminConfig::getListConfigByCode($productConfigAttributeQuery);

        $productConfigAttributeRequiredQuery = [
            'code' => 'product_config_attribute_required',
            'storeId' => $id,
            'keyBy' => 'key',
        ];
        $productConfigAttributeRequired = AdminConfig::getListConfigByCode($productConfigAttributeRequiredQuery);

        $orderConfigQuery = [
            'code' => 'order_config',
            'storeId' => $id,
            'keyBy' => 'key',
        ];
        $orderConfig = AdminConfig::getListConfigByCode($orderConfigQuery);

        $configDisplayQuery = [
            'code' => 'display_config',
            'storeId' => $id,
            'keyBy' => 'key',
        ];
        $configDisplay = AdminConfig::getListConfigByCode($configDisplayQuery);

        $configCaptchaQuery = [
            'code' => 'captcha_config',
            'storeId' => $id,
            'keyBy' => 'key',
        ];
        $configCaptcha = AdminConfig::getListConfigByCode($configCaptchaQuery);

        $configCustomizeQuery = [
            'code' => 'admin_custom_config',
            'storeId' => $id,
            'keyBy' => 'key',
        ];
        $configCustomize = AdminConfig::getListConfigByCode($configCustomizeQuery);

        
        $configLayoutQuery = [
            'code' => 'config_layout',
            'storeId' => $id,
            'keyBy' => 'key',
        ];
        $configLayout = AdminConfig::getListConfigByCode($configLayoutQuery);

        $emailConfigQuery = [
            'code' => ['smtp_config', 'email_action'],
            'storeId' => $id,
            'groupBy' => 'code',
            'sort'    => 'asc',
        ];
        $emailConfig = AdminConfig::getListConfigByCode($emailConfigQuery);

        $data['emailConfig'] = $emailConfig;
        $data['smtp_method'] = ['' => 'None Secirity', 'TLS' => 'TLS', 'SSL' => 'SSL'];
        $data['captcha_page'] = [
            'register' => sc_language_render('admin.captcha.captcha_page_register'),
            'forgot'   => sc_language_render('admin.captcha.captcha_page_forgot_password'),
            'checkout' => sc_language_render('admin.captcha.captcha_page_checkout'),
            'contact'  => sc_language_render('admin.captcha.captcha_page_contact'),
            'review'   => sc_language_render('admin.captcha.captcha_page_review'),
        ];
        if (sc_check_multi_shop_installed()) {
            $pageList = (new AdminPage)->getListPageAlias($id);
        } else {
            $pageList = (new AdminPage)->getListPageAlias();
        }
        //End email
        $data['customerConfigs']                = $customerConfigs;
        $data['customerConfigsRequired']        = $customerConfigsRequired;
        $data['productConfig']                  = $productConfig;
        $data['productConfigAttribute']         = $productConfigAttribute;
        $data['productConfigAttributeRequired'] = $productConfigAttributeRequired;
        $data['configLayout']                   = $configLayout;
        $data['pluginCaptchaInstalled']         = sc_get_plugin_captcha_installed();
        $data['pageList']                       = $pageList;
        $data['taxs']                           = $taxs;
        $data['configDisplay']                  = $configDisplay;
        $data['orderConfig']                    = $orderConfig;
        $data['configCaptcha']                  = $configCaptcha;
        $data['configCustomize']                = $configCustomize;
        $data['templates']                      = $this->templates;
        $data['timezones']                      = $this->timezones;
        $data['languages']                      = $this->languages;
        $data['currencies']                     = $this->currencies;
        $data['storeId']                        = $id;
        $data['urlUpdateConfig']                = sc_route_admin('admin_config.update');
        $data['urlUpdateConfigGlobal']          = sc_route_admin('admin_config_global.update');

        return view($this->templatePathAdmin.'screen.config_store_default')
        ->with($data);
    }

    /*
    Update value config store
    */
    public function update()
    {
        $data = request()->all();
        $name = $data['name'];
        $value = $data['value'];
        $storeId = $data['storeId'] ?? '';
        if (!$storeId) {
            return response()->json(
                [
                'error' => 1,
                'field' => 'storeId',
                'value' => $storeId,
                'msg'   => 'Store ID can not empty!',
                ]
            );
        }

        try {
            AdminConfig::where('key', $name)
                ->where('store_id', $storeId)
                ->update(['value' => $value]);
            $error = 0;
            $msg = sc_language_render('action.update_success');
        } catch (\Throwable $e) {
            $error = 1;
            $msg = $e->getMessage();
        }
        return response()->json(
            [
            'error' => $error,
            'field' => $name,
            'value' => $value,
            'msg'   => $msg,
            ]
        );
    }

    /**
     * Add new config admin
     *
     * @return  [type]  [return description]
     */
    public function addNew() {
        $data = request()->all();
        $key = $data['key'] ?? '';
        $value = $data['value'] ?? '';
        $detail = $data['detail'] ?? '';
        $storeId = $data['storeId'] ?? '';

        if (session('adminStoreId') != SC_ID_ROOT && $storeId != session('adminStoreId')) {
            return response()->json(['error' => 1, 'msg' => sc_language_render('admin.remove_dont_permisison') . ': storeId#' . $storeId]);
        }

        if (!$key) {
            return redirect()->back()->with('error', 'Key: '.sc_language_render('admin.not_empty'));
        }
        $group = $data['group'] ?? 'admin_custom_config';
        $dataUpdate = ['key' => $key, 'value' => $value, 'code' => $group, 'store_id' => $storeId, 'detail' => $detail];
        if (AdminConfig::where(['key' => $key, 'store_id' => $storeId])->first()) {
            return redirect()->back()->with('error', sc_language_quickly('admin.admin_custom_config.key_exist', 'Key already exist'));
        }
        $dataUpdate = sc_clean($dataUpdate, [], true);
        AdminConfig::insert($dataUpdate);
        return redirect()->back()->with('success', sc_language_render('action.update_success'));
    }

    /**
     * Remove config
     *
     * @return  [type]  [return description]
     */
    public function delete() {
        $key = request('key');
        $storeId = request('storeId');

        if (session('adminStoreId') != SC_ID_ROOT && $storeId != session('adminStoreId')) {
            return response()->json(['error' => 1, 'msg' => sc_language_render('admin.remove_dont_permisison') . ': storeId#' . $storeId]);
        }
        AdminConfig::where('key', $key)->where('store_id', $storeId)->delete();
        return response()->json(['error' => 0, 'msg' => sc_language_render('action.update_success')]);
    }
}
