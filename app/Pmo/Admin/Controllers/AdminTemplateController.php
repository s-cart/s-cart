<?php
namespace App\Pmo\Admin\Controllers;

use App\Pmo\Admin\Controllers\RootAdminController;
use App\Pmo\Admin\Models\AdminStore;
use App\Pmo\Admin\Models\AdminTemplate;
use Illuminate\Support\Facades\File;

class AdminTemplateController extends RootAdminController
{
    public function __construct()
    {
        parent::__construct();
    }
    
    public function index()
    {
        $data = [
            'title' => sc_language_render('admin.template.list'),
            'subTitle' => '',
            'icon' => 'fa fa-indent',        ];

        $data["templates"] = sc_get_all_template();
        $data["templatesActive"] = (new AdminTemplate)->getListTemplateActive();
        $data["templatesInstalled"] = (new AdminTemplate)->getListTemplate();
        $data["templatesUsed"] = AdminStore::getAllTemplateUsed();
        return view($this->templatePathAdmin.'screen.template')
            ->with($data);
    }

    public function changeTemplate()
    {
        $key = request('key');
        $process = AdminStore::first()->update(['template' => $key]);
        if ($process) {
            $return = ['error' => 0, 'msg' => 'Change template success!'];
        } else {
            $return = ['error' => 1, 'msg' => 'Have an error!'];
        }
        return response()->json($return);
    }

    /**
     * Remove template
     *
     * @return void
     */
    public function remove()
    {
        $key = request('key');

        //Run function process before remove template
        if (file_exists($fileProcess = resource_path() . '/views/templates/'.$key.'/Provider.php')) {
            include_once $fileProcess;
            if (function_exists('sc_template_uninstall')) {
                // Remove template from all stories
                sc_template_uninstall();
                (new AdminTemplate)->where('key', $key)->delete();
            }
        }

        try {
            File::deleteDirectory(public_path('templates/'.$key));
            File::deleteDirectory(resource_path('views/templates/'.$key));
            $response = ['error' => 0, 'msg' => 'Remove template success'];
        } catch (\Throwable $e) {
            $response = ['error' => 0, 'msg' => $e->getMessage()];
        }
        return response()->json($response);
    }

    /**
     * Re-install template
     *
     * @return void
     */
    public function refresh()
    {
        $key = request('key');
        $checkTemplate = (new AdminTemplate)->where('key', $key)->first();

        if (!$checkTemplate) {
            if (file_exists($fileConfig = resource_path() . '/views/templates/'.$key.'/config.json')) {
                $config = json_decode(file_get_contents($fileConfig), true);
            }
            (new AdminTemplate)->create(['key' => $key, 'name' => $config['name'], 'status' => 1]);
        }

        //Run function process before remove template
        if (file_exists($fileProcess = resource_path() . '/views/templates/'.$key.'/Provider.php')) {
            include_once $fileProcess;
            $data = ['store_id' => session('adminStoreId')];
            if (function_exists('sc_template_uninstall') && function_exists('sc_template_install')) {
                //Remove all stories
                sc_template_uninstall();
                //Install data default and data for root domain
                sc_template_install($data);
            }
        }
        $response = ['error' => 0, 'msg' => 'Re-install template success'];
        return response()->json($response);
    }

    /**
     * Disable template
     *
     * @return void
     */
    public function disable()
    {
        $key = request('key');
        (new AdminTemplate)->where('key', $key)->update(['status' => 0]);
        $response = ['error' => 0, 'msg' => sc_language_render('action.disable_success')];
        return response()->json($response);
    }

    /**
     * Enable template
     *
     * @return void
     */
    public function enable()
    {
        $key = request('key');
        (new AdminTemplate)->where('key', $key)->update(['status' => 1]);
        $response = ['error' => 0, 'msg' => sc_language_render('action.enable_success')];
        return response()->json($response);
    }



    /**
     * Import template
     */
    public function importTemplate()
    {
        $data =  [
            'title' => sc_language_render('admin.template.import')
        ];
        return view($this->templatePathAdmin.'screen.template_upload')
        ->with($data);
    }

    /**
     * Process import
     *
     * @return  [type]  [return description]
     */
    public function processImport()
    {
        $config = [];
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
        $pathFile = sc_file_upload($data['file'], 'tmp', $pathFolder = $pathTmp)['pathFile'] ?? '';

        if ($pathFile) {
    
            if (!is_writable(storage_path('tmp'))) {
                return response()->json(['error' => 1, 'msg' => 'No write permission '.storage_path('tmp')]);
            }

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
                        return response()->json(['error' => 1, 'msg' => sc_language_render('admin.plugin.not_compatible', ['version' => $scartVersion, 'sc_version' => config('s-pmo.core')])]);
                    }

                    $configKey = $config['configKey'] ?? '';

                    if (!is_writable(public_path('templates'))) {
                        return response()->json(['error' => 1, 'msg' => 'No write permission '.public_path('templates')]);
                    }
            
                    if (!is_writable(resource_path('views/templates'))) {
                        return response()->json(['error' => 1, 'msg' => 'No write permission '.resource_path('views/templates')]);
                    }


                    $configKey = str_replace('.', '-', $configKey);
                    if (!$configKey) {
                        File::deleteDirectory(storage_path('tmp/'.$pathTmp));
                        return redirect()->back()->with('error', sc_language_render('admin.template.error_config'));
                    }

                    $arrTemplateLocal = sc_get_all_template();
                    if (array_key_exists($configKey, $arrTemplateLocal)) {
                        File::deleteDirectory(storage_path('tmp/'.$pathTmp));
                        return redirect()->back()->with('error', sc_language_render('admin.template.error_exist'));
                    }
                    try {
                        File::copyDirectory(storage_path('tmp/'.$pathTmp.'/'.$folderName.'/public'), public_path('templates/'.$configKey));
                        File::copyDirectory(storage_path('tmp/'.$pathTmp.'/'.$folderName), resource_path('views/templates/'.$configKey));
                        File::deleteDirectory(storage_path('tmp/'.$pathTmp));

                        //Run function process after install template
                        if (file_exists($fileProcess = resource_path() . '/views/templates/'.$configKey.'/Provider.php')) {
                            $data = ['store_id' => session('adminStoreId')];
                            include_once $fileProcess;
                            /**
                             * Import template do from root domain
                             */
                            if (function_exists('sc_template_uninstall')) {
                                //Remove all old data from all stories
                                sc_template_uninstall();
                            }
                            if (function_exists('sc_template_install')) {
                                //Install data default and data for root domain
                                sc_template_install($data);
                            }
                        }
                    } catch (\Throwable $e) {
                        File::deleteDirectory(storage_path('tmp/'.$pathTmp));
                        return redirect()->back()->with('error', $e->getMessage());
                    }
                } else {
                    File::deleteDirectory(storage_path('tmp/'.$pathTmp));
                    return redirect()->back()->with('error', sc_language_render('admin.template.error_check_config'));
                }
            } else {
                return redirect()->back()->with('error', sc_language_render('admin.template.error_unzip'));
            }
        } else {
            return redirect()->back()->with('error', sc_language_render('admin.template.error_upload'));
        }
        
        if (count($config)) {
            (new AdminTemplate)->create(['key' => $config['configKey'] ?? '', 'name' => $config['name'] ?? '', 'status' => 1]);
        }
        return redirect()->route('admin_template.index')->with('success', sc_language_render('admin.template.import_success')); 
    }
}
