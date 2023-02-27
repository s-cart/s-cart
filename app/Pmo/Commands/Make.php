<?php

namespace App\Pmo\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;

class Make extends Command
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
    protected $description = 'Make format plugin and template:'
    .PHP_EOL.'Plugin:   "php artisan sc:make plugin --name=Payment/YourPluginName --download=0"'
    .PHP_EOL.'Template:  "php artisan sc:make tmplate --name=YourTemplateName --download=0"';

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
        if (empty($function) || empty($name)) {
            echo json_encode([
                'error' => '1',
                'msg' => 'Command error'
            ]);
            exit;
        }
        switch ($function) {
            case 'plugin':
                $arrOpt = explode('/', $name);
                if (empty($arrOpt[1])) {
                    $code = '';
                    $key = $arrOpt[0];
                } else {
                    $code = $arrOpt[0];
                    $key = $arrOpt[1];
                }
                $this->plugin($code, $key, $download);
                break;

            case 'template':
                $this->template($name, $download);
                break;

            default:
                # code...
                break;
        }
    }

    //Create format plugin
    public function plugin($code = 'Other', $key = '', $download = 0)
    {
        $error = 0;
        $msg = '';

        $arrcodePlugin = ['Cms', 'Other', 'Payment', 'Shipping', 'Total'];
        $pluginKey = sc_word_format_class($key);
        $pluginCode = sc_word_format_class($code);
        if (!in_array($pluginCode, $arrcodePlugin)) {
            $pluginCode = 'Other';
        }
        $pluginUrlKey = sc_word_format_url($key);
        $pluginUrlKey = str_replace('-', '_', $pluginUrlKey);

        $source = "Format/plugin";
        $sourcePublic = "Format/plugin/public";
        $sID = md5(time());
        $tmp = $this->tmpFolder."/".$sID.'/'.$pluginKey;
        $tmpPublic = $this->tmpFolder."/".$sID.'/'.$pluginKey.'/public';
        $destination = 'Plugins/'.$pluginCode.'/'.$pluginKey;
        try {
            File::copyDirectory(base_path('vendor/s-pmo/core/src/'.$source), storage_path($tmp));
            File::copyDirectory(base_path('vendor/s-pmo/core/src/'.$sourcePublic), storage_path($tmpPublic));

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
        } catch (\Throwable $e) {
            $msg = $e->getMessage();
            $error = 1;
        }

        try {
            if ($download) {
                $path = storage_path($this->tmpFolder.'/'.$sID.'.zip');
                sc_zip(storage_path($this->tmpFolder."/".$sID), $path);
            } else {
                File::copyDirectory(storage_path($tmp), app_path($destination));
                File::copyDirectory(storage_path($tmpPublic), public_path($destination));
            }
            File::deleteDirectory(storage_path($this->tmpFolder.'/'.$sID));
        } catch (\Throwable $e) {
            $msg = $e->getMessage();
            $error = 1;
        }

        echo json_encode([
            'error' => $error,
            'path' => $path ?? '',
            'msg' => $msg
        ]);
    }


    //Create format template
    public function template(string $name, $download = 0)
    {
        $error = 0;
        $msg = '';
        $source = "Format/template";
        $sourcePublic = "Format/template/public";
        $sID = md5(time());
        $tmp = $this->tmpFolder."/".$sID.'/'.$name;
        $tmpPublic = $this->tmpFolder."/".$sID.'/'.$name.'/public';
        $destination = 'templates/'.$name;
        try {
            File::copyDirectory(base_path('vendor/s-pmo/core/src/'.$source), storage_path($tmp));
            File::copyDirectory(base_path('vendor/s-pmo/core/src/'.$sourcePublic), storage_path($tmpPublic));

            $providerContent = file_get_contents(storage_path($tmp.'/Provider.php'));
            $providerContent      = str_replace('your-template-name', $name, $providerContent);
            file_put_contents(storage_path($tmp.'/Provider.php'), $providerContent);

            $configJson = file_get_contents(storage_path($tmp.'/config.json'));
            $configJson      = str_replace('your-template-name', $name, $configJson);
            file_put_contents(storage_path($tmp.'/config.json'), $configJson);

        } catch (\Throwable $e) {
            $msg = $e->getMessage();
            $error = 1;
        }

        try {
            if ($download) {
                $path = storage_path($this->tmpFolder.'/'.$sID.'.zip');
                sc_zip(storage_path($this->tmpFolder."/".$sID), $path);
            } else {
                File::copyDirectory(storage_path($tmp), resource_path('views/'.$destination));
                File::copyDirectory(storage_path($tmpPublic), public_path($destination));
            }
            File::deleteDirectory(storage_path($this->tmpFolder.'/'.$sID));
        } catch (\Throwable $e) {
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
