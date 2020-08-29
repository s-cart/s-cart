<?php
#App\Plugins\Total\Discount\AppConfig.php
namespace App\Plugins\Total\Discount;

use App\Plugins\Total\Discount\Models\PluginModel;
use App\Plugins\Total\Discount\Controllers\FrontController;
use App\Models\AdminConfig;
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
        $check = AdminConfig::where('key', $this->configKey)->first();
        if ($check) {
            $return = ['error' => 1, 'msg' => trans('plugin.plugin_action.plugin_exist')];
        } else {
            $process = AdminConfig::insert(
                [
                    'code' => $this->configCode,
                    'key' => $this->configKey,
                    'group' => $this->configGroup,
                    'sort' => 0,
                    'value' => self::ON, //Enable extension
                    'detail' => $this->pathPlugin.'::lang.title',
                ]
            );
            if (!$process) {
                $return = ['error' => 1, 'msg' => trans('plugin.plugin_action.install_faild')];
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
        if (!$process) {
            $return = ['error' => 1, 'msg' => trans('plugin.plugin_action.action_error', ['action' => 'Uninstall'])];
        }
        (new PluginModel)->uninstall();
        return $return;
    }
    public function enable()
    {
        $return = ['error' => 0, 'msg' => ''];
        $process = (new AdminConfig)->where('key', $this->configKey)->update(['value' => self::ON]);
        if (!$process) {
            $return = ['error' => 1, 'msg' =>  trans('plugin.plugin_action.action_error', ['action' => 'Enable'])];
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
            $return = ['error' => 1, 'msg' => trans('plugin.plugin_action.action_error', ['action' => 'Disable'])];
        }
        return $return;
    }

    public function config()
    {
        return redirect()->route('admin_discount.index');
    }

    public function getData()
    {
        $uID = auth()->user()->id ?? 0;
        $arrData = [
            'title' => $this->title,
            'code' => $this->configCode,
            'key' => $this->configKey,
            'image' => $this->image,
            'permission' => self::ALLOW,
            'value' => 0,
            'version' => $this->version,
            'auth' => $this->auth,
            'link' => $this->link,
            'pathPlugin' => $this->pathPlugin
        ];

        $totalMethod = session('totalMethod',[]);
        $discount = $totalMethod['Discount']??'';

        $check = json_decode((new FrontController)->check($discount, $uID), true);
        if (!empty($discount) && !$check['error']) {
            $subtotalWithTax = \App\Models\ShopCurrency::sumCart(\Cart::instance('default')->content())['subTotalWithTax'];
            if ($check['content']['type'] == 'percent') {
                $value = floor($subtotalWithTax * $check['content']['reward'] / 100);
            } else {
                $value = sc_currency_value($check['content']['reward']);
            }
            $arrData = array(
                'title' => '<b>' . $this->title . ':</b> ' . $discount . '',
                'code' => $this->configCode,
                'key' => $this->configKey,
                'image' => $this->image,
                'permission' => self::ALLOW,
                'value' => ($value > $subtotalWithTax) ? -$subtotalWithTax : -$value,
                'version' => $this->version,
                'auth' => $this->auth,
                'link' => $this->link,
                'pathPlugin' => $this->pathPlugin,
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
        $orderID = $data['orderID'] ?? '';
        $code = $data['code'] ?? '';
        $uID = auth()->user()->id ?? 0;
        $msg = 'Order #'.$orderID;
        return (new FrontController)->apply($code, $uID, $msg);
    }
}
