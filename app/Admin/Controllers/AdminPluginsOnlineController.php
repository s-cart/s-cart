<?php
#app/Http/Admin/Controllers/AdminPluginsOnlineController.php
namespace App\Admin\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\File;  
class AdminPluginsOnlineController extends Controller
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
        $arrPluginLibrary = [];
        $page = request('page') ?? 1;

        $url = config('scart.api_link').'/plugins/'.$code.'?page[size]=20&page[number]='.$page;
        $ch            = curl_init($url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_TIMEOUT, 10);
        $dataApi   = curl_exec($ch);
        curl_close($ch);
        $dataApi = json_decode($dataApi, true);
        if(!empty($dataApi['data'])) {
            foreach ($dataApi['data'] as $key => $data) {
                $arrPluginLibrary[] = [
                    'sku' => $data['sku'],
                    'key' => $data['key'],
                    'name' => $data['name'],
                    'description' => $data['description'],
                    'image' => $data['image'],
                    'path' => $data['path'],
                    'file' => $data['file'],
                    'scart_version' => $data['scart_version'],
                    'version' => $data['version'],
                    'price' => $data['price'],
                    'price_promotion' => $data['price_promotion'],
                    'is_free' => $data['is_free'],
                    'download' => $data['download'],
                    'username' =>  $data['username'],
                    'times' =>  $data['times'],
                    'points' =>  $data['points'],
                    'date' =>  $data['date'],
                    'link' => '',
                ];
            }
        }
        $resultItems = trans('product.admin.result_item', ['item_from' => $dataApi['from'] ?? 0, 'item_to' => $dataApi['to']??0, 'item_total' => $dataApi['total'] ?? 0]);
        $code = sc_word_format_class($code);

        $arrPluginLocal = sc_get_all_plugin($code);
        $title = trans('admin.plugin_manager.' . $code.'_plugin');

        return view('admin.screen.plugin_online')->with(
            [
                "title" => $title,
                "arrPluginLocal" => $arrPluginLocal,
                "code" => $code,
                "arrPluginLibrary" => $arrPluginLibrary,
                "resultItems" => $resultItems,
                "dataApi" => $dataApi,
            ]);
    }

    public function install()
    {
        $code = request('code');
        $key = request('key');
        $pathPlugin = 'Plugins/'.$code.'/'.$key;
        $path = request('path');
        try {
            $data = file_get_contents($path);
            $pathTmp = $code.'_'.$key.'_'.time();
            $fileTmp = $pathTmp.'.zip';
            Storage::disk('tmp')->put($fileTmp, $data);
        } catch(\Exception $e) {
            $response = ['error' => 1, 'msg' => $e->getMessage()];
        }
        $unzip = sc_unzip(storage_path('tmp/'.$fileTmp), storage_path('tmp/'.$pathTmp));

        if($unzip) {
            File::copyDirectory(storage_path('tmp/'.$pathTmp.'/'.$key.'/public'), public_path($pathPlugin));
            File::copyDirectory(storage_path('tmp/'.$pathTmp.'/'.$key.'/src'), app_path($pathPlugin));
            File::deleteDirectory(storage_path('tmp/'.$pathTmp));
            Storage::disk('tmp')->delete($fileTmp);
            $namespace = sc_get_class_plugin_config($code, $key);
            $response = (new $namespace)->install();
        } else {
            $response = ['error' => 1, 'msg' => 'error while unzip'];
        }

        return response()->json($response);
    }
}
