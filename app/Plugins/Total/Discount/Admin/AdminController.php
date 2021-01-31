<?php
#App\Plugins\Total\Discount\Admin\AdminController.php

namespace App\Plugins\Total\Discount\Admin;

use App\Plugins\Total\Discount\Admin\Models\AdminDiscount;
use App\Http\Controllers\RootAdminController;
use SCart\Core\Front\Models\ShopLanguage;
use App\Plugins\Total\Discount\AppConfig;
use Validator;
class AdminController extends RootAdminController
{
    public $plugin;

    public function __construct()
    {
        parent::__construct();
        $this->languages = ShopLanguage::getListActive();
        $this->plugin = new AppConfig;
    }

    public function index()
    {
        $data = [
            'title' => trans($this->plugin->pathPlugin.'::lang.admin.list'),
            'subTitle' => '',
            'icon' => 'fa fa-indent',
            'urlDeleteItem' => sc_route_admin('admin_discount.delete'),
            'removeList' => 1, // 1 - Enable function delete list item
            'buttonRefresh' => 1, // 1 - Enable button refresh
            'buttonSort' => 1, // 1 - Enable button sort
        ];
        
        //Process add content
        $data['menuRight'] = sc_config_group('menuRight', \Request::route()->getName());
        $data['menuLeft'] = sc_config_group('menuLeft', \Request::route()->getName());
        $data['topMenuRight'] = sc_config_group('topMenuRight', \Request::route()->getName());
        $data['topMenuLeft'] = sc_config_group('topMenuLeft', \Request::route()->getName());
        $data['blockBottom'] = sc_config_group('blockBottom', \Request::route()->getName());


        $listTh = [
            'code' => trans($this->plugin->pathPlugin.'::lang.code'),
            'reward' => trans($this->plugin->pathPlugin.'::lang.reward'),
            'type' => trans($this->plugin->pathPlugin.'::lang.type'),
            'data' => trans($this->plugin->pathPlugin.'::lang.data'),
            'limit' => trans($this->plugin->pathPlugin.'::lang.limit'),
            'used' => trans($this->plugin->pathPlugin.'::lang.used'),
            'status' => trans($this->plugin->pathPlugin.'::lang.status'),
            'login' => trans($this->plugin->pathPlugin.'::lang.login'),
            'expires_at' => trans($this->plugin->pathPlugin.'::lang.expires_at'),
            'action' => trans($this->plugin->pathPlugin.'::lang.admin.action'),
        ];
        $sort_order = request('sort_order') ?? 'id_desc';
        $keyword = request('keyword') ?? '';
        $arrSort = [
            'id__desc' => trans($this->plugin->pathPlugin.'::lang.admin.sort_order.id_desc'),
            'id__asc' => trans($this->plugin->pathPlugin.'::lang.admin.sort_order.id_asc'),
            'code__desc' => trans($this->plugin->pathPlugin.'::lang.admin.sort_order.code_desc'),
            'code__asc' => trans($this->plugin->pathPlugin.'::lang.admin.sort_order.code_asc'),
        ];
        $dataSearch = [
            'keyword'    => $keyword,
            'sort_order' => $sort_order,
            'arrSort'    => $arrSort,
        ];
        $dataTmp = (new AdminDiscount)->getDiscountListAdmin($dataSearch);

        $dataTr = [];
        foreach ($dataTmp as $key => $row) {
            $dataTr[] = [
                'code' => $row['code'],
                'reward' => $row['reward'],
                'type' => ($row['type'] == 'point') ? 'Point' : '%',
                'data' => $row['data'],
                'limit' => $row['limit'],
                'used' => $row['used'],
                'status' => $row['status'] ? '<span class="label label-success">ON</span>' : '<span class="label label-danger">OFF</span>',
                'login' => $row['login'],
                'expires_at' => $row['expires_at'],
                'action' => '
                    <a href="' . sc_route_admin('admin_discount.edit', ['id' => $row['id']]) . '"><span title="' . trans($this->plugin->pathPlugin.'::lang.admin.edit') . '" type="button" class="btn btn-flat btn-primary"><i class="fa fa-edit"></i></span></a>&nbsp;

                  <span onclick="deleteItem(' . $row['id'] . ');"  title="' . trans($this->plugin->pathPlugin.'::lang.admin.delete') . '" class="btn btn-flat btn-danger"><i class="fa fa-trash"></i></span>
                  ',
            ];
        }

        $data['listTh'] = $listTh;
        $data['dataTr'] = $dataTr;
        $data['pagination'] = $dataTmp->appends(request()->except(['_token', '_pjax']))->links($this->templatePathAdmin.'.component.pagination');
        $data['resultItems'] = trans($this->plugin->pathPlugin.'::lang.admin.result_item', ['item_from' => $dataTmp->firstItem(), 'item_to' => $dataTmp->lastItem(), 'item_total' => $dataTmp->total()]);

        //menuRight
        $data['menuRight'][] = '<a href="' . sc_route_admin('admin_discount.create') . '" class="btn  btn-success  btn-flat" title="New" id="button_create_new">
                           <i class="fa fa-plus" title="' . trans($this->plugin->pathPlugin.'::lang.admin.add_new') . '"></i>
                           </a>';
        //=menuRight

        //menuSort
        $optionSort = '';
        foreach ($arrSort as $key => $status) {
            $optionSort .= '<option  ' . (($sort_order == $key) ? "selected" : "") . ' value="' . $key . '">' . $status . '</option>';
        }
        $data['urlSort'] = sc_route_admin('admin_discount.index', request()->except(['_token', '_pjax', 'sort_order']));
        $data['optionSort'] = $optionSort;
        //=menuSort

        //menuSearch
        $data['topMenuRight'][] = '
              <form action="' . sc_route_admin('admin_discount.index') . '" id="button_search">
                <div class="input-group input-group" style="width: 250px;">
                    <input type="text" name="keyword" class="form-control float-right" placeholder="' . trans($this->plugin->pathPlugin.'::lang.admin.search_place') . '" value="' . $keyword . '">
                    <div class="input-group-append">
                        <button type="submit" class="btn btn-primary"><i class="fas fa-search"></i></button>
                    </div>
                </div>
                </form>';
        //=menuSearch

        return view($this->templatePathAdmin.'.screen.list')
            ->with($data);
    }

/**
 * Form create new
 * @return [type] [description]
 */
    public function create()
    {
        $data = [
            'title' => trans($this->plugin->pathPlugin.'::lang.admin.add_new_title'),
            'subTitle' => '',
            'title_description' => trans($this->plugin->pathPlugin.'::lang.admin.add_new_des'),
            'icon' => 'fa fa-plus',
            'discount' => [],
            'url_action' => sc_route_admin('admin_discount.create'),
        ];
        return view($this->plugin->pathPlugin.'::Admin')
            ->with($data);
    }

/**
 * Post create new 
 * @return [type] [description]
 */
    public function postCreate()
    {
        $data = request()->all();
        $validator = Validator::make($data, [
            'code'   => 'required|regex:/(^([0-9A-Za-z\-\._]+)$)/|discount_unique|string|max:50',
            'limit'  => 'required|numeric|min:1',
            'reward' => 'required|numeric|min:0',
            'type'   => 'required',
        ], [
            'code.regex' => trans($this->plugin->pathPlugin.'::lang.admin.code_validate'),
            'code.discount_unique' => trans($this->plugin->pathPlugin.'::lang.discount_unique'),
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }
        $dataInsert = [
            'code'       => $data['code'],
            'reward'     => (int)$data['reward'],
            'limit'      => $data['limit'],
            'type'       => $data['type'],
            'data'       => $data['data'],
            'login'      => empty($data['login']) ? 0 : 1,
            'status'     => empty($data['status']) ? 0 : 1,
            'store_id'   => session('adminStoreId'),
        ];
        if(!empty($data['expires_at'])) {
            $dataInsert['expires_at'] = $data['expires_at'];
        }
        AdminDiscount::createDiscountAdmin($dataInsert);

        return redirect()->route('admin_discount.index')->with('success', trans($this->plugin->pathPlugin.'::lang.admin.create_success'));

    }

    /**
     * Form edit
     */
    public function edit($id)
    {
        $discount = AdminDiscount::getDiscountAdmin($id);
        if (!$discount) {
            return redirect()->route('admin.data_not_found')->with(['url' => url()->full()]);
        }

        $data = [
            'title'             => trans($this->plugin->pathPlugin.'::lang.admin.edit'),
            'subTitle'          => '',
            'title_description' => '',
            'icon'              => 'fa fa-pencil-square-o',
            'discount'          => $discount,
            'url_action'        => sc_route_admin('admin_discount.edit', ['id' => $discount['id']]),
        ];
        return view($this->plugin->pathPlugin.'::Admin')
            ->with($data);
    }

    /**
     * update
     */
    public function postEdit($id)
    {
        $discount = AdminDiscount::getDiscountAdmin($id);
        if (!$discount) {
            return redirect()->route('admin.data_not_found')->with(['url' => url()->full()]);
        }
        $data = request()->all();
        $validator = Validator::make($data, [
            'code' => 'required|regex:/(^([0-9A-Za-z\-\._]+)$)/|discount_unique:' . $discount->id . '|string|max:50',
            'limit' => 'required|numeric|min:1',
            'reward' => 'required|numeric|min:0',
            'type' => 'required',
        ], [
            'code.regex' => trans($this->plugin->pathPlugin.'::lang.admin.code_validate'),
            'code.discount_unique' => trans($this->plugin->pathPlugin.'::lang.discount_unique'),
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }
        //Edit
        $dataUpdate = [
            'code'       => $data['code'],
            'reward'     => (int)$data['reward'],
            'limit'      => $data['limit'],
            'type'       => $data['type'],
            'data'       => $data['data'],
            'login'      => empty($data['login']) ? 0 : 1,
            'status'     => empty($data['status']) ? 0 : 1,
            'store_id'   => session('adminStoreId'),
        ];
        if(!empty($data['expires_at'])) {
            $dataUpdate['expires_at'] = $data['expires_at'];
        }
        $discount->update($dataUpdate);

        return redirect()->route('admin_discount.index')
            ->with('success', trans($this->plugin->pathPlugin.'::lang.admin.edit_success'));

    }

    /*
    Delete list item
    Need mothod destroy to boot deleting in model
    */
    public function deleteList()
    {
        if (!request()->ajax()) {
            return 0;
        } else {
            $ids = request('ids');
            $arrID = explode(',', $ids);
            $arrDontPermission = [];
            foreach ($arrID as $key => $id) {
                if(!$this->checkPermisisonItem($id)) {
                    $arrDontPermission[] = $id;
                }
            }
            if (count($arrDontPermission)) {
                return response()->json(['error' => 1, 'msg' => trans('admin.remove_dont_permisison') . ': ' . json_encode($arrDontPermission)]);
            }
            AdminDiscount::destroy($arrID);
            return response()->json(['error' => 0, 'msg' => '']);
        }
    }

    /**
     * Check permisison item
     */
    public function checkPermisisonItem($id) {
        return AdminDiscount::getDiscountAdmin($id);
    }
}
