<?php
#app/Http/Admin/Controllers/ShopWeightController.php
namespace App\Admin\Controllers;

use App\Http\Controllers\Controller;
use App\Models\ShopWeight;
use Illuminate\Http\Request;
use Validator;

class ShopWeightController extends Controller
{

    /**
     * Index interface.
     *
     * @return Content
     */
    public function index()
    {

        $data = [
            'title' => trans('weight.admin.list'),
            'subTitle' => '',
            'icon' => 'fa fa-indent',
            'urlDeleteItem' => route('admin_weight_unit.delete'),
            'removeList' => 0, // 1 - Enable function delete list item
            'buttonRefresh' => 0, // 1 - Enable button refresh
            'buttonSort' => 0, // 1 - Enable button sort
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
            'id' => trans('weight.id'),
            'name' => trans('weight.name'),
            'description' => trans('weight.description'),
            'action' => trans('weight.admin.action'),
        ];
        $obj = new ShopWeight;
        $obj = $obj->orderBy('id', 'desc');
        $dataTmp = $obj->paginate(20);

        $dataTr = [];
        foreach ($dataTmp as $key => $row) {
            $dataTr[] = [
                'id' => $row['id'],
                'name' => $row['name'],
                'description' => $row['description'],
                'action' => '
                    <a href="' . route('admin_weight_unit.edit', ['id' => $row['id']]) . '"><span title="' . trans('weight.admin.edit') . '" type="button" class="btn btn-flat btn-primary"><i class="fa fa-edit"></i></span></a>&nbsp;

                  <span onclick="deleteItem(' . $row['id'] . ');"  title="' . trans('weight.admin.delete') . '" class="btn btn-flat btn-danger"><i class="fa fa-trash"></i></span>
                  ',
            ];
        }

        $data['listTh'] = $listTh;
        $data['dataTr'] = $dataTr;
        $data['pagination'] = $dataTmp->appends(request()->except(['_token', '_pjax']))->links('admin.component.pagination');
        $data['resultItems'] = trans('weight.admin.result_item', ['item_from' => $dataTmp->firstItem(), 'item_to' => $dataTmp->lastItem(), 'item_total' => $dataTmp->total()]);

//menuRight
        $data['menuRight'][] = '<a href="' . route('admin_weight_unit.create') . '" class="btn  btn-success  btn-flat" title="New" id="button_create_new">
        <i class="fa fa-plus" title="'.trans('admin.add_new').'"></i>
        </a>';
//=menuRight

        return view('admin.screen.list')
            ->with($data);
    }

/**
 * Form create new order in admin
 * @return [type] [description]
 */
    public function create()
    {
        $obj = [];
        $data = [
            'title' => trans('weight.admin.add_new_title'),
            'subTitle' => '',
            'title_description' => trans('weight.admin.add_new_des'),
            'icon' => 'fa fa-plus',
            'obj' => $obj,
            'url_action' => route('admin_weight_unit.create'),
        ];
        return view('admin.screen.weight')
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
            'name' => 'required|unique:"'.ShopWeight::class.'",name',
            'description' => 'required',
        ], [
            'name.required' => trans('validation.required'),
        ]);

        if ($validator->fails()) {
            // dd($validator->messages());
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }
//Create new order
        $dataInsert = [
            'name' => $data['name'],
            'description' => $data['description'],
        ];
        ShopWeight::create($dataInsert);
//
        return redirect()->route('admin_weight_unit.index')->with('success', trans('weight.admin.create_success'));

    }

/**
 * Form edit
 */
    public function edit($id)
    {
        $obj = ShopWeight::find($id);
        if ($obj === null) {
            return 'no data';
        }
        $data = [
            'title' => trans('weight.admin.edit'),
            'subTitle' => '',
            'title_description' => '',
            'icon' => 'fa fa-pencil-square-o',
            'obj' => $obj,
            'url_action' => route('admin_weight_unit.edit', ['id' => $obj['id']]),
        ];
        return view('admin.screen.weight')
            ->with($data);
    }

/**
 * update status
 */
    public function postEdit($id)
    {
        $data = request()->all();
        $dataOrigin = request()->all();
        $obj = ShopWeight::find($id);
        $validator = Validator::make($dataOrigin, [
            'name' => 'required|unique:"'.ShopWeight::class.'",name,' . $obj->id . ',id',
            'description' => 'required',
        ], [
            'name.required' => trans('validation.required'),
        ]);

        if ($validator->fails()) {
            // dd($validator->messages());
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }
//Edit
        $dataUpdate = [
            'name' => $data['name'],
            'description' => $data['description'],
        ];
        $obj->update($dataUpdate);

//
        return redirect()->route('admin_weight_unit.index')->with('success', trans('weight.admin.edit_success'));

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
            ShopWeight::destroy($arrID);
            return response()->json(['error' => 0, 'msg' => '']);
        }
    }

}
