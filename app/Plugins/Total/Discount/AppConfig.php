<?php
#App\Plugins\Total\Discount\AppConfig.php
namespace App\Plugins\Total\Discount;

use App\Plugins\Total\Discount\Models\PluginModel;
use App\Plugins\Total\Discount\Controllers\FrontController;
use SCart\Core\Admin\Models\AdminConfig;
use SCart\Core\Admin\Models\AdminMenu;
use SCart\Core\Front\Models\ShopCurrency;
use App\Plugins\ConfigDefault;
class AppConfig extends ConfigDefault
{
    public function __construct()
    {
    	$config = file_get_contents(__DIR__.'/config.json');
    	$config = json_decode($config, true);
    	$this->configGroup = $config['configGroup'] ?? '';
    	$this->configCode = $config['configCode'] ?? '';
    	$this->configKey = $config['configKey'] ?? '';
        $this->pathPlugin = $this->configGroup . '/' . $this->configCode . '/' . $this->configKey;
        $this->title = trans($this->pathPlugin.'::lang.title');
        $this->image = $this->pathPlugin.'/'.$config['image'];
        $this->version = $config['version'];
        $this->auth = $config['auth'];
        $this->link = $config['link'];
        $this->separator = false;
        $this->suffix = false;
        $this->prefix = false;
        $this->length = 8;
        $this->mask = '****-****';

    }

    public function install()
    {
        $return = ['error' => 0, 'msg' => ''];

        $checkPluginPro = AdminConfig::where('key', 'DiscountPro')->first();
        if ($checkPluginPro) {
            return ['error' => 1, 'msg' =>  sc_language_render($this->pathPlugin.'::lang.plugin_action.plugin_discount_pro_exist')];
        }

        $check = AdminConfig::where('key', $this->configKey)->first();
        if ($check) {
            $return = ['error' => 1, 'msg' => sc_language_render('plugin.plugin_action.plugin_exist')];
        } else {
            $process = AdminConfig::insert(
                [
                    'group' => $this->configGroup,
                    'code' => $this->configCode,
                    'key' => $this->configKey,
                    'sort' => 0,
                    'value' => self::ON, //Enable extension
                    'detail' => $this->pathPlugin.'::lang.title',
                ]
            );

            $blockMarketing = AdminMenu::where('key','MARKETING')->first();
            if($blockMarketing) {
                AdminMenu::insert([
                    'sort' => 100,
                    'parent_id' => $blockMarketing->id,
                    'title' => $this->pathPlugin.'::lang.title',
                    'icon' => 'fas fa-tags',
                    'uri' => 'route::admin_discount.index',
                    'key' => $this->configKey,
                    ]);
            }

            if (!$process) {
                $return = ['error' => 1, 'msg' => sc_language_render('plugin.plugin_action.install_faild')];
            } else {
               try {
                    (new PluginModel)->install();
               } catch (\Throwable $e) {
                    return  ['error' => 1, 'msg' => $e->getMessage()];
               }
            }
        }

        return $return;
    }

    public function uninstall()
    {
        $return = ['error' => 0, 'msg' => ''];
        $process = (new AdminConfig)->where('key', $this->configKey)->delete();
        AdminMenu::where('key', $this->configKey)->delete();
        if (!$process) {
            $return = ['error' => 1, 'msg' => sc_language_render('plugin.plugin_action.action_error', ['action' => 'Uninstall'])];
        }
        (new PluginModel)->uninstall();
        return $return;
    }
    public function enable()
    {
        $return = ['error' => 0, 'msg' => ''];
        $process = (new AdminConfig)->where('key', $this->configKey)->update(['value' => self::ON]);
        if (!$process) {
            $return = ['error' => 1, 'msg' =>  sc_language_render('plugin.plugin_action.action_error', ['action' => 'Enable'])];
        }
        return $return;
    }
    public function disable()
    {
        $return = ['error' => 0, 'msg' => ''];
        $process = (new AdminConfig)
            ->where('key', $this->configKey)
            ->update(['value' => self::OFF]);
        if (!$process) {
            $return = ['error' => 1, 'msg' => sc_language_render('plugin.plugin_action.action_error', ['action' => 'Disable'])];
        }
        return $return;
    }

    public function config()
    {
        return redirect()->route('admin_discount.index');
    }

    public function getData()
    {
        $customer = session('customer');
        // Get Id customer
        $uID = $customer->id ?? 0;
        $dataStore = [];
        $arrData = [
            'title'      => $this->title,
            'code'       => $this->configCode,
            'key'        => $this->configKey,
            'image'      => $this->image,
            'permission' => self::ALLOW,
            'value'      => 0,
            'version'    => $this->version,
            'auth'       => $this->auth,
            'link'       => $this->link,
            'pathPlugin' => $this->pathPlugin,
            'store'      => $dataStore,
        ];

        $totalMethod = session('totalMethod', []);
        $discount = $totalMethod['Discount']??'';

        $check = (new FrontController)->check($discount, $uID);

        if (!empty($discount) && !$check['error']) {
            $subtotalWithTax = ShopCurrency::sumCartCheckout()['subTotalWithTax'] ?? null;
            if (!$subtotalWithTax) {
                return $arrData;
            }
            if ($check['content']['type'] == 'percent') {
                $value = floor($subtotalWithTax * $check['content']['reward'] / 100);
            } else {
                $value = sc_currency_value($check['content']['reward']);
            }
            if (sc_check_multi_shop_installed()) {
                //Add info for earch store
                $storeID = $check['content']['store_id'];
                $dataStore[$storeID]['value'] = $value;
            } else {
                $dataStore = [];
            }

            $arrData = array(
                'title'      => '<b>' . $this->title . ':</b> ' . $discount . '',
                'code'       => $this->configCode,
                'key'        => $this->configKey,
                'image'      => $this->image,
                'permission' => self::ALLOW,
                'value'      => ($value > $subtotalWithTax) ? -$subtotalWithTax : -$value,
                'version'    => $this->version,
                'auth'       => $this->auth,
                'link'       => $this->link,
                'pathPlugin' => $this->pathPlugin,
                'store'      => $dataStore, //Add info for earch store
            );
        }
        return $arrData;
    }

    /**
     * Process after order success
     *
     * @param   [array]  $data  
     *
     */
    public function endApp($data = []) {
        return;
    }
}
