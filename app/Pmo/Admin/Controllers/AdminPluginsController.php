<?php
namespace App\Pmo\Admin\Controllers;

use App\Pmo\Admin\Controllers\RootAdminController;
use Illuminate\Support\Facades\File;

class AdminPluginsController extends RootAdminController
{
    public function __construct()
    {
        parent::__construct();
    }
    
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
        $arrDefault = config('admin.plugin_protected');
        $pluginsInstalled = sc_get_plugin_installed($code, $onlyActive = false);
        $plugins = sc_get_all_plugin($code);
        $title = sc_language_render('admin.plugin.' . $code.'_plugin');
        return $this->render($pluginsInstalled, $plugins, $title, $code, $arrDefault);
    }

    public function render($pluginsInstalled, $plugins, $title, $code, $arrDefault)
    {
        return view($this->templatePathAdmin.'screen.plugin')->with(
            [
                "title"            => $title,
                "pluginsInstalled" => $pluginsInstalled,
                "plugins"          => $plugins,
                "code"             => $code,
                "arrDefault"       => $arrDefault,
            ]
        );
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
        $onlyRemoveData = request('onlyRemoveData');
        $namespace = sc_get_class_plugin_config($code, $key);
        $response = (new $namespace)->uninstall();
        if (!$onlyRemoveData) {
            File::deleteDirectory(app_path('Plugins/'.$code.'/'.$key));
            File::deleteDirectory(public_path('Plugins/'.$code.'/'.$key));
        }
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
    public function importPlugin()
    {
        $data =  [
            'title' => sc_language_render('admin.plugin.import')
        ];
        return view($this->templatePathAdmin.'screen.plugin_upload')
        ->with($data);
    }

    /**
     * Process import
     *
     * @return  [type]  [return description]
     */
    public function processImport()
    {
        $data = request()->all();
        $validator = \Validator::make(
            $data,
            [
                'file'   => 'required|mimetypes:application/zip|size:'.min($maxSizeConfig = sc_getMaximumFileUploadSize($unit = 'K'), 51200),
            ]
        );

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }
        $pathTmp = time();
        $linkRedirect = '';
        $pathFile = sc_file_upload($data['file'], 'tmp', $pathFolder = $pathTmp)['pathFile'] ?? '';

        if (!is_writable(storage_path('tmp'))) {
            return response()->json(['error' => 1, 'msg' => 'No write permission '.storage_path('tmp')]);
        }
        
        if ($pathFile) {
            $unzip = sc_unzip(storage_path('tmp/'.$pathFile), storage_path('tmp/'.$pathTmp));
            if ($unzip) {
                $checkConfig = glob(storage_path('tmp/'.$pathTmp) . '/*/config.json');
                if ($checkConfig) {
                    $folderName = explode('/config.json', $checkConfig[0]);
                    $folderName = explode('/', $folderName[0]);
                    $folderName = end($folderName);
                    
                    //Check compatibility 
                    $config = json_decode(file_get_contents($checkConfig[0]), true);
                    $scartVersion = $config['scartVersion'] ?? '';
                    if (!sc_plugin_compatibility_check($scartVersion)) {
                        File::deleteDirectory(storage_path('tmp/'.$pathTmp));
                        return redirect()->back()->with('error', sc_language_render('admin.plugin.not_compatible', ['version' => $scartVersion, 'sc_version' => config('s-cart.core')]));
                    }

                    $configGroup = $config['configGroup'] ?? '';
                    $configCode = $config['configCode'] ?? '';
                    $configKey = $config['configKey'] ?? '';

                    //Process if plugin config incorect
                    if (!$configGroup || !$configCode || !$configKey) {
                        File::deleteDirectory(storage_path('tmp/'.$pathTmp));
                        return redirect()->back()->with('error', sc_language_render('admin.plugin.error_config_format'));
                    }
                    //Check plugin exist
                    $arrPluginLocal = sc_get_all_plugin($configCode);
                    if (array_key_exists($configKey, $arrPluginLocal)) {
                        File::deleteDirectory(storage_path('tmp/'.$pathTmp));
                        return redirect()->back()->with('error', sc_language_render('admin.plugin.error_exist'));
                    }

                    $pathPlugin = $configGroup.'/'.$configCode.'/'.$configKey;

                    if (!is_writable(public_path($configGroup.'/'.$configCode))) {
                        return response()->json(['error' => 1, 'msg' => 'No write permission '.public_path($configGroup.'/'.$configCode)]);
                    }
            
                    if (!is_writable(app_path($configGroup.'/'.$configCode))) {
                        return response()->json(['error' => 1, 'msg' => 'No write permission '.app_path($configGroup.'/'.$configCode)]);
                    }

                    try {
                        File::copyDirectory(storage_path('tmp/'.$pathTmp.'/'.$folderName.'/public'), public_path($pathPlugin));
                        File::copyDirectory(storage_path('tmp/'.$pathTmp.'/'.$folderName), app_path($pathPlugin));
                        File::deleteDirectory(storage_path('tmp/'.$pathTmp));
                        $namespace = sc_get_class_plugin_config($configCode, $configKey);
                        $response = (new $namespace)->install();
                        if (!is_array($response) || $response['error'] == 1) {
                            return redirect()->back()->with('error', $response['msg']);
                        }
                        $linkRedirect = route('admin_plugin', ['code' => (new $namespace)->configCode]);
                    } catch (\Throwable $e) {
                        File::deleteDirectory(storage_path('tmp/'.$pathTmp));
                        return redirect()->back()->with('error', $e->getMessage());
                    }
                } else {
                    File::deleteDirectory(storage_path('tmp/'.$pathTmp));
                    return redirect()->back()->with('error', sc_language_render('admin.plugin.error_check_config'));
                }
            } else {
                return redirect()->back()->with('error', sc_language_render('admin.plugin.error_unzip'));
            }
        } else {
            return redirect()->back()->with('error', sc_language_render('admin.plugin.error_upload'));
        }
        if ($linkRedirect) {
            return redirect($linkRedirect)->with('success', sc_language_render('admin.plugin.import_success'));
        } else {
            return redirect()->back()->with('success', sc_language_render('admin.plugin.import_success'));
        }
    }
}
