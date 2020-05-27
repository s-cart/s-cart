<?php
#app/Http/Admin/Controllers/AdminMaintainController.php
namespace App\Admin\Controllers;

use App\Http\Controllers\Controller;
use App\Models\AdminStore;
use App\Models\ShopLanguage;
use App\Models\AdminStoreDescription;
use Illuminate\Http\Request;
use Validator;

class AdminMaintainController extends Controller
{
    public $languages;

    public function __construct()
    {
        $this->languages = ShopLanguage::getList();

    }
    
    public function index()
    {
        $languages = ShopLanguage::getCodeActive();
        $data = [
            'title' => trans('maintain.admin.title'),
            'subTitle' => '',
            'icon' => 'fa fa-indent',        ];

        $obj = (new AdminStore)->with('descriptions')->first();
        $data['obj'] = $obj;
        $data['languages'] = $languages;
        return view('admin.screen.maintain')
            ->with($data);
    }

/**
 * Form edit
 */
    public function edit()
    {
        $maintain = AdminStore::find(1);
        if ($maintain === null) {
            return 'no data';
        }
        $data = [
            'title' => trans('maintain.admin.title'),
            'subTitle' => '',
            'title_description' => '',
            'icon' => 'fa fa-pencil-square-o',
            'languages' => $this->languages,
            'maintain' => $maintain,
            'url_action' => route('admin_maintain.edit'),
        ];
        return view('admin.screen.maintain_edit')
            ->with($data);
    }

/**
 * update status
 */
    public function postEdit()
    {
        $id = 1;
        $data = request()->all();
        $dataOrigin = request()->all();
        $validator = Validator::make($dataOrigin, [
            'descriptions.*.maintain_content' => 'required|string',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }
        //Edit
        foreach ($data['descriptions'] as $code => $row) {
            (new AdminStoreDescription)->where('config_id', $id)->where('lang', $code)
            ->update(['maintain_content' => $row['maintain_content']]);
        }
//
        return redirect()->route('admin_maintain.index')->with('success', trans('maintain.admin.edit_success'));

    }
}
