<?php
namespace App\Pmo\Admin\Controllers;

use App\Pmo\Admin\Controllers\RootAdminController;
use App\Pmo\Admin\Models\AdminStore;
use App\Pmo\Front\Models\ShopLanguage;
use Validator;

class AdminStoreMaintainController extends RootAdminController
{
    public $languages;

    public function __construct()
    {
        parent::__construct();
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
            'title' => sc_language_render('admin.maintain.title'),
            'subTitle' => '',
            'title_description' => '',
            'icon' => 'fa fa-edit',
            'languages' => $this->languages,
            'maintain' => $maintain,
            'url_action' => sc_route_admin('admin_store_maintain.index'),
        ];
        return view($this->templatePathAdmin.'screen.store_maintain')
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

            $dataUpdate = [
                'storeId' => $id,
                'lang' => $code,
                'name' => 'maintain_note',
                'value' => $row['maintain_note'],
            ];
            AdminStore::updateDescription($dataUpdate);
        }
//
        return redirect()->route('admin_store_maintain.index')->with('success', sc_language_render('action.edit_success'));
    }
}
