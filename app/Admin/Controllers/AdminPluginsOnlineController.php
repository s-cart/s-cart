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
        $sc_version = config('scart.version');
        $all_version = request('all_version', 0);
        $only_free = request('only_free', 0);
        $sort_download = request('sort_download', 0);
        $sort_rating = request('sort_rating', 0);
        $sort_price_asc = request('sort_price_asc', 0);
        $sort_price_desc = request('sort_price_desc', 0);
        $search_keyword = request('search_keyword', '');

        $page = request('page') ?? 1;

        $url = config('scart.api_link').'/plugins/'.$code.'?page[size]=20&page[number]='.$page;
        if(!$all_version) {
            $url .='&version='.$sc_version;
        }
        if($only_free) {
            $url .='&free=1';
        }
        if($sort_download) {
            $url .='&sort_download=1';
        }
        if($sort_rating) {
            $url .='&sort_rating=1';
        }
        if($sort_price_asc) {
            $url .='&sort_price_asc=1';
        }
        if($sort_price_desc && !$sort_price_asc) {
            $url .='&sort_price_desc=1';
        }
        if($search_keyword) {
            $url .='&search_keyword='.$search_keyword;
        }

        $ch            = curl_init($url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_TIMEOUT, 10);
        $dataApi   = curl_exec($ch);
        curl_close($ch);
        $dataApi = json_decode($dataApi, true);
        if(!empty($dataApi['data'])) {
            foreach ($dataApi['data'] as $key => $data) {
                $arrPluginLibrary[] = [
                    'sku' => $data['sku'] ?? '',
                    'key' => $data['key'] ?? '',
                    'name' => $data['name'] ?? '',
                    'description' => $data['description'] ?? '',
                    'image' => $data['image'] ?? '',
                    'path' => $data['path'] ?? '',
                    'file' => $data['file'] ?? '',
                    'scart_version' => $data['scart_version'] ?? '',
                    'version' => $data['version'] ?? '',
                    'price' => $data['price'] ?? 0,
                    'price_final' => $data['price_final'] ?? 0,
                    'is_free' => $data['is_free'] ?? 0,
                    'download' => $data['download'] ?? 0,
                    'username' =>  $data['username'] ?? '',
                    'times' =>  $data['times'] ?? 0,
                    'points' =>  $data['points'] ?? 0,
                    'rated' =>  $data['rated'] ?? 0,
                    'date' =>  $data['date'] ?? '',
                    'link' =>  $data['link'] ?? '',
                ];
            }
        }
        $resultItems = trans('product.admin.result_item', ['item_from' => $dataApi['from'] ?? 0, 'item_to' => $dataApi['to']??0, 'item_total' => $dataApi['total'] ?? 0]);
        $code = sc_word_format_class($code);

        $arrPluginLocal = sc_get_all_plugin($code);
        $title = trans('plugin.' . $code.'_plugin');

        return view('admin.screen.plugin_online')->with(
            [
                "title" => $title,
                "arrPluginLocal" => $arrPluginLocal,
                "code" => $code,
                "all_version" => $all_version,
                "only_free" => $only_free,
                "search_keyword" => $search_keyword ?? '',
                "sort_price_asc" => $sort_price_asc ?? 0,
                "sort_price_desc" => $sort_price_desc ?? 0,
                "sort_rating" => $sort_rating ?? 0,
                "sort_download" => $sort_download ?? 0,
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
            Storage::disk('tmp')->put($pathTmp.'/'.$fileTmp, $data);
            $unzip = sc_unzip(storage_path('tmp/'.$pathTmp.'/'.$fileTmp), storage_path('tmp/'.$pathTmp));
            if($unzip) {
                $checkConfig = glob(storage_path('tmp/'.$pathTmp) . '/*/src/config.json');
                if(!$checkConfig) {
                    return $response = ['error' => 1, 'msg' => 'Cannot found file config.json'];
                }
                $folderName = explode('/src',$checkConfig[0]);
                $folderName = explode('/', $folderName[0]);
                $folderName = end($folderName);
                File::copyDirectory(storage_path('tmp/'.$pathTmp.'/'.$folderName.'/public'), public_path($pathPlugin));
                File::copyDirectory(storage_path('tmp/'.$pathTmp.'/'.$folderName.'/src'), app_path($pathPlugin));
                File::deleteDirectory(storage_path('tmp/'.$pathTmp));
                $namespace = sc_get_class_plugin_config($code, $key);
                $response = (new $namespace)->install();
            } else {
                $response = ['error' => 1, 'msg' => 'error while unzip'];
            }
        } catch(\Exception $e) {
            $response = ['error' => 1, 'msg' => $e->getMessage()];
        }
        return response()->json($response);
    }
}
