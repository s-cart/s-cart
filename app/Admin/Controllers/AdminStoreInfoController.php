<?php
#app/Http/Admin/Controllers/AdminStoreInfoController.php
namespace App\Admin\Controllers;

use App\Http\Controllers\Controller;
use App\Models\AdminStore;
use App\Models\AdminStoreDescription;
use App\Models\ShopLanguage;
use Illuminate\Http\Request;

class AdminStoreInfoController extends Controller
{

    public function index()
    {
        $languages = ShopLanguage::getCodeActive();
        $data = [
            'title' => trans('store_info.admin.list'),
            'subTitle' => '',
            'icon' => 'fa fa-indent',        ];

        $infosDescription = [];
        foreach ($languages as $code => $lang) {
            $langDescriptions = AdminStoreDescription::where('lang', $code)->first();
            $infosDescription['title'][$code] = $langDescriptions['title'];
            $infosDescription['description'][$code] = $langDescriptions['description'];
            $infosDescription['keyword'][$code] = $langDescriptions['keyword'];
            $infosDescription['maintain_content'][$code] = $langDescriptions['maintain_content'];
        }

        $infos = AdminStore::first();
        $data['infos'] = $infos;
        $data['infosDescription'] = $infosDescription;
        $data['languages'] = $languages;

        return view('admin.screen.store_info')
            ->with($data);
    }

/*
Update value config
 */
    public function updateInfo()
    {
        $data = request()->all();
        $name = $data['name'];
        $value = $data['value'];
        $parseName = explode('__', $name);
        if (!in_array($parseName[0], ['title', 'description', 'keyword', 'maintain_content'])) {
            try {
                AdminStore::first()->update([$name => $value]);
                $error = 0;
            } catch (\Exception $e) {
                $error = 1;
            }
            
        } else {
            try {
                AdminStore::first()
                ->descriptions()
                ->where('lang', $parseName[1])->update([$parseName[0] => $value]);
                $error = 0;
            } catch (\Exception $e) {
                $error = 1;
            }
            
        }
        return response()->json(['error' => $error]);

    }

}
