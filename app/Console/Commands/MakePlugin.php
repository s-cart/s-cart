<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;  
use Illuminate\Support\Facades\Storage;

class MakePlugin extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'sc:make {function} {--name=} {--download=0}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Make plugin, template format';

    protected $tmpFolder = 'tmp';
    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $function = $this->argument('function') ?? '';
        $name = $this->option('name') ?? '';
        $download = $this->option('download') ?? 0;
        if(empty($function) || empty($name)) {
            echo json_encode([
                'error' => '1',
                'msg' => 'Command error'
            ]);
            exit;
        }
        switch ($function) {
            case 'template':
                $this->template($name, $download);
                break;

            case 'plugin':
                $arrOpt = explode('/', $name);
                if(empty($arrOpt[1])) {
                    $code = '';
                    $key = $arrOpt[0];
                } else {
                    $code = $arrOpt[0];
                    $key = $arrOpt[1];
                }
                $this->plugin($code, $key, $download);
                break;

            default:
                # code...
                break;
        }
        
    }

    //Create format template
    public function template($name, $download){
        $error = 0;
        $msg = '';

        $name = sc_word_format_url($name);
        $source = "format/template/src";
        $sourcePublic = "format/template/public";
        $sID = md5(time());
        $tmp = $this->tmpFolder."/".$sID.'/'.$name.'/src';
        $tmpPublic = $this->tmpFolder."/".$sID.'/'.$name.'/public';
        $description = "views/templates/".$name;
        $descriptionPublic = "public/templates/".$name;
        
        try {
            if($download) {
                File::copyDirectory(storage_path($source), storage_path($tmp));
                File::copyDirectory(storage_path($sourcePublic), storage_path($tmpPublic));

                $appConfigJson = file_get_contents(storage_path($tmp.'/config.json'));
                $appConfigJson      = str_replace('Template_Key', $name, $appConfigJson);
                file_put_contents(storage_path($tmp.'/config.json'), $appConfigJson);


                sc_zip(storage_path($this->tmpFolder."/".$sID), storage_path($this->tmpFolder.'/'.$sID.'.zip'));
                $path = $sID;
            } else {
                File::copyDirectory(storage_path($source), resource_path($description));
                File::copyDirectory(storage_path($sourcePublic), base_path($descriptionPublic));

                $appConfigJson = file_get_contents(resource_path($description.'/config.json'));
                $appConfigJson      = str_replace('Template_Key', $name, $appConfigJson);
                file_put_contents(resource_path($description.'/config.json'), $appConfigJson);
            }
            File::deleteDirectory(storage_path($this->tmpFolder.'/'.$sID));
        } catch(\Exception $e) {
            $msg = $e->getMessage();
            $error = 1;
        }
        echo json_encode([
            'error' => $error,
            'path' => $path ?? '',
            'msg' => $msg
        ]);
    }

    //Create format plugin
    public function plugin($code = 'Other', $key, $download = 0) {
        $error = 0;
        $msg = '';

        $arrcodePlugin = ['Cms', 'Other', 'Payment', 'Shipping', 'Total'];
        $pluginKey = sc_word_format_class($key);
        $pluginCode = sc_word_format_class($code);
        if(!in_array($pluginCode, $arrcodePlugin)) {
            $pluginCode = 'Other';
        }
        $pluginUrlKey = sc_word_format_url($key);
        $pluginUrlKey = str_replace('-', '_', $pluginUrlKey);

        $source = "format/plugin/src";
        $sourcePublic = "format/plugin/public";
        $sID = md5(time());
        $tmp = $this->tmpFolder."/".$sID.'/'.$pluginKey.'/src';
        $tmpPublic = $this->tmpFolder."/".$sID.'/'.$pluginKey.'/public';
        $description = 'Plugins/'.$pluginCode.'/'.$pluginKey;
        try {
            File::copyDirectory(storage_path($source), storage_path($tmp));
            File::copyDirectory(storage_path($sourcePublic), storage_path($tmpPublic));

            $adminController = file_get_contents(storage_path($tmp.'/Admin/AdminController.php'));
            $adminController      = str_replace('Plugin_Code', $pluginCode, $adminController);
            $adminController      = str_replace('Plugin_Key', $pluginKey, $adminController);
            $adminController      = str_replace('PluginUrlKey', $pluginUrlKey, $adminController);
            file_put_contents(storage_path($tmp.'/Admin/AdminController.php'), $adminController);

            $frontController = file_get_contents(storage_path($tmp.'/Controllers/FrontController.php'));
            $frontController      = str_replace('Plugin_Code', $pluginCode, $frontController);
            $frontController      = str_replace('Plugin_Key', $pluginKey, $frontController);
            $frontController      = str_replace('PluginUrlKey', $pluginUrlKey, $frontController);
            file_put_contents(storage_path($tmp.'/Controllers/FrontController.php'), $frontController);

            $model = file_get_contents(storage_path($tmp.'/Models/PluginModel.php'));
            $model      = str_replace('Plugin_Code', $pluginCode, $model);
            $model      = str_replace('Plugin_Key', $pluginKey, $model);
            $model      = str_replace('PluginUrlKey', $pluginUrlKey, $model);
            file_put_contents(storage_path($tmp.'/Models/PluginModel.php'), $model);

            $appConfigJson = file_get_contents(storage_path($tmp.'/config.json'));
            $appConfigJson      = str_replace('Plugin_Code', $pluginCode, $appConfigJson);
            $appConfigJson      = str_replace('Plugin_Key', $pluginKey, $appConfigJson);
            $appConfigJson          = str_replace('PluginUrlKey', $pluginUrlKey, $appConfigJson);
            file_put_contents(storage_path($tmp.'/config.json'), $appConfigJson);


            $appConfig = file_get_contents(storage_path($tmp.'/AppConfig.php'));
            $appConfig      = str_replace('Plugin_Code', $pluginCode, $appConfig);
            $appConfig      = str_replace('Plugin_Key', $pluginKey, $appConfig);
            file_put_contents(storage_path($tmp.'/AppConfig.php'), $appConfig);

            $langen = file_get_contents(storage_path($tmp.'/Lang/en/lang.php'));
            $langen      = str_replace('Plugin_Code', $pluginCode, $langen);
            $langen      = str_replace('Plugin_Key', $pluginKey, $langen);
            file_put_contents(storage_path($tmp.'/Lang/en/lang.php'), $langen);

            $langvi = file_get_contents(storage_path($tmp.'/Lang/vi/lang.php'));
            $langvi      = str_replace('Plugin_Code', $pluginCode, $langvi);
            $langvi      = str_replace('Plugin_Key', $pluginKey, $langvi);
            file_put_contents(storage_path($tmp.'/Lang/vi/lang.php'), $langvi);

            $provider = file_get_contents(storage_path($tmp.'/Provider.php'));
            $provider      = str_replace('Plugin_Code', $pluginCode, $provider);
            $provider      = str_replace('Plugin_Key', $pluginKey, $provider);
            $provider          = str_replace('PluginUrlKey', $pluginUrlKey, $provider);
            file_put_contents(storage_path($tmp.'/Provider.php'), $provider);

            $route = file_get_contents(storage_path($tmp.'/Route.php'));
            $route      = str_replace('Plugin_Code', $pluginCode, $route);
            $route      = str_replace('Plugin_Key', $pluginKey, $route);
            $route          = str_replace('PluginUrlKey', $pluginUrlKey, $route);
            file_put_contents(storage_path($tmp.'/Route.php'), $route);

        } catch (\Exception $e) {
            $msg = $e->getMessage();
            $error = 1;
        }

        try {
            
            if($download) {
                sc_zip(storage_path($this->tmpFolder."/".$sID), storage_path($this->tmpFolder.'/'.$sID.'.zip'));
                $path = $sID;
            } else {
                File::copyDirectory(storage_path($tmp), app_path($description));
                File::copyDirectory(storage_path($tmpPublic), public_path($description));
            }
            File::deleteDirectory(storage_path($this->tmpFolder.'/'.$sID));
        } catch(\Exception $e) {
            $msg = $e->getMessage();
            $error = 1;
        }

        echo json_encode([
            'error' => $error,
            'path' => $path ?? '',
            'msg' => $msg
        ]);

    }
}
