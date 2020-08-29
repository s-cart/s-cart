<?php
#app/Http/Admin/Controllers/AdminSupplierController.php
namespace App\Admin\Controllers;

use App\Http\Controllers\Controller;
use App\Models\ShopSupplier;
use Illuminate\Http\Request;
use Validator;

class AdminSupplierController extends Controller
{

    public function index()
    {
        $data = [
            'title' => trans('supplier.admin.list'),
            'title_action' => '<i class="fa fa-plus" aria-hidden="true"></i> ' . trans('supplier.admin.add_new_title'),
            'subTitle' => '',
            'icon' => 'fa fa-indent',
            'urlDeleteItem' => sc_route('admin_supplier.delete'),
            'removeList' => 0, // 1 - Enable function delete list item
            'buttonRefresh' => 0, // 1 - Enable button refresh
            'buttonSort' => 0, // 1 - Enable button sort
            'css' => '', 
            'js' => '',
            'url_action' => sc_route('admin_supplier.create'),
        ];

        $listTh = [
            'id' => trans('supplier.id'),
            'name' => trans('supplier.name'),
            'image' => trans('supplier.image'),
            'email' => trans('supplier.email'),
            'sort' => trans('supplier.sort'),
            'action' => trans('supplier.admin.action'),
        ];
        $obj = new ShopSupplier;
        $obj = $obj->orderBy('id', 'desc');
        $dataTmp = $obj->paginate(20);

        $dataTr = [];
        foreach ($dataTmp as $key => $row) {
            $dataTr[] = [
                'id' => $row['id'],
                'name' => $row['name'],
                'image' => sc_image_render($row->getThumb(), '50px', '50px', $row['name']),
                'email' => $row['email'],
                'sort' => $row['sort'],
                'action' => '
                    <a href="' . sc_route('admin_supplier.edit', ['id' => $row['id']]) . '"><span title="' . trans('supplier.admin.edit') . '" type="button" class="btn btn-flat btn-primary"><i class="fa fa-edit"></i></span></a>&nbsp;

                  <span onclick="deleteItem(' . $row['id'] . ');"  title="' . trans('supplier.admin.delete') . '" class="btn btn-flat btn-danger"><i class="fas fa-trash-alt"></i></span>
                  ',
            ];
        }

        $data['listTh'] = $listTh;
        $data['dataTr'] = $dataTr;
        $data['pagination'] = $dataTmp->appends(request()->except(['_token', '_pjax']))->links('admin.component.pagination');
        $data['resultItems'] = trans('supplier.admin.result_item', ['item_from' => $dataTmp->firstItem(), 'item_to' => $dataTmp->lastItem(), 'item_total' => $dataTmp->total()]);

        $data['layout'] = 'index';
        return view('admin.screen.supplier')
            ->with($data);
    }

/**
 * Post create new order in admin
 * @return [type] [description]
 */
    public function postCreate()
    {
        $data = request()->all();

        $data['alias'] = !empty($data['alias'])?$data['alias']:$data['name'];
        $data['alias'] = sc_word_format_url($data['alias']);
        $data['alias'] = sc_word_limit($data['alias'], 100);

        $validator = Validator::make($data, [
            'image' => 'required',
            'sort' => 'numeric|min:0',
            'name' => 'required|string|max:100',
            'alias' => 'required|regex:/(^([0-9A-Za-z\-_]+)$)/|unique:"'.ShopSupplier::class.'",alias|string|max:100',
            'url' => 'url|nullable',
            'email' => 'email|nullable',
        ],[
            'name.required' => trans('validation.required', ['attribute' => trans('supplier.name')]),
            'alias.regex' => trans('supplier.alias_validate'),
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput($data);
        }

        $dataInsert = [
            'image' => $data['image'],
            'name' => $data['name'],
            'alias' => $data['alias'],
            'url' => $data['url'],
            'email' => $data['email'],
            'address' => $data['address'],
            'phone' => $data['phone'],
            'sort' => (int) $data['sort'],
        ];
        $obj = ShopSupplier::create($dataInsert);

        return redirect()->route('admin_supplier.index', ['id' => $obj['id']])->with('success', trans('supplier.admin.create_success'));

    }

/**
 * Form edit
 */
public function edit($id)
{
    $supplier = ShopSupplier::find($id);
    if(!$supplier) {
        return 'No data';
    }
    $data = [
        'title' => trans('supplier.admin.list'),
        'title_action' => '<i class="fa fa-edit" aria-hidden="true"></i> ' . trans('supplier.admin.edit'),
        'subTitle' => '',
        'icon' => 'fa fa-indent',
        'urlDeleteItem' => sc_route('admin_supplier.delete'),
        'removeList' => 0, // 1 - Enable function delete list item
        'buttonRefresh' => 0, // 1 - Enable button refresh
        'buttonSort' => 0, // 1 - Enable button sort
        'css' => '', 
        'js' => '',
        'url_action' => sc_route('admin_supplier.edit', ['id' => $supplier['id']]),
        'supplier' => $supplier,
        'id' => $id,
    ];

    $listTh = [
        'id' => trans('supplier.id'),
        'name' => trans('supplier.name'),
        'image' => trans('supplier.image'),
        'email' => trans('supplier.email'),
        'sort' => trans('supplier.sort'),
        'action' => trans('supplier.admin.action'),
    ];

    $obj = new ShopSupplier;
    $obj = $obj->orderBy('id', 'desc');
    $dataTmp = $obj->paginate(20);

    $dataTr = [];
    foreach ($dataTmp as $key => $row) {
        $dataTr[] = [
            'id' => $row['id'],
            'name' => $row['name'],
            'image' => sc_image_render($row->getThumb(), '50px', '50px', $row['name']),
            'email' => $row['email'],
            'sort' => $row['sort'],
            'action' => '
                <a href="' . sc_route('admin_supplier.edit', ['id' => $row['id']]) . '"><span title="' . trans('supplier.admin.edit') . '" type="button" class="btn btn-flat btn-primary"><i class="fa fa-edit"></i></span></a>&nbsp;

                <span onclick="deleteItem(' . $row['id'] . ');"  title="' . trans('supplier.admin.delete') . '" class="btn btn-flat btn-danger"><i class="fas fa-trash-alt"></i></span>
                ',
        ];
    }

    $data['listTh'] = $listTh;
    $data['dataTr'] = $dataTr;
    $data['pagination'] = $dataTmp->appends(request()->except(['_token', '_pjax']))->links('admin.component.pagination');
    $data['resultItems'] = trans('supplier.admin.result_item', ['item_from' => $dataTmp->firstItem(), 'item_to' => $dataTmp->lastItem(), 'item_total' => $dataTmp->total()]);

    $data['layout'] = 'edit';
    return view('admin.screen.supplier')
        ->with($data);
}

/**
 * update status
 */
    public function postEdit($id)
    {
        $supplier = ShopSupplier::find($id);
        $data = request()->all();

        $data['alias'] = !empty($data['alias'])?$data['alias']:$data['name'];
        $data['alias'] = sc_word_format_url($data['alias']);
        $data['alias'] = sc_word_limit($data['alias'], 100);

        $validator = Validator::make($data, [
            'image' => 'required',
            'sort' => 'numeric|min:0',
            'name' => 'required|string|max:100',
            'alias' => 'required|regex:/(^([0-9A-Za-z\-_]+)$)/|unique:"'.ShopSupplier::class.'",alias,' . $supplier->id . ',id|string|max:100',
            'url' => 'url|nullable',
            'email' => 'email|nullable',
        ],[
            'name.required' => trans('validation.required', ['attribute' => trans('supplier.name')]),
            'alias.regex' => trans('supplier.alias_validate'),
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput($data);
        }
//Edit

        $dataUpdate = [
            'image' => $data['image'],
            'name' => $data['name'],
            'alias' => $data['alias'],
            'email' => $data['email'],
            'phone' => $data['phone'],
            'url' => $data['url'],
            'address' => $data['address'],
            'sort' => (int) $data['sort'],

        ];
        
        $supplier->update($dataUpdate);

//
        return redirect()->back()->with('success', trans('supplier.admin.edit_success'));

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
            ShopSupplier::destroy($arrID);
            return response()->json(['error' => 0, 'msg' => '']);
        }
    }

}
