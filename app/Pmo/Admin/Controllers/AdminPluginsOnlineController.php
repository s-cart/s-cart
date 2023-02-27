<?php
namespace App\Pmo\Admin\Controllers;

use App\Pmo\Admin\Controllers\RootAdminController;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\File;

class AdminPluginsOnlineController extends RootAdminController
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
        $arrPluginLibrary = [];
        $resultItems = '';
        $htmlPaging = '';
        $sc_version = config('s-pmo.core');
        $filter_free = request('filter_free', '');
        $filter_type = request('filter_type', '');
        $filter_keyword = request('filter_keyword', '');

        $page = request('page') ?? 1;

        $url = config('s-pmo.api_link').'/plugins/'.$code.'?page[size]=20&page[number]='.$page;
        $url .='&version='.$sc_version;
        $url .='&filter_free='.$filter_free;
        $url .='&filter_type='.$filter_type;
        $url .='&filter_keyword='.$filter_keyword;
        $ch            = curl_init($url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_TIMEOUT, 10);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
        $dataApi   = curl_exec($ch);
        curl_close($ch);
        // dd($dataApi);
        $dataApi = json_decode($dataApi, true);

        if (!empty($dataApi['data'])) {
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
            $resultItems = sc_language_render('admin.result_item', ['item_from' => $dataApi['from'] ?? 0, 'item_to' => $dataApi['to']??0, 'total' =>  $dataApi['total'] ?? 0]);
            $htmlPaging .= '<ul class="pagination pagination-sm no-margin pull-right">';
            if ($dataApi['current_page'] > 1) {
                $htmlPaging .= '<li class="page-item"><a class="page-link pjax-container" href="'.sc_route_admin('admin_plugin_online', ['code' => strtolower($code)]).'?page='.($dataApi['current_page'] - 1).'" rel="prev">«</a></li>';
            } else {
                for ($i = 1; $i < $dataApi['last_page']; $i++) {
                    if ($dataApi['current_page'] == $i) {
                        $htmlPaging .= '<li class="page-item active"><span class="page-link pjax-container">'.$i.'</span></li>';
                    } else {
                        $htmlPaging .= '<li class="page-item"><a class="page-link" href="'.sc_route_admin('admin_plugin_online', ['code' => strtolower($code)]).'?page='.$i.'">'.$i.'</a></li>';
                    }
                }
            }
            if ($dataApi['current_page'] < $dataApi['last_page']) {
                $htmlPaging .= '<li class="page-item"><a class="page-link pjax-container" href="'.sc_route_admin('admin_plugin_online', ['code' => strtolower($code)]).'?page='.($dataApi['current_page'] + 1).'" rel="next">»</a></li>';
            }
            $htmlPaging .= '</ul>';
        }
        $code = sc_word_format_class($code);

        $arrPluginLocal = sc_get_all_plugin($code);
        $title = sc_language_render('admin.plugin.' . $code.'_plugin');

        return view($this->templatePathAdmin.'screen.plugin_online')->with(
            [
                "title" => $title,
                "arrPluginLocal" => $arrPluginLocal,
                "code" => $code,
                "filter_keyword" => $filter_keyword ?? '',
                "filter_type" => $filter_type ?? '',
                "filter_free" => $filter_free ?? '',
                "arrPluginLibrary" => $arrPluginLibrary,
                "resultItems" => $resultItems,
                "htmlPaging" => $htmlPaging,
                "dataApi" => $dataApi,
            ]
        );
    }

    public function install()
    {
        $code = request('code');
        $key = request('key');
        $pathPlugin = 'Plugins/'.$code.'/'.$key;

        if (!is_writable(public_path('Plugins/'.$code))) {
            return response()->json(['error' => 1, 'msg' => 'No write permission '.public_path('Plugins/'.$code)]);
        }

        if (!is_writable(app_path('Plugins/'.$code))) {
            return response()->json(['error' => 1, 'msg' => 'No write permission '.app_path('Plugins/'.$code)]);
        }

        if (!is_writable(storage_path('tmp'))) {
            return response()->json(['error' => 1, 'msg' => 'No write permission '.storage_path('tmp')]);
        }

        $path = request('path');
        try {
            $data = file_get_contents($path);
            $pathTmp = $code.'_'.$key.'_'.time();
            $fileTmp = $pathTmp.'.zip';
            Storage::disk('tmp')->put($pathTmp.'/'.$fileTmp, $data);
            $unzip = sc_unzip(storage_path('tmp/'.$pathTmp.'/'.$fileTmp), storage_path('tmp/'.$pathTmp));
            if ($unzip) {
                $checkConfig = glob(storage_path('tmp/'.$pathTmp) . '/*/config.json');

                if (!$checkConfig) {
                    $response = ['error' => 1, 'msg' => 'Cannot found file config.json'];
                    return response()->json($response);
                }

                //Check compatibility 
                $config = json_decode(file_get_contents($checkConfig[0]), true);
                $scartVersion = $config['scartVersion'] ?? '';
                if (!sc_plugin_compatibility_check($scartVersion)) {
                    File::deleteDirectory(storage_path('tmp/'.$pathTmp));
                    $response = ['error' => 1, 'msg' => sc_language_render('admin.plugin.not_compatible', ['version' => $scartVersion, 'sc_version' => config('s-pmo.core')])];
                } else {
                    $folderName = explode('/config.json', $checkConfig[0]);
                    $folderName = explode('/', $folderName[0]);
                    $folderName = end($folderName);
                    File::copyDirectory(storage_path('tmp/'.$pathTmp.'/'.$folderName.'/public'), public_path($pathPlugin));
                    File::copyDirectory(storage_path('tmp/'.$pathTmp.'/'.$folderName), app_path($pathPlugin));
                    File::deleteDirectory(storage_path('tmp/'.$pathTmp));
                    $namespace = sc_get_class_plugin_config($code, $key);
                    $response = (new $namespace)->install();
                }

            } else {
                $response = ['error' => 1, 'msg' => 'error while unzip'];
            }
        } catch (\Throwable $e) {
            $response = ['error' => 1, 'msg' => $e->getMessage()];
        }
        return response()->json($response);
    }
}
