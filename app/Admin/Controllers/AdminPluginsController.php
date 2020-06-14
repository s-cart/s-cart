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
        $title = trans('plugin.' . $code.'_plugin');
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

    /**
     * Install Plugin
     */
    public function install()
    {
        $key = request('key');
        $code = request('code');
        $namespace = sc_get_class_plugin_config($code, $key);
        $response = (new $namespace)->install();
        return response()->json($response);
    }

    /**
     * Uninstall plugin
     *
     * @return  [type]  [return description]
     */
    public function uninstall()
    {
        $key = request('key');
        $code = request('code');
        $namespace = sc_get_class_plugin_config($code, $key);
        $response = (new $namespace)->uninstall();
        File::deleteDirectory(app_path('Plugins/'.$code.'/'.$key));
        File::deleteDirectory(public_path('Plugins/'.$code.'/'.$key));
        return response()->json($response);
    }

    /**
     * Enable plugin
     *
     * @return  [type]  [return description]
     */
    public function enable()
    {
        $key = request('key');
        $code = request('code');
        $namespace = sc_get_class_plugin_config($code, $key);
        $response = (new $namespace)->enable();
        return response()->json($response);
    }

    /**
     * Disable plugin
     *
     * @return  [type]  [return description]
     */
    public function disable()
    {
        $key = request('key');
        $code = request('code');
        $namespace = sc_get_class_plugin_config($code, $key);
        $response = (new $namespace)->disable();
        return response()->json($response);
    }

    /**
     * Import plugin
     */
    public function importPlugin() {
        $data =  [
            'title' => trans('plugin.import')
        ];
        return view('admin.screen.plugin_upload')
        ->with($data);
    }

    /**
     * Process import
     *
     * @return  [type]  [return description]
     */
    public function processImport() {
        $data = request()->all();
        $validator = \Validator::make(
            $data,
            [
                'file'   => 'required|mimetypes:application/zip|max:51200',
            ]
        );

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }
        $pathTmp = time();
        $pathFile = sc_file_upload($data['file'],'tmp', $pathFolder = $pathTmp);
        if($pathFile) {
            $unzip = sc_unzip(storage_path('tmp/'.$pathFile), storage_path('tmp/'.$pathTmp));
            if($unzip) {
                $checkConfig = glob(storage_path('tmp/'.$pathTmp) . '/*/src/config.json');
                if($checkConfig) {
                    $folderName = explode('/src',$checkConfig[0]);
                    $folderName = explode('/', $folderName[0]);
                    $folderName = end($folderName);
                    $config = json_decode(file_get_contents($checkConfig[0]), true);
                    $configGroup = $config['configGroup'] ?? '';
                    $configCode = $config['configCode'] ?? '';
                    $configKey = $config['configKey'] ?? '';
                    if (!$configGroup || !$configCode || !$configKey) {
                        File::deleteDirectory(storage_path('tmp/'.$pathTmp));
                        return redirect()->back()->with('error', trans('plugin.error_config'));
                    }

                    $arrPluginLocal = sc_get_all_plugin($configCode);
                    if(array_key_exists($configKey, $arrPluginLocal)) {
                        File::deleteDirectory(storage_path('tmp/'.$pathTmp));
                        return redirect()->back()->with('error', trans('plugin.error_exist'));
                    }

                    $pathPlugin = $configGroup.'/'.$configCode.'/'.$configKey;
                    try {
                        File::copyDirectory(storage_path('tmp/'.$pathTmp.'/'.$folderName.'/public'), public_path($pathPlugin));
                        File::copyDirectory(storage_path('tmp/'.$pathTmp.'/'.$folderName.'/src'), app_path($pathPlugin));
                        File::deleteDirectory(storage_path('tmp/'.$pathTmp));
                        $namespace = sc_get_class_plugin_config($configCode, $configKey);
                        $response = (new $namespace)->install();
                    } catch(\Exception $e) {
                        File::deleteDirectory(storage_path('tmp/'.$pathTmp));
                        return redirect()->back()->with('error', $e->getMessage());
                    }

                } else {
                    File::deleteDirectory(storage_path('tmp/'.$pathTmp));
                    return redirect()->back()->with('error', trans('plugin.error_check_config'));
                }
            } else {
                return redirect()->back()->with('error', trans('plugin.error_unzip'));
            }
        } else {
            return redirect()->back()->with('error', trans('plugin.error_upload'));
        }
        return redirect()->back()->with('success', trans('plugin.import_success')); 
    }

}
