<?php
#app/Http/Admin/Controllers/AdminTemplateOnlineController.php
namespace App\Admin\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;
class AdminTemplateOnlineController extends Controller
{
    public function index()
    {
        $arrTemplateLibrary = [];
        $page = request('page') ?? 1;
        $url = config('scart.api_link').'/templates/?page[size]=20&page[number]='.$page;
        $ch            = curl_init($url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_TIMEOUT, 10);
        $dataApi   = curl_exec($ch);
        curl_close($ch);
        $dataApi = json_decode($dataApi, true);
        if(!empty($dataApi['data'])) {
            foreach ($dataApi['data'] as $key => $data) {
                $arrTemplateLibrary[] = [
                    'sku' => $data['sku'],
                    'key' => $data['key'],
                    'name' => $data['name'],
                    'description' => $data['description'],
                    'image' => $data['image'],
                    'image_demo' => $data['image_demo'],
                    'path' => $data['path'],
                    'file' => $data['file'],
                    'version' => $data['version'],
                    'scart_version' => $data['scart_version'],
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
    
            $title = trans('template.admin.list');
    
            return view('admin.screen.template_online')->with(
                [
                    "title" => $title,
                    "arrTemplateLocal" => sc_get_all_template(),
                    "arrTemplateLibrary" => $arrTemplateLibrary,
                    "resultItems" => $resultItems,
                    "dataApi" => $dataApi,
                ]);

    }

    public function install()
    {
        $response = ['error' => 0, 'msg' => 'Install success'];
        $key = request('key');
        $path = request('path');
        try {
            $data = file_get_contents($path);
            $pathTmp = $key.'_'.time();
            $fileTmp = $pathTmp.'.zip';
            Storage::disk('tmp')->put($fileTmp, $data);
        } catch(\Exception $e) {
            $response = ['error' => 1, 'msg' => $e->getMessage()];
        }

        $unzip = sc_unzip(storage_path('tmp/'.$fileTmp), storage_path('tmp/'.$pathTmp));
        if($unzip) {
            File::copyDirectory(storage_path('tmp/'.$pathTmp.'/'.$key.'/public'), public_path('templates/'.$key));
            File::copyDirectory(storage_path('tmp/'.$pathTmp.'/'.$key.'/views'), resource_path('views/templates/'.$key));
            File::deleteDirectory(storage_path('tmp/'.$pathTmp));
            Storage::disk('tmp')->delete($fileTmp);
        } else {
            $response = ['error' => 1, 'msg' => 'error while unzip'];
        }
        return response()->json($response);
    }

}
