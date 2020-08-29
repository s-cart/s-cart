<?php
#App\Plugins\Total\Discount\Admin\AdminController.php

namespace App\Plugins\Total\Discount\Admin;

use App\Plugins\Total\Discount\Models\PluginModel;
use App\Http\Controllers\Controller;
use App\Models\ShopLanguage;
use App\Plugins\Total\Discount\AppConfig;
use Validator;
use App\Models\AdminStore;
class AdminController extends Controller
{
    public $plugin;
    public $stories;

    public function __construct()
    {
        $this->languages = ShopLanguage::getListActive();
        $this->plugin = new AppConfig;
        $this->stories = AdminStore::getListAll();

    }
    public function index()
    {

        $data = [
            'title' => trans($this->plugin->pathPlugin.'::lang.admin.list'),
            'subTitle' => '',
            'icon' => 'fa fa-indent',
            'urlDeleteItem' => sc_route('admin_discount.delete'),
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

        $data['stories'] = $this->stories;

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
        $obj = (new PluginModel);
        if ($keyword) {
            $obj = $obj->whereRaw('code like "%' . $keyword . '%" )');
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
                    <a href="' . sc_route('admin_discount.edit', ['id' => $row['id']]) . '"><span title="' . trans($this->plugin->pathPlugin.'::lang.admin.edit') . '" type="button" class="btn btn-flat btn-primary"><i class="fa fa-edit"></i></span></a>&nbsp;

                  <span onclick="deleteItem(' . $row['id'] . ');"  title="' . trans($this->plugin->pathPlugin.'::lang.admin.delete') . '" class="btn btn-flat btn-danger"><i class="fa fa-trash"></i></span>
                  ',
            ];
        }

        $data['listTh'] = $listTh;
        $data['dataTr'] = $dataTr;
        $data['pagination'] = $dataTmp->appends(request()->except(['_token', '_pjax']))->links('admin.component.pagination');
        $data['resultItems'] = trans($this->plugin->pathPlugin.'::lang.admin.result_item', ['item_from' => $dataTmp->firstItem(), 'item_to' => $dataTmp->lastItem(), 'item_total' => $dataTmp->total()]);

//menuRight
        $data['menuRight'][] = '<a href="' . sc_route('admin_discount.create') . '" class="btn  btn-success  btn-flat" title="New" id="button_create_new">
                           <i class="fa fa-plus" title="' . trans($this->plugin->pathPlugin.'::lang.admin.add_new') . '"></i>
                           </a>';
//=menuRight

//menuSort
        $optionSort = '';
        foreach ($arrSort as $key => $status) {
            $optionSort .= '<option  ' . (($sort_order == $key) ? "selected" : "") . ' value="' . $key . '">' . $status . '</option>';
        }

        $data['urlSort'] = sc_route('admin_discount.index');
        $data['optionSort'] = $optionSort;
//=menuSort

//menuSearch
        $data['topMenuRight'][] = '
              <form action="' . sc_route('admin_discount.index') . '" id="button_search">
                <div class="input-group input-group" style="width: 250px;">
                    <input type="text" name="keyword" class="form-control float-right" placeholder="' . trans($this->plugin->pathPlugin.'::lang.admin.search_place') . '" value="' . $keyword . '">
                    <div class="input-group-append">
                        <button type="submit" class="btn btn-primary"><i class="fas fa-search"></i></button>
                    </div>
                </div>
                </form>';
//=menuSearch

        return view('admin.screen.list')
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
            'url_action' => sc_route('admin_discount.create'),
            'stories' => $this->stories,
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
            'code' => 'required|regex:/(^([0-9A-Za-z\-\._]+)$)/|unique:"'.PluginModel::class.'",code|string|max:50',
            'limit' => 'required|numeric|min:1',
            'reward' => 'required|numeric|min:0',
            'store' => 'required',
            'type' => 'required',
        ], [
            'code.regex' => trans($this->plugin->pathPlugin.'::lang.admin.code_validate'),
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }
        $store = $data['store'] ?? [];
        $dataInsert = [
            'code' => $data['code'],
            'reward' => (int)$data['reward'],
            'limit' => $data['limit'],
            'type' => $data['type'],
            'data' => $data['data'],
            'login' => empty($data['login']) ? 0 : 1,
            'expires_at' => $data['expires_at'],
            'status' => empty($data['status']) ? 0 : 1,
        ];
        $discount = PluginModel::create($dataInsert);
        //Insert store
        if ($store) {
            $discount->stories()->attach($store);
        }
//
        return redirect()->route('admin_discount.index')->with('success', trans($this->plugin->pathPlugin.'::lang.admin.create_success'));

    }

/**
 * Form edit
 */
    public function edit($id)
    {
        $discount = PluginModel::find($id);
        if ($discount === null) {
            return 'no data';
        }

        $data = [
            'title' => trans($this->plugin->pathPlugin.'::lang.admin.edit'),
            'subTitle' => '',
            'title_description' => '',
            'icon' => 'fa fa-pencil-square-o',
            'discount' => $discount,
            'stories' => $this->stories,
            'storiesPivot' => \DB::connection(SC_CONNECTION)->table((new PluginModel)->table_store)->where((new PluginModel)->table.'_id', $id)->pluck('store_id')->all(),
            'url_action' => sc_route('admin_discount.edit', ['id' => $discount['id']]),
        ];
        return view($this->plugin->pathPlugin.'::Admin')
            ->with($data);
    }

/**
 * update status
 */
    public function postEdit($id)
    {
        $discount = PluginModel::find($id);
        $data = request()->all();
        $validator = Validator::make($data, [
            'code' => 'required|regex:/(^([0-9A-Za-z\-\._]+)$)/|unique:"'.PluginModel::class.'",code,' . $discount->id . ',id|string|max:50',
            'limit' => 'required|numeric|min:1',
            'reward' => 'required|numeric|min:0',
            'type' => 'required',
            'store' => 'required',
        ], [
            'code.regex' => trans($this->plugin->pathPlugin.'::lang.admin.code_validate'),
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }
//Edit
        $store = $data['store'] ?? [];
        $dataUpdate = [
            'code' => $data['code'],
            'reward' => (int)$data['reward'],
            'limit' => $data['limit'],
            'type' => $data['type'],
            'data' => $data['data'],
            'login' => empty($data['login']) ? 0 : 1,
            'expires_at' => $data['expires_at'],
            'status' => empty($data['status']) ? 0 : 1,
        ];

        $discount->update($dataUpdate);
        //Update store
        $discount->stories()->detach();
        if (count($store)) {
            $discount->stories()->attach($store);
        }

//
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
            PluginModel::destroy($arrID);
            return 1;
        }
    }

}
