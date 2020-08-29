<?php
#app/Http/Admin/Controllers/AdminReportController.php
namespace App\Admin\Controllers;

use App\Http\Controllers\Controller;
use App\Models\ShopAttributeGroup;
use App\Models\ShopLanguage;
use App\Models\ShopProduct;
use Illuminate\Http\Request;

class AdminReportController extends Controller
{
    public $languages, $kinds, $propertys, $attributeGroup;

    public function __construct()
    {
        $this->languages = ShopLanguage::getListActive();
        $this->attributeGroup = ShopAttributeGroup::getListAll();
        $this->kinds = [
            SC_PRODUCT_SINGLE => trans('product.kinds.single'),
            SC_PRODUCT_BUILD => trans('product.kinds.build'),
            SC_PRODUCT_GROUP => trans('product.kinds.group'),
        ];
        $this->propertys = [
            SC_PROPERTY_PHYSICAL => trans('product.propertys.physical'),
            SC_PROPERTY_DOWNLOAD => trans('product.propertys.download'),
            SC_PROPERTY_ONLY_VIEW => trans('product.propertys.only_view'),
            SC_PROPERTY_SERVICE => trans('product.propertys.service'),
        ];

    }

    public function product()
    {
        $data = [
            'title' => trans('product.admin.list'),
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
            'id' => trans('product.id'),
            'image' => trans('product.image'),
            'sku' => trans('product.sku'),
            'name' => trans('product.name'),
            'price' => trans('product.price'),
            'stock' => trans('product.stock'),
            'sold' => trans('product.sold'),
            'view' => trans('product.view'),
            'kind' => trans('product.kind'),
            'status' => trans('product.status'),
        ];
        $sort_order = request('sort_order') ?? 'id_desc';
        $keyword = request('keyword') ?? '';
        $arrSort = [
            'id__desc' => trans('product.admin.sort_order.id_desc'),
            'id__asc' => trans('product.admin.sort_order.id_asc'),
            'name__desc' => trans('product.admin.sort_order.name_desc'),
            'name__asc' => trans('product.admin.sort_order.name_asc'),
            'sold__desc' => trans('product.admin.sort_order.sold_desc'),
            'sold__asc' => trans('product.admin.sort_order.sold_asc'),
            'view__desc' => trans('product.admin.sort_order.view_desc'),
            'view__asc' => trans('product.admin.sort_order.view_asc'),
        ];
        $obj = new ShopProduct;

        $obj = $obj
            ->leftJoin(SC_DB_PREFIX.'shop_product_description', SC_DB_PREFIX.'shop_product_description.product_id', SC_DB_PREFIX.'shop_product.id')
            ->where(SC_DB_PREFIX.'shop_product_description.lang', sc_get_locale());
        if ($keyword) {
            $obj = $obj->whereRaw('('.SC_DB_PREFIX.'shop_product_description.name like "%' . $keyword . '%"  OR sku like "%' . $keyword . '%")');
        }
        if ($sort_order && array_key_exists($sort_order, $arrSort)) {
            $field = explode('__', $sort_order)[0];
            $sort_field = explode('__', $sort_order)[1];
            $obj = $obj->orderBy($field, $sort_field);

        } else {
            $obj = $obj->orderBy('id', 'desc');
        }
        $dataTmp = $obj->paginate(20);

        $dataTr = [];
        foreach ($dataTmp as $key => $row) {
            $kind = $this->kinds[$row['kind']] ?? $row['kind'];
            if ($row['kind'] == SC_PRODUCT_BUILD) {
                $kind = '<span class="badge badge-success">' . $kind . '</span>';
            } elseif ($row['kind'] == SC_PRODUCT_GROUP) {
                $kind = '<span class="badge badge-danger">' . $kind . '</span>';
            }

            $dataTr[] = [
                'id' => $row['id'],
                'image' => sc_image_render($row['image'], '50px','', $row['name']),
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
        $data['pagination'] = $dataTmp->appends(request()->except(['_token', '_pjax']))->links('admin.component.pagination');
        $data['resultItems'] = trans('product.admin.result_item', ['item_from' => $dataTmp->firstItem(), 'item_to' => $dataTmp->lastItem(), 'item_total' => $dataTmp->total()]);

//menu_left
        $data['menu_left'] = '<div class="pull-left">

                    <a class="btn   btn-flat btn-primary grid-refresh" title="Refresh"><i class="fas fa-sync-alt"></i><span class="hidden-xs"> ' . trans('admin.refresh') . '</span></a> &nbsp;</div>
                    ';
//=menu_left

//menuSearch
        $optionSort = '';
        foreach ($arrSort as $key => $status) {
            $optionSort .= '<option  ' . (($sort_order == $key) ? "selected" : "") . ' value="' . $key . '">' . $status . '</option>';
        }

        $data['urlSort'] = sc_route('admin_report.product');
        $data['optionSort'] = $optionSort;
//=menuSort

//menuSearch
        $data['topMenuRight'][] = '
                <form action="' . sc_route('admin_report.product') . '" id="button_search">
                <div class="input-group input-group" style="width: 250px;">
                    <input type="text" name="keyword" class="form-control float-right" placeholder="' . trans('product.admin.search_place') . '" value="' . $keyword . '">
                    <div class="input-group-append">
                        <button type="submit" class="btn btn-primary"><i class="fas fa-search"></i></button>
                    </div>
                </div>
                </form>';
//=menuSearch

        return view('admin.screen.list')
            ->with($data);
    }

}
