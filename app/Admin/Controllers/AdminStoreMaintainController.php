<?php
#app/Http/Admin/Controllers/AdminStoreMaintainController.php
namespace App\Admin\Controllers;

use App\Http\Controllers\Controller;
use App\Models\AdminStore;
use App\Models\ShopLanguage;
use App\Models\AdminStoreDescription;
use Illuminate\Http\Request;
use Validator;

class AdminStoreMaintainController extends Controller
{
    public $languages;

    public function __construct()
    {
        $this->languages = ShopLanguage::getListActive();
    }

/**
 * Form edit
 */
    public function index()
    {
        $id = session('adminStoreId');;
        $maintain = AdminStore::find($id);
        if ($maintain === null) {
            return 'no data';
        }
        $data = [
            'title' => trans('store_maintain.admin.title'),
            'subTitle' => '',
            'title_description' => '',
            'icon' => 'fa fa-edit',
            'languages' => $this->languages,
            'maintain' => $maintain,
            'url_action' => sc_route('admin_store_maintain.index'),
        ];
        return view('admin.screen.store_maintain')
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
            (new AdminStoreDescription)->where('store_id', $id)->where('lang', $code)
            ->update(['maintain_content' => $row['maintain_content']]);
        }
//
        return redirect()->route('admin_store_maintain.index')->with('success', trans('store_maintain.admin.edit_success'));

    }
}
