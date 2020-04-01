<?php
#app/Http/Admin/Controllers/AdminPluginsController.php
namespace App\Admin\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\File;  

class AdminPluginsController extends Controller
{

    public function index($code)
    {
        $code = sc_word_format_class($code);
        $action = request('action');
        $pluginKey = request('pluginKey');
        if ($action == 'config' && $pluginKey != '') {
            $namespace = sc_get_class_plugin_config($code, $pluginKey);
            $body = (new $namespace)->config();
        } else {
            $body = $this->pluginCode($code);
        }
        return $body;
    }

    protected function pluginCode($code)
    {
        $code = sc_word_format_class($code);

        $arrDefault = []; // plugin default, cannot remove
        if($code == 'Payment') {
            $arrDefault[] = 'Cash';
        }
        if($code == 'Shipping') {
            $arrDefault[] = 'ShippingStandard';
        }
        if($code == 'Total') {
            $arrDefault[] = 'Discount';
        }
        $pluginsInstalled = sc_get_plugin_installed($code, $onlyActive = false);
        $plugins = sc_get_all_plugin($code);
        $title = trans('admin.plugin_manager.' . $code.'_plugin');
        return $this->render($pluginsInstalled, $plugins,  $title, $code, $arrDefault);
    }

    public function render($pluginsInstalled, $plugins, $title, $code, $arrDefault)
    {
        return view('admin.screen.plugin')->with(
            [
                "title" => $title,
                "pluginsInstalled" => $pluginsInstalled,
                "plugins" => $plugins,
                "code" => $code,
                "arrDefault" => $arrDefault,
            ]);
    }

    public function install()
    {
        $key = request('key');
        $code = request('code');
        $namespace = sc_get_class_plugin_config($code, $key);
        $response = (new $namespace)->install();
        return json_encode($response);
    }
    public function uninstall()
    {
        $key = request('key');
        $code = request('code');
        $namespace = sc_get_class_plugin_config($code, $key);
        $response = (new $namespace)->uninstall();
        File::deleteDirectory(app_path('Plugins/'.$code.'/'.$key));
        File::deleteDirectory(public_path('Plugins/'.$code.'/'.$key));
        return json_encode($response);
    }
    public function enable()
    {
        $key = request('key');
        $code = request('code');
        $namespace = sc_get_class_plugin_config($code, $key);
        $response = (new $namespace)->enable();
        return json_encode($response);
    }
    public function disable()
    {
        $key = request('key');
        $code = request('code');
        $namespace = sc_get_class_plugin_config($code, $key);
        $response = (new $namespace)->disable();
        return json_encode($response);
    }
    public function process($code, $key)
    {
        $data = request()->all();
        $namespace = sc_get_class_plugin_config($code, $key);
        $response = (new $namespace)->process($data);
        return json_encode($response);
    }
}
