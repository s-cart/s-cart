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
        $dataApi = file_get_contents('https://s-cart.org/api/templates?page[size]=20&page[number]='.$page);
        $dataApi = json_decode($dataApi, true);
        if(!empty($dataApi['data'])) {
            foreach ($dataApi['data'] as $key => $data) {
                $arrTemplateLibrary[] = [
                    'key' => $data['key'],
                    'name' => $data['name'],
                    'description' => $data['description'],
                    'image' => $data['image'],
                    'path' => 'https://s-cart.org/templates/download/'.$data['key'],
                    'price' => $data['price'],
                    'is_free' => $data['is_free'],
                    'downloaded' => $data['downloaded'],
                    'username' =>  $data['username'],
                    'times' =>  $data['times'],
                    'points' =>  $data['points'],
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
