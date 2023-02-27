<?php
namespace App\Pmo\Admin\Controllers;

use App\Pmo\Admin\Controllers\RootAdminController;
use App\Pmo\Front\Models\ShopAttributeGroup;
use App\Pmo\Front\Models\ShopProductProperty;
use App\Pmo\Front\Models\ShopLanguage;
use App\Pmo\Admin\Models\AdminProduct;

class AdminReportController extends RootAdminController
{
    public $languages;
    public $kinds;
    public $properties;
    public $attributeGroup;

    public function __construct()
    {
        parent::__construct();
        $this->languages = ShopLanguage::getListActive();
        $this->attributeGroup = ShopAttributeGroup::getListAll();
        $this->kinds = [
            SC_PRODUCT_SINGLE => sc_language_render('product.kind_single'),
            SC_PRODUCT_BUILD => sc_language_render('product.kind_bundle'),
            SC_PRODUCT_GROUP => sc_language_render('product.kind_group'),
        ];
        $this->properties = (new ShopProductProperty)->pluck('name', 'code')->toArray();
    }

    public function product()
    {
        $data = [
            'title' => sc_language_render('product.admin.list'),
            'subTitle' => '',
            'icon' => 'fa fa-indent',
            'urlDeleteItem' => '',
            'removeList' => 0, // 1 - Enable function delete list item
            'buttonRefresh' => 0, // 1 - Enable button refresh
            'buttonSort' => 1, // 1 - Enable button sort
            'css' => '',
            'js' => '',
        ];
        //Process add content
        $data['menuRight'] = sc_config_group('menuRight', \Request::route()->getName());
        $data['menuLeft'] = sc_config_group('menuLeft', \Request::route()->getName());
        $data['topMenuRight'] = sc_config_group('topMenuRight', \Request::route()->getName());
        $data['topMenuLeft'] = sc_config_group('topMenuLeft', \Request::route()->getName());
        $data['blockBottom'] = sc_config_group('blockBottom', \Request::route()->getName());

        $listTh = [
            'image' => sc_language_render('product.image'),
            'sku' => sc_language_render('product.sku'),
            'name' => sc_language_render('product.name'),
            'price' => sc_language_render('product.price'),
            'stock' => sc_language_render('product.stock'),
            'sold' => sc_language_render('product.sold'),
            'view' => sc_language_render('product.view'),
            'kind' => sc_language_render('product.kind'),
            'status' => sc_language_render('product.status'),
        ];
        $sort_order = sc_clean(request('sort_order') ?? 'id_desc');
        $keyword    = sc_clean(request('keyword') ?? '');
        $arrSort = [
            'id__desc' => sc_language_render('filter_sort.id_desc'),
            'id__asc' => sc_language_render('filter_sort.id_asc'),
            'name__desc' => sc_language_render('filter_sort.name_desc'),
            'name__asc' => sc_language_render('filter_sort.name_asc'),
            'sold__desc' => sc_language_render('filter_sort.value_desc'),
            'sold__asc' => sc_language_render('filter_sort.sold_asc'),
            'view__desc' => sc_language_render('filter_sort.view_desc'),
            'view__asc' => sc_language_render('filter_sort.view_asc'),
        ];
        $dataSearch = [
            'keyword'    => $keyword,
            'sort_order' => $sort_order,
            'arrSort'    => $arrSort,
        ];

        $dataTmp = (new AdminProduct)->getProductListAdmin($dataSearch);

        $dataTr = [];
        foreach ($dataTmp as $key => $row) {
            $kind = $this->kinds[$row['kind']] ?? $row['kind'];
            if ($row['kind'] == SC_PRODUCT_BUILD) {
                $kind = '<span class="badge badge-success">' . $kind . '</span>';
            } elseif ($row['kind'] == SC_PRODUCT_GROUP) {
                $kind = '<span class="badge badge-danger">' . $kind . '</span>';
            }

            $dataTr[$row['id']] = [
                'image' => sc_image_render($row['image'], '50px', '', $row['name']),
                'sku' => $row['sku'],
                'name' => $row['name'],
                'price' => $row['price'],
                'stock' => $row['stock'],
                'sold' => $row['sold'],
                'view' => $row['view'],
                'kind' => $kind,
                'status' => $row['status'] ? '<span class="badge badge-success">ON</span>' : '<span class="badge badge-danger">OFF</span>',
            ];
        }

        $data['listTh'] = $listTh;
        $data['dataTr'] = $dataTr;
        $data['pagination'] = $dataTmp->appends(request()->except(['_token', '_pjax']))->links($this->templatePathAdmin.'component.pagination');
        $data['resultItems'] = sc_language_render('product.admin.result_item', ['item_from' => $dataTmp->firstItem(), 'item_to' => $dataTmp->lastItem(), 'total' =>  $dataTmp->total()]);

        //menu_left
        $data['menu_left'] = '<div class="pull-left">

                    <a class="btn   btn-flat btn-primary grid-refresh" title="Refresh"><i class="fas fa-sync-alt"></i><span class="hidden-xs"> ' . sc_language_render('action.refresh') . '</span></a> &nbsp;</div>
                    ';
        //=menu_left

        //menuSearch
        $optionSort = '';
        foreach ($arrSort as $key => $status) {
            $optionSort .= '<option  ' . (($sort_order == $key) ? "selected" : "") . ' value="' . $key . '">' . $status . '</option>';
        }
        $data['urlSort'] = sc_route_admin('admin_report.product', request()->except(['_token', '_pjax', 'sort_order']));

        $data['optionSort'] = $optionSort;
        //=menuSort

        //menuSearch
        $data['topMenuRight'][] = '
                <form action="' . sc_route_admin('admin_report.product') . '" id="button_search">
                <div class="input-group input-group" style="width: 350px;">
                    <input type="text" name="keyword" class="form-control rounded-0 float-right" placeholder="' . sc_language_render('product.admin.search_place') . '" value="' . $keyword . '">
                    <div class="input-group-append">
                        <button type="submit" class="btn btn-primary"><i class="fas fa-search"></i></button>
                    </div>
                </div>
                </form>';
        //=menuSearch

        return view($this->templatePathAdmin.'screen.list')
            ->with($data);
    }
}
