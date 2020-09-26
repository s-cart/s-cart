<?php
#App\Plugins\Other\MultiStorePro\Admin\AdminStoreConfigController.php

namespace App\Admin\Controllers;

use App\Http\Controllers\Controller;
use App\Models\ShopLanguage;
use App\Models\ShopCurrency;
use App\Models\AdminConfig;
use App\Models\ShopTax;

class AdminStoreConfigController extends Controller
{
    public $templates, $currencies, $languages, $timezones;

    public function __construct()
    {
        $allTemplate = sc_get_all_template();
        $templates = [];
        foreach ($allTemplate as $key => $template) {
            $templates[$key] = empty($template['config']['name']) ? $key : $template['config']['name'];
        }
        foreach (timezone_identifiers_list() as $key => $value) {
            $timezones[$value] = $value;
        }
        $this->templates = $templates;
        $this->currencies = ShopCurrency::getCodeActive();
        $this->languages = ShopLanguage::getListActive();
        $this->timezones = $timezones;

    }

    public function index() {
        $id = session('adminStoreId');
        $data = [
            'title' => trans('admin.menu_titles.config_store_default'),
            'subTitle' => '',
            'icon' => 'fas fa-cogs',        
        ];

        // Customer config
        $customerConfigs = (new AdminConfig)
            ->where('code', 'customer_config_attribute')
            ->where('store_id', $id)
            ->orderBy('sort', 'desc')
            ->get()
            ->keyBy('key')
            ->toArray();
        $customerConfigsRequired = (new AdminConfig)
            ->where('code', 'customer_config_attribute_required')
            ->where('store_id', $id)
            ->orderBy('sort', 'desc')
            ->get()
            ->keyBy('key')
            ->toArray();
        //End customer

        //Product config
        $taxs = ShopTax::pluck('name', 'id')->toArray();
        $taxs[0] = trans('tax.admin.non_tax');
        $productConfig = (new AdminConfig)
            ->where('code', 'product_config')
            ->where('store_id', $id)
            ->orderBy('sort', 'desc')
            ->get()
            ->keyBy('key');
        $productConfigAttribute = (new AdminConfig)
            ->where('code', 'product_config_attribute')
            ->where('store_id', $id)
            ->orderBy('sort', 'desc')
            ->get()
            ->keyBy('key');
        $productConfigAttributeRequired = (new AdminConfig)
            ->where('code', 'product_config_attribute_required')
            ->where('store_id', $id)
            ->orderBy('sort', 'desc')
            ->get()
            ->keyBy('key');
        $orderConfig = (new AdminConfig)
            ->where('code', 'order_config')
            ->where('store_id', $id)
            ->orderBy('sort', 'desc')
            ->get()
            ->keyBy('key');
        $configDisplay = (new AdminConfig)
            ->where('code', 'display_config')
            ->where('store_id', $id)
            ->orderBy('sort', 'desc')
            ->get()
            ->keyBy('key');
        $configCaptcha = (new AdminConfig)
            ->where('code', 'captcha_config')
            ->where('store_id', $id)
            ->orderBy('sort', 'desc')
            ->get()
            ->keyBy('key');
        //Email config
        $emailConfig = (new AdminConfig)
            ->whereIn('code', ['email_action', 'smtp_config'])
            ->where('store_id', $id)
            ->orderBy('sort', 'asc')
            ->get()
            ->groupBy('code');
        $data['emailConfig'] = $emailConfig;
        $data['smtp_method'] = ['' => 'None Secirity', 'TLS' => 'TLS', 'SSL' => 'SSL'];
        $data['captcha_page'] = [
            'register' => trans('captcha.captcha_page_register'), 
            'forgot'   => trans('captcha.captcha_page_forgot_password'), 
            'checkout' => trans('captcha.captcha_page_checkout'), 
            'contact'  => trans('captcha.captcha_page_contact'), 
        ];
        //End email
        $data['customerConfigs']                = $customerConfigs;
        $data['customerConfigsRequired']        = $customerConfigsRequired;
        $data['productConfig']                  = $productConfig;
        $data['productConfigAttribute']         = $productConfigAttribute;
        $data['productConfigAttributeRequired'] = $productConfigAttributeRequired;
        $data['pluginCaptchaInstalled']         = sc_get_plugin_captcha_installed();
        $data['taxs']                           = $taxs;
        $data['configDisplay']                  = $configDisplay;
        $data['orderConfig']                    = $orderConfig;
        $data['configCaptcha']                  = $configCaptcha;
        $data['templates']                      = $this->templates;
        $data['timezones']                      = $this->timezones;
        $data['languages']                      = $this->languages;
        $data['currencies']                     = $this->currencies;
        $data['storeId']                        = 0;

        return view('admin.screen.config_store_default')
        ->with($data);
    }
}
