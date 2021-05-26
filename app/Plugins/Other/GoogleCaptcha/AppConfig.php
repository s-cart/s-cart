<?php
/**
 * Format plugin for S-Cart 3.x
 */
#App\Plugins\Other\GoogleCaptcha\AppConfig.php
namespace App\Plugins\Other\GoogleCaptcha;

use App\Plugins\Other\GoogleCaptcha\Models\PluginModel;
use SCart\Core\Admin\Models\AdminConfig;
use App\Plugins\ConfigDefault;
use GuzzleHttp\Client;

class AppConfig extends ConfigDefault
{
    public function __construct()
    {
        //Read config from config.json
        $config = file_get_contents(__DIR__.'/config.json');
        $config = json_decode($config, true);
    	$this->configGroup = $config['configGroup'];
    	$this->configCode = $config['configCode'];
        $this->configKey = $config['configKey'];
        //Path
        $this->pathPlugin = $this->configGroup . '/' . $this->configCode . '/' . $this->configKey;
        //Language
        $this->title = trans($this->pathPlugin.'::lang.title');
        //Image logo or thumb
        $this->image = $this->pathPlugin.'/'.$config['image'];
        //
        $this->version = $config['version'];
        $this->auth = $config['auth'];
        $this->link = $config['link'];
    }

    public function install()
    {
        $return = ['error' => 0, 'msg' => ''];
        $check = AdminConfig::where('key', $this->configKey)->first();
        if ($check) {
            //Check Plugin key exist
            $return = ['error' => 1, 'msg' =>  sc_language_render('plugin.plugin_action.plugin_exist')];
        } else {
            //Insert plugin to config
            $dataInsert = [
                [
                    'group' => $this->configGroup,
                    'code' => $this->configCode,
                    'key' => $this->configKey,
                    'sort' => 0,
                    'value' => self::ON, //Enable extension
                    'detail' => $this->pathPlugin.'::lang.title',
                ],
                [
                    'group' => '',
                    'code' => $this->configKey.'_config',
                    'key' => $this->configKey.'_secrect_key',
                    'sort' => 0, // Sort extensions in group
                    'value' => '',
                    'detail' => $this->pathPlugin.'::lang.secrect_key',
                ],
                [
                    'group' => '',
                    'code' => $this->configKey.'_config',
                    'key' => $this->configKey.'_site_key',
                    'sort' => 0, // Sort extensions in group
                    'value' => '',
                    'detail' => $this->pathPlugin.'::lang.site_key',
                ],
            ];
            $process = AdminConfig::insert(
                $dataInsert
            );
            if (!$process) {
                $return = ['error' => 1, 'msg' => sc_language_render('plugin.plugin_action.install_faild')];
            } else {
                $return = (new PluginModel)->installExtension();
            }
        }

        return $return;
    }

    public function uninstall()
    {
        $return = ['error' => 0, 'msg' => ''];
        //Please delete all values inserted in the installation step
        $process = (new AdminConfig)
            ->where('key', $this->configKey)
            ->orWhere('code', $this->configKey.'_config')
            ->delete();
        if (!$process) {
            $return = ['error' => 1, 'msg' => sc_language_render('plugin.plugin_action.action_error', ['action' => 'Uninstall'])];
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
        $process = (new AdminConfig)
            ->where('key', $this->configKey)
            ->update(['value' => self::OFF]);
        if (!$process) {
            $return = ['error' => 1, 'msg' => 'Error disable'];
        }
        return $return;
    }

    public function config()
    {
        $breadcrumb['url'] = sc_route_admin('admin_plugin', ['code' => $this->configCode]);
        $breadcrumb['name'] = sc_language_render('plugin.' . $this->configCode.'_plugin');
        return view($this->pathPlugin . '::Admin')->with(
            [
                'pathPlugin' => $this->pathPlugin,
                'code'       => $this->configCode,
                'key'        => $this->configKey,
                'title'      => $this->title,
                'breadcrumb' => $breadcrumb,
            ]
        );
    }

    public function getData()
    {
        $arrData = [
            'title' => $this->title,
            'code' => $this->configCode,
            'key' => $this->configKey,
            'image' => $this->image,
            'permission' => self::ALLOW,
            'version' => $this->version,
            'auth' => $this->auth,
            'link' => $this->link,
            'value' => 0, // this return need for plugin shipping
            'pathPlugin' => $this->pathPlugin
        ];

        return $arrData;
    }

    /**
     * Process after order success
     *
     * @param   [array]  $data  
     *
     */
    public function endApp($data = []) {
        //action after end app
    }

    public static function getField() {
        return 'g-recaptcha-response';
    }

    public static function msgError() {
        return 'Error captcha';
    }

    public function validate( string $value)
    {
        $client = new Client();
        $response = $client->post(
            'https://www.google.com/recaptcha/api/siteverify',
            ['form_params'=>
                [
                    'secret'   => sc_config($this->configKey.'_secrect_key'),
                    'response' => $value
                 ]
            ]
        );
        $body = json_decode((string)$response->getBody());
        return $body->success;
    }
}
