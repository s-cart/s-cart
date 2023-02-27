<?php
namespace App\Pmo\Admin\Controllers;

use App\Pmo\Admin\Controllers\RootAdminController;
use App\Pmo\Front\Models\ShopStoreCss;
use App\Pmo\Admin\Models\AdminTemplate;
use App\Pmo\Admin\Models\AdminStore;
class AdminStoreCssController extends RootAdminController
{
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Form edit
     */
    public function index()
    {
        $storeId = request('store_id', session('adminStoreId'));
        $store     = AdminStore::find($storeId);
        $templates = (new AdminTemplate)->getListTemplate();
        $template = $store->template;
        if (!key_exists($template, $templates)) {
            return redirect()->route('admin.data_not_found')->with(['url' => url()->full()]);
        }
        $cssContent = ShopStoreCss::where('store_id', $storeId)
            ->where('template', $template)
            ->first();

        if (!$cssContent) {
            return redirect()->route('admin.data_not_found')->with(['url' => url()->full()]);
        }
        $data = [
            'title' => sc_language_render('store.admin.css').' #'.$storeId,
            'subTitle' => '',
            'title_description' => '',
            'template' => $template,
            'templates' => $templates,
            'storeId' => $storeId,
            'icon' => 'fa fa-edit',
            'css' => $cssContent->css,
            'url_action' => sc_route_admin('admin_store_css.index'),
        ];
        return view($this->templatePathAdmin.'screen.store_css')
            ->with($data);
    }
    
    /**
     * update css template
     */
    public function postEdit()
    {
        $data = request()->all();
        $storeId = $data['storeId'];
        $template = $data['template'];
        $cssContent = ShopStoreCss::where('store_id', $storeId)->where('template', $template)->first();
        $cssContent->css = request('css');
        $cssContent->save();
        return redirect()->route('admin_store_css.index', ['store_id' => $storeId])->with('success', sc_language_render('action.edit_success'));
    }
}
