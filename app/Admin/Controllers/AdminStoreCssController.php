<?php
#app/Http/Admin/Controllers/AdminStoreCssController.php
namespace App\Admin\Controllers;

use App\Http\Controllers\Controller;
use App\Models\ShopStoreCss;

class AdminStoreCssController extends Controller
{


/**
 * Form edit
 */
    public function index()
    {
        $id = session('adminStoreId');;
        $cssContent = ShopStoreCss::where('store_id', $id)->first();
        if (!$cssContent) {
            return 'no data';
        }
        $data = [
            'title' => trans('store.css'),
            'subTitle' => '',
            'title_description' => '',
            'icon' => 'fa fa-edit',
            'css' => $cssContent->css,
            'url_action' => sc_route('admin_store_css.index'),
        ];
        return view('admin.screen.css')
            ->with($data);
    }

/**
 * update status
 */
    public function postEdit()
    {
        $id = session('adminStoreId');;
        $cssContent = ShopStoreCss::where('store_id', $id)->first();
        $cssContent->css = request('css');
        $cssContent->save();
        return redirect()->route('admin_store_css.index')->with('success', trans('store_maintain.admin.edit_success'));

    }
}
