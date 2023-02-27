<?php
namespace App\Pmo\Admin\Controllers;

use App\Pmo\Admin\Controllers\RootAdminController;
use App\Pmo\Admin\Models\AdminStore;
use App\Pmo\Admin\Models\AdminTemplate;
use App\Pmo\Front\Models\ShopLanguage;
use App\Pmo\Front\Models\ShopCurrency;

class AdminStoreInfoController extends RootAdminController
{
    public $templates;
    public $currencies;
    public $languages;

    public function __construct()
    {
        parent::__construct();
        $this->templates = (new AdminTemplate)->getListTemplateActive();
        $this->currencies = ShopCurrency::getCodeActive();
        $this->languages = ShopLanguage::getListActive();
    }

    /*
    Update value config
    */
    public function updateInfo()
    {
        $data      = request()->all();
        $data = sc_clean($data, [], true);
        $storeId   = $data['storeId'];
        $fieldName = $data['name'];
        $value     = $data['value'];
        $parseName = explode('__', $fieldName);
        $name      = $parseName[0];
        $lang      = $parseName[1] ?? '';
        $msg       = 'Update success';
        // Check store
        $store     = AdminStore::find($storeId);
        if (!$store) {
            return response()->json(['error' => 1, 'msg' => 'Store not found!']);
        }

        if (!$lang) {
            try {
                if ($name == 'type') {
                    // Can not change type in here
                    $error = 1;
                    $msg = sc_language_render('store.admin.value_cannot_change');
                } elseif ($name == 'domain') {
                    if (
                        $storeId == SC_ID_ROOT 
                        || ((sc_check_multi_vendor_installed()) && sc_store_is_partner($storeId)) 
                        || sc_check_multi_store_installed()
                    ) {
                        // Only store root can edit domain
                        $domain = sc_process_domain_store($value);
                        if (AdminStore::where('domain', $domain)->where('id', '<>', $storeId)->first()) {
                            $error = 1;
                            $msg = sc_language_render('store.admin.domain_exist');
                        } else {
                            AdminStore::where('id', $storeId)->update([$name => $domain]);
                            $error = 0;
                        }
                    } else {
                        $error = 1;
                        $msg = sc_language_render('store.admin.value_cannot_change');
                    }
                } elseif ($name == 'code') {
                    if (AdminStore::where('code', $value)->where('id', '<>', $storeId)->first()) {
                        $error = 1;
                        $msg = sc_language_render('store.admin.code_exist');
                    } else {
                        AdminStore::where('id', $storeId)->update([$name => $value]);
                        $error = 0;
                    }
                } elseif ($name == 'template') {
                    AdminStore::where('id', $storeId)->update([$name => $value]);
                    //Install template for store
                    if (file_exists($fileProcess = resource_path() . '/views/templates/'.$value.'/Provider.php')) {
                        include_once $fileProcess;
                        if (function_exists('sc_template_install_store')) {
                            //Insert only specify store
                            $checkTemplateEnableStore = (new \App\Pmo\Front\Models\ShopStoreCss)
                                ->where('template', $value)
                                ->where('store_id', $storeId)
                                ->first();
                            if (!$checkTemplateEnableStore) {
                                sc_template_install_store($storeId);
                            }
                        }
                    }
                    $error = 0;
                } else {
                    AdminStore::where('id', $storeId)->update([$name => $value]);
                    $error = 0;
                }
            } catch (\Throwable $e) {
                $error = 1;
                $msg = $e->getMessage();
            }
        } else {
            // Process description
            $dataUpdate = [
                'storeId' => $storeId,
                'lang' => $lang,
                'name' => $name,
                'value' => $value,
            ];
            $dataUpdate = sc_clean($dataUpdate, [], true);
            try {
                AdminStore::updateDescription($dataUpdate);
                $error = 0;
            } catch (\Throwable $e) {
                $error = 1;
                $msg = $e->getMessage();
            }
        }
        return response()->json(['error' => $error, 'msg' => $msg]);
    }

    public function index()
    {
        $id = session('adminStoreId');
        $store = AdminStore::find($id);
        if (!$store) {
            $data = [
                'title' => sc_language_render('store.admin.title'),
                'subTitle' => '',
                'icon' => 'fas fa-cogs',
                'dataNotFound' => 1
            ];
            return view($this->templatePathAdmin.'screen.store_info')
            ->with($data);
        }
        $data = [
            'title' => sc_language_render('store.admin.title'),
            'subTitle' => '',
            'icon' => 'fas fa-cogs',
        ];
        $data['store'] = $store;
        $data['templates'] = $this->templates;
        $data['languages'] = $this->languages;
        $data['currencies'] =$this->currencies;
        $data['storeId'] = $id;

        return view($this->templatePathAdmin.'screen.store_info')
        ->with($data);
    }
}
