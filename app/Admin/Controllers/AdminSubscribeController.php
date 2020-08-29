<?php
#app/Http/Admin/Controllers/AdminSubscribeController.php
namespace App\Admin\Controllers;

use App\Http\Controllers\Controller;
use App\Models\ShopSubscribe;
use Illuminate\Http\Request;
use Validator;

class AdminSubscribeController extends Controller
{

    /**
     * Index interface.
     *
     * @return Content
     */
    public function index()
    {

        $data = [
            'title' => trans('subscribe.admin.list'),
            'subTitle' => '',
            'icon' => 'fa fa-indent',
            'urlDeleteItem' => sc_route('admin_subscribe.delete'),
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
            'id' => trans('subscribe.id'),
            'email' => trans('subscribe.email'),
            'status' => trans('subscribe.status'),
            'action' => trans('subscribe.admin.action'),
        ];

        $sort_order = request('sort_order') ?? 'id_desc';
        $keyword = request('keyword') ?? '';
        $arrSort = [
            'id__desc' => trans('subscribe.admin.sort_order.id_desc'),
            'id__asc' => trans('subscribe.admin.sort_order.id_asc'),
            'email__desc' => trans('subscribe.admin.sort_order.email_desc'),
            'email__asc' => trans('subscribe.admin.sort_order.email_asc'),
        ];
        $obj = new ShopSubscribe;
        if ($keyword) {
            $obj = $obj->whereRaw('(email like "%' . $keyword . '%" OR id like = "' . $keyword . '" )');
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
                'id' => $row['id'],
                'email' => $row['email'],
                'status' => $row['status'] ? '<span class="badge badge-success">ON</span>' : '<span class="badge badge-danger">OFF</span>',
                'action' => '
                    <a href="' . sc_route('admin_subscribe.edit', ['id' => $row['id']]) . '"><span title="' . trans('subscribe.admin.edit') . '" type="button" class="btn btn-flat btn-primary"><i class="fa fa-edit"></i></span></a>&nbsp;

                  <span onclick="deleteItem(' . $row['id'] . ');"  title="' . trans('subscribe.admin.delete') . '" class="btn btn-flat btn-danger"><i class="fas fa-trash-alt"></i></span>
                  ',
            ];
        }

        $data['listTh'] = $listTh;
        $data['dataTr'] = $dataTr;
        $data['pagination'] = $dataTmp->appends(request()->except(['_token', '_pjax']))->links('admin.component.pagination');
        $data['resultItems'] = trans('subscribe.admin.result_item', ['item_from' => $dataTmp->firstItem(), 'item_to' => $dataTmp->lastItem(), 'item_total' => $dataTmp->total()]);



//menuRight
        $data['menuRight'][] = '<a href="' . sc_route('admin_subscribe.create') . '" class="btn  btn-success  btn-flat" title="New" id="button_create_new">
        <i class="fa fa-plus" title="'.trans('admin.add_new').'"></i>
                           </a>';
//=menuRight

//menuSort        
        $optionSort = '';
        foreach ($arrSort as $key => $status) {
            $optionSort .= '<option  ' . (($sort_order == $key) ? "selected" : "") . ' value="' . $key . '">' . $status . '</option>';
        }

        $data['urlSort'] = sc_route('admin_subscribe.index');
        $data['optionSort'] = $optionSort;
//=menuSort

//menuSearch        
        $data['topMenuRight'][] = '
                <form action="' . sc_route('admin_subscribe.index') . '" id="button_search">
                <div class="input-group input-group" style="width: 250px;">
                    <input type="text" name="keyword" class="form-control float-right" placeholder="' . trans('subscribe.admin.search_place') . '" value="' . $keyword . '">
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
 * Form create new order in admin
 * @return [type] [description]
 */
    public function create()
    {
        $data = [
            'title' => trans('subscribe.admin.add_new_title'),
            'subTitle' => '',
            'title_description' => trans('subscribe.admin.add_new_des'),
            'icon' => 'fa fa-plus',
            'subscribe' => [],
            'url_action' => sc_route('admin_subscribe.create'),
        ];
        return view('admin.screen.subscribe')
            ->with($data);
    }

/**
 * Post create new order in admin
 * @return [type] [description]
 */
    public function postCreate()
    {
        $data = request()->all();
        $dataOrigin = request()->all();
        $validator = Validator::make($dataOrigin, [
            'email' => 'required|email|unique:"'.ShopSubscribe::class.'",email',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        $dataInsert = [
            'email' => $data['email'],
            'status' => (!empty($data['status']) ? 1 : 0),
        ];
        ShopSubscribe::create($dataInsert);

        return redirect()->route('admin_subscribe.index')->with('success', trans('subscribe.admin.create_success'));

    }

/**
 * Form edit
 */
    public function edit($id)
    {
        $subscribe = ShopSubscribe::find($id);
        if ($subscribe === null) {
            return 'no data';
        }
        $data = [
            'title' => trans('subscribe.admin.edit'),
            'subTitle' => '',
            'title_description' => '',
            'icon' => 'fa fa-edit',
            'subscribe' => $subscribe,
            'url_action' => sc_route('admin_subscribe.edit', ['id' => $subscribe['id']]),
        ];
        return view('admin.screen.subscribe')
            ->with($data);
    }

/**
 * update status
 */
    public function postEdit($id)
    {
        $subscribe = ShopSubscribe::find($id);
        $data = request()->all();
        $dataOrigin = request()->all();
        $validator = Validator::make($dataOrigin, [
            'email' => 'required|email|unique:"'.ShopSubscribe::class.'",email,' . $subscribe->id . ',id',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }
//Edit

        $dataUpdate = [
            'email' => $data['email'],
            'status' => (!empty($data['status']) ? 1 : 0),

        ];
        $obj = ShopSubscribe::find($id);
        $obj->update($dataUpdate);

//
        return redirect()->route('admin_subscribe.index')
                ->with('success', trans('subscribe.admin.edit_success'));

    }

/*
Delete list item
Need mothod destroy to boot deleting in model
 */
    public function deleteList()
    {
        if (!request()->ajax()) {
            return response()->json(['error' => 1, 'msg' => 'Method not allow!']);
        } else {
            $ids = request('ids');
            $arrID = explode(',', $ids);
            ShopSubscribe::destroy($arrID);
            return response()->json(['error' => 0, 'msg' => '']);
        }
    }

}
