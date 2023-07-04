<?php
#App\Plugins\Total\Discount\Admin\AdminController.php

namespace App\Plugins\Total\Discount\Admin;

use App\Plugins\Total\Discount\Admin\Models\AdminDiscount;
use SCart\Core\Admin\Controllers\RootAdminController;
use SCart\Core\Front\Models\ShopLanguage;
use App\Plugins\Total\Discount\AppConfig;
use App\Plugins\Total\Discount\Models\ShopDiscountStore;
use SCart\Core\Admin\Models\AdminStore;
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
            'title' => sc_language_render($this->plugin->pathPlugin.'::lang.admin.list'),
            'subTitle' => '',
            'icon' => 'fa fa-indent',
            'urlDeleteItem' => sc_route_admin('admin_discount.delete'),
            'removeList' => 1, // 1 - Enable function delete list item
            'buttonRefresh' => 1, // 1 - Enable button refresh
        ];
        
        //Process add content
        $data['menuRight'] = sc_config_group('menuRight', \Request::route()->getName());
        $data['menuLeft'] = sc_config_group('menuLeft', \Request::route()->getName());
        $data['topMenuRight'] = sc_config_group('topMenuRight', \Request::route()->getName());
        $data['topMenuLeft'] = sc_config_group('topMenuLeft', \Request::route()->getName());
        $data['blockBottom'] = sc_config_group('blockBottom', \Request::route()->getName());


        $listTh = [
            'code' => sc_language_render($this->plugin->pathPlugin.'::lang.code'),
            'reward' => sc_language_render($this->plugin->pathPlugin.'::lang.reward'),
            'type' => sc_language_render($this->plugin->pathPlugin.'::lang.type'),
            'data' => sc_language_render($this->plugin->pathPlugin.'::lang.data'),
            'used' => sc_language_render($this->plugin->pathPlugin.'::lang.used'),
            'status' => sc_language_render($this->plugin->pathPlugin.'::lang.status'),
        ];

        if (sc_check_multi_shop_installed()) {
            if (session('adminStoreId') == SC_ID_ROOT) {
                // Only show store info if store is root
                $listTh['shop_store'] = sc_language_render('front.store_list');
            }
        }
        $listTh['login'] = sc_language_render($this->plugin->pathPlugin.'::lang.login');
        $listTh['expires_at'] = sc_language_render($this->plugin->pathPlugin.'::lang.expires_at');
        $listTh['action'] = sc_language_render($this->plugin->pathPlugin.'::lang.admin.action');


        $sort_order = request('sort_order') ?? 'id_desc';
        $keyword = request('keyword') ?? '';
        $arrSort = [
            'id__desc' => sc_language_render($this->plugin->pathPlugin.'::lang.admin.sort_order.id_desc'),
            'id__asc' => sc_language_render($this->plugin->pathPlugin.'::lang.admin.sort_order.id_asc'),
            'code__desc' => sc_language_render($this->plugin->pathPlugin.'::lang.admin.sort_order.code_desc'),
            'code__asc' => sc_language_render($this->plugin->pathPlugin.'::lang.admin.sort_order.code_asc'),
        ];
        $dataSearch = [
            'keyword'    => $keyword,
            'sort_order' => $sort_order,
            'arrSort'    => $arrSort,
        ];

        $dataTmp = (new AdminDiscount)->getDiscountListAdmin($dataSearch);
        $arrDiscountId = $dataTmp->pluck('id')->toArray();
        if (sc_check_multi_shop_installed()) {
            if (session('adminStoreId') == SC_ID_ROOT) {
                // Only show store info if store is root
                $tableStore = (new AdminStore)->getTable();
                $tableDiscountStore = (new ShopDiscountStore)->getTable();
                $dataStores =  ShopDiscountStore::select($tableStore.'.code', $tableStore.'.id', 'discount_id')
                    ->join($tableStore, $tableStore.'.id', $tableDiscountStore.'.store_id')
                    ->whereIn('discount_id', $arrDiscountId)
                    ->get()
                    ->groupBy('discount_id');
            }
        }

        $dataTr = [];
        foreach ($dataTmp as $key => $row) {
            $dataMap = [
                'code' => $row['code'],
                'reward' => $row['reward'],
                'type' => ($row['type'] == 'point') ? 'Point' : '%',
                'data' => $row['data'],
                'used' => $row['used'].'/'.$row['limit'],
                'status' => $row['status'] ? '<span class="label label-success">ON</span>' : '<span class="label label-danger">OFF</span>',
            ];

            if (sc_check_multi_shop_installed()) {
                $dataMap['shop_store'] = '';
                if (session('adminStoreId') == SC_ID_ROOT) {
                    // Only show store info if store is root
                    if (!empty($dataStores[$row['id']])) {
                       $storeTmp = $dataStores[$row['id']]->pluck('code', 'id')->toArray();
                       $storeTmp = array_map(function($code) {
                            return '<a target=_new href="'.sc_get_domain_from_code($code).'">'.$code.'</a>';
                        }, $storeTmp);
                       $dataMap['shop_store'] = '<i class="nav-icon fab fa-shopify"></i> '.implode('<br><i class="nav-icon fab fa-shopify"></i> ', $storeTmp);
                    }
                }
            }

            $dataMap['login'] = $row['login'];
            $dataMap['expires_at'] = $row['expires_at'];
            $dataMap['action'] = '<a href="' . sc_route_admin('admin_discount.edit', ['id' => $row['id'] ? $row['id'] : 'not-found-id']) . '"><span title="' . sc_language_render($this->plugin->pathPlugin.'::lang.admin.edit') . '" type="button" class="btn btn-flat btn-primary"><i class="fa fa-edit"></i></span></a>&nbsp;
                                <span onclick="deleteItem(\'' . $row['id'] . '\');"  title="' . sc_language_render($this->plugin->pathPlugin.'::lang.admin.delete') . '" class="btn btn-flat btn-danger"><i class="fa fa-trash"></i></span>';
            $dataTr[$row['id']] = $dataMap;
        }

        $data['listTh'] = $listTh;
        $data['dataTr'] = $dataTr;
        $data['pagination'] = $dataTmp->appends(request()->except(['_token', '_pjax']))->links($this->templatePathAdmin.'.component.pagination');
        $data['resultItems'] = sc_language_render($this->plugin->pathPlugin.'::lang.admin.result_item', ['item_from' => $dataTmp->firstItem(), 'item_to' => $dataTmp->lastItem(), 'total' =>  $dataTmp->total()]);

        //menuRight
        $data['menuRight'][] = '<a href="' . sc_route_admin('admin_discount.create') . '" class="btn  btn-success  btn-flat" title="New" id="button_create_new">
                           <i class="fa fa-plus" title="' . sc_language_render($this->plugin->pathPlugin.'::lang.admin.add_new') . '"></i>
                           </a>';
        //=menuRight

        //menuSort
        $optionSort = '';
        foreach ($arrSort as $key => $status) {
            $optionSort .= '<option  ' . (($sort_order == $key) ? "selected" : "") . ' value="' . $key . '">' . $status . '</option>';
        }
        //=menuSort

        //menuSearch
        $data['topMenuRight'][] = '
              <form action="' . sc_route_admin('admin_discount.index') . '" id="button_search">
                <div class="input-group input-group" style="width: 350px;">
                <select class="form-control rounded-0 select2" name="sort_order" id="sort_order">
                '.$optionSort.'
                </select> &nbsp;
                    <input type="text" name="keyword" class="form-control float-right" placeholder="' . sc_language_render($this->plugin->pathPlugin.'::lang.admin.search_place') . '" value="' . $keyword . '">
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
            'title' => sc_language_render($this->plugin->pathPlugin.'::lang.admin.add_new_title'),
            'subTitle' => '',
            'title_description' => sc_language_render($this->plugin->pathPlugin.'::lang.admin.add_new_des'),
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
            'code.regex' => sc_language_render($this->plugin->pathPlugin.'::lang.admin.code_validate'),
            'code.discount_unique' => sc_language_render($this->plugin->pathPlugin.'::lang.discount_unique'),
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
        ];
        if(!empty($data['expires_at'])) {
            $dataInsert['expires_at'] = $data['expires_at'];
        }
        $dataInsert = sc_clean($dataInsert, [], true);
        $discount = AdminDiscount::createDiscountAdmin($dataInsert);

        $shopStore        = $data['shop_store'] ?? [session('adminStoreId')];
        $discount->stores()->detach();
        if ($shopStore) {
            $discount->stores()->attach($shopStore);
        }

        return redirect()->route('admin_discount.index')->with('success', sc_language_render($this->plugin->pathPlugin.'::lang.admin.create_success'));

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
            'title'             => sc_language_render($this->plugin->pathPlugin.'::lang.admin.edit'),
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
            'code.regex' => sc_language_render($this->plugin->pathPlugin.'::lang.admin.code_validate'),
            'code.discount_unique' => sc_language_render($this->plugin->pathPlugin.'::lang.discount_unique'),
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
        ];
        if(!empty($data['expires_at'])) {
            $dataUpdate['expires_at'] = $data['expires_at'];
        }
        $dataUpdate = sc_clean($dataUpdate, [], true);
        $discount->update($dataUpdate);

        $shopStore        = $data['shop_store'] ?? [session('adminStoreId')];
        $discount->stores()->detach();
        if ($shopStore) {
            $discount->stores()->attach($shopStore);
        }
    
        return redirect()->route('admin_discount.index')
            ->with('success', sc_language_render($this->plugin->pathPlugin.'::lang.admin.edit_success'));

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
                return response()->json(['error' => 1, 'msg' => sc_language_render('admin.remove_dont_permisison') . ': ' . json_encode($arrDontPermission)]);
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
