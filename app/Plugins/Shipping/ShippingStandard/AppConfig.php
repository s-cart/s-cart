<?php
#App\Plugins\Shipping\ShippingStandard\AppConfig.php
namespace App\Plugins\Shipping\ShippingStandard;

use App\Plugins\Shipping\ShippingStandard\Models\PluginModel;
use App\Models\AdminConfig;
use App\Plugins\ConfigDefault;
class AppConfig extends ConfigDefault
{
    public function __construct()
    {
    	$config = file_get_contents(__DIR__.'/config.json');
    	$config = json_decode($config, true);
    	$this->configGroup = $config['configGroup'];
    	$this->configCode = $config['configCode'];
    	$this->configKey = $config['configKey'];
        $this->pathPlugin = $this->configGroup . '/' . $this->configCode . '/' . $this->configKey;
        $this->title = trans($this->pathPlugin.'::lang.title');
        $this->image = $this->pathPlugin.'/'.$config['image'];
        $this->version = $config['version'];
        $this->auth = $config['auth'];
        $this->link = $config['link'];
    }

    public function install()
    {
        $return = ['error' => 0, 'msg' => ''];
        $check = AdminConfig::where('key', $this->configKey)->first();
        if ($check) {
            $return = ['error' => 1, 'msg' => 'Module exist'];
        } else {
            $process = AdminConfig::insert(
                [
                    'code' => $this->configCode,
                    'key' => $this->configKey,
                    'group' => $this->configGroup,
                    'sort' => 0, // Sort extensions in group
                    'value' => self::ON, //1- Enable extension; 0 - Disable
                    'detail' => $this->pathPlugin.'::lang.title',
                ]
            );
            if (!$process) {
                $return = ['error' => 1, 'msg' => 'Error when install'];
            } else {
                $return = (new PluginModel)->installExtension();
            }
        }
        return $return;
    }

    public function uninstall()
    {
        $return = ['error' => 0, 'msg' => ''];
        $process = (new AdminConfig)->where('key', $this->configKey)->delete();
        if (!$process) {
            $return = ['error' => 1, 'msg' => 'Error when uninstall'];
        }
        (new PluginModel)->uninstallExtension();
        return $return;
    }
    public function enable()
    {
        $return = ['error' => 0, 'msg' => ''];
        $process = (new AdminConfig)->where('key', $this->configKey)->update(['value' => self::ON]);
        if (!$process) {
            $return = ['error' => 1, 'msg' => 'Error enable'];
        }
        return $return;
    }
    public function disable()
    {
        $return = ['error' => 0, 'msg' => ''];
        $process = (new AdminConfig)->where('key', $this->configKey)->update(['value' => self::OFF]);
        if (!$process) {
            $return = ['error' => 1, 'msg' => 'Error disable'];
        }
        return $return;
    }

    public function config()
    {
        return view($this->pathPlugin.'::Admin')->with(
            [
                'code' => $this->configCode,
                'key' => $this->configKey,
                'title' => $this->title,
                'pathPlugin' => $this->pathPlugin,
                'data' => PluginModel::first(),
            ]);
    }

    public function updateConfig($data)
    {
        $return = ['error' => 0, 'msg' => ''];
        $process = PluginModel::where('id', $data['pk'])
            ->update([$data['name'] => $data['value']]);
        if (!$process) {
            $return = ['error' => 1, 'msg' => 'Error update'];
        }
        return json_encode($return);
    }


    public function getData()
    {
        $subtotal = \Cart::subtotal();
        $shipping = PluginModel::first();
        if ($subtotal >= $shipping->shipping_free) {
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
                'pathPlugin' => $this->pathPlugin,
            ];
        } else {
            $arrData = [
                'title' => $this->title,
                'code' => $this->configCode,
                'key' => $this->configKey,
                'image' => $this->image,
                'permission' => self::ALLOW,
                'value' => $shipping->fee,
                'version' => $this->version,
                'auth' => $this->auth,
                'link' => $this->link,
                'pathPlugin' => $this->pathPlugin,
            ];

        }
        return $arrData;
    }

}
