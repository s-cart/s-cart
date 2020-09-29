<?php
#app/Http/Admin/Controllers/AdminStoreMaintainController.php
namespace App\Admin\Controllers;

use App\Http\Controllers\Controller;
use App\Admin\Models\AdminStore;
use App\Models\ShopLanguage;
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
        $id = session('adminStoreId');
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
        $id = session('adminStoreId');
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
            $dataUpdate = [
                'storeId' => $id,
                'lang' => $code,
                'name' => 'maintain_content',
                'value' => $row['maintain_content'],
            ];
            AdminStore::updateDescription($dataUpdate);
        }
//
        return redirect()->route('admin_store_maintain.index')->with('success', trans('store_maintain.admin.edit_success'));

    }
}
