<?php
#app/Http/Admin/Controllers/AdminAttributeGroupController.php
namespace App\Admin\Controllers;

use App\Http\Controllers\Controller;
use App\Models\ShopAttributeGroup;
use Illuminate\Http\Request;
use Validator;

class AdminAttributeGroupController extends Controller
{

    /**
     * Index interface.
     *
     * @return Content
     */
    public function index()
    {
        $data = [
            'title' => trans('attribute_group.admin.list'),
            'title_action' => '<i class="fa fa-plus" aria-hidden="true"></i> ' . trans('attribute_group.admin.add_new_title'),
            'subTitle' => '',
            'icon' => 'fa fa-indent',
            'urlDeleteItem' => sc_route('admin_attribute_group.delete'),
            'removeList' => 0, // 1 - Enable function delete list item
            'buttonRefresh' => 0, // 1 - Enable button refresh
            'buttonSort' => 0, // 1 - Enable button sort
            'css' => '', 
            'js' => '',
            'url_action' => sc_route('admin_attribute_group.create'),
        ];

        $listTh = [
            'id' => trans('attribute_group.id'),
            'name' => trans('attribute_group.name'),
            'type' => trans('attribute_group.type'),
            'action' => trans('attribute_group.admin.action'),
        ];
        $obj = new ShopAttributeGroup;
        $obj = $obj->orderBy('id', 'desc');
        $dataTmp = $obj->paginate(20);

        $dataTr = [];
        foreach ($dataTmp as $key => $row) {
            $dataTr[] = [
                'id' => $row['id'],
                'name' => $row['name'],
                'type' => $row['type'],
                'action' => '
                    <a href="' . sc_route('admin_attribute_group.edit', ['id' => $row['id']]) . '"><span title="' . trans('attribute_group.admin.edit') . '" type="button" class="btn btn-flat btn-primary"><i class="fa fa-edit"></i></span></a>&nbsp;

                  <span onclick="deleteItem(' . $row['id'] . ');"  title="' . trans('attribute_group.admin.delete') . '" class="btn btn-flat btn-danger"><i class="fas fa-trash-alt"></i></span>
                  ',
            ];
        }

        $data['listTh'] = $listTh;
        $data['dataTr'] = $dataTr;
        $data['pagination'] = $dataTmp->appends(request()->except(['_token', '_pjax']))->links('admin.component.pagination');
        $data['resultItems'] = trans('attribute_group.admin.result_item', ['item_from' => $dataTmp->firstItem(), 'item_to' => $dataTmp->lastItem(), 'item_total' => $dataTmp->total()]);

        $data['layout'] = 'index';
        return view('admin.screen.attribute_group')
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
            'name' => 'required',
            'type' => 'required',
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
            'type' => $data['type'],
        ];
        $obj = ShopAttributeGroup::create($dataInsert);
//
        return redirect()->route('admin_attribute_group.edit', ['id' => $obj['id']])->with('success', trans('attribute_group.admin.create_success'));

    }

/**
 * Form edit
 */

public function edit($id)
{
    $attribute_group = ShopAttributeGroup::find($id);
    if(!$attribute_group) {
        return 'No data';
    }
    $data = [
        'title' => trans('attribute_group.admin.list'),
        'title_action' => '<i class="fa fa-edit" aria-hidden="true"></i> ' . trans('attribute_group.admin.edit'),
        'subTitle' => '',
        'icon' => 'fa fa-indent',
        'urlDeleteItem' => sc_route('admin_attribute_group.delete'),
        'removeList' => 0, // 1 - Enable function delete list item
        'buttonRefresh' => 0, // 1 - Enable button refresh
        'buttonSort' => 0, // 1 - Enable button sort
        'css' => '', 
        'js' => '',
        'url_action' => sc_route('admin_attribute_group.edit', ['id' => $attribute_group['id']]),
        'attribute_group' => $attribute_group,
        'id' => $id,
    ];

    $listTh = [
        'id' => trans('attribute_group.id'),
        'name' => trans('attribute_group.name'),
        'type' => trans('attribute_group.type'),
        'action' => trans('attribute_group.admin.action'),
    ];
    $obj = new ShopAttributeGroup;
    $obj = $obj->orderBy('id', 'desc');
    $dataTmp = $obj->paginate(20);


    $dataTr = [];
    foreach ($dataTmp as $key => $row) {
        $dataTr[] = [
            'id' => $row['id'],
            'name' => $row['name'],
            'type' => $row['type'],
            'action' => '
                <a href="' . sc_route('admin_attribute_group.edit', ['id' => $row['id']]) . '"><span title="' . trans('attribute_group.admin.edit') . '" type="button" class="btn btn-flat btn-primary"><i class="fa fa-edit"></i></span></a>&nbsp;

              <span onclick="deleteItem(' . $row['id'] . ');"  title="' . trans('attribute_group.admin.delete') . '" class="btn btn-flat btn-danger"><i class="fas fa-trash-alt"></i></span>
              ',
        ];
    }

    $data['listTh'] = $listTh;
    $data['dataTr'] = $dataTr;
    $data['pagination'] = $dataTmp->appends(request()->except(['_token', '_pjax']))->links('admin.component.pagination');
    $data['resultItems'] = trans('attribute_group.admin.result_item', ['item_from' => $dataTmp->firstItem(), 'item_to' => $dataTmp->lastItem(), 'item_total' => $dataTmp->total()]);

    $data['layout'] = 'edit';
    return view('admin.screen.attribute_group')
        ->with($data);
}


/**
 * update status
 */
    public function postEdit($id)
    {
        $data = request()->all();
        $dataOrigin = request()->all();
        $validator = Validator::make($dataOrigin, [
            'name' => 'required',
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
            'type' => $data['type'],
        ];
        $obj = ShopAttributeGroup::find($id);
        $obj->update($dataUpdate);
//
        return redirect()->back()->with('success', trans('attribute_group.admin.edit_success'));

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
            ShopAttributeGroup::destroy($arrID);
            return response()->json(['error' => 0, 'msg' => '']);
        }
    }

}
