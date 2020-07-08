<?php
#app/Http/Admin/Controllers/ShopSupplierController.php
namespace App\Admin\Controllers;

use App\Http\Controllers\Controller;
use App\Models\ShopSupplier;
use Illuminate\Http\Request;
use Validator;

class ShopSupplierController extends Controller
{

    public function index()
    {

        $data = [
            'title' => trans('supplier.admin.list'),
            'subTitle' => '',
            'icon' => 'fa fa-indent',
            'urlDeleteItem' => route('admin_supplier.delete'),
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
            'id' => trans('supplier.id'),
            'name' => trans('supplier.name'),
            'image' => trans('supplier.image'),
            'email' => trans('supplier.email'),
            'phone' => trans('supplier.phone'),
            'url' => trans('supplier.url'),
            'address' => trans('supplier.address'),
            'sort' => trans('supplier.sort'),
            'action' => trans('supplier.admin.action'),
        ];

        $sort_order = request('sort_order') ?? 'id_desc';
        $keyword = request('keyword') ?? '';
        $arrSort = [
            'id__desc' => trans('supplier.admin.sort_order.id_desc'),
            'id__asc' => trans('supplier.admin.sort_order.id_asc'),
            'name__desc' => trans('supplier.admin.sort_order.name_desc'),
            'name__asc' => trans('supplier.admin.sort_order.name_asc'),
            'email__desc' => trans('supplier.admin.sort_order.email_desc'),
            'email__asc' => trans('supplier.admin.sort_order.email_asc'),
        ];
        $obj = new ShopSupplier;
        if ($keyword) {
            $obj = $obj->whereRaw('(email like "%' . $keyword . '%" OR name like "%' . $keyword . '%" )');
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
                'name' => $row['name'],
                'image' => sc_image_render($row->getThumb(), '50px', '50px', $row['name']),
                'email' => $row['email'],
                'phone' => $row['phone'],
                'url' => $row['url'],
                'address' => $row['address'],
                'sort' => $row['sort'],
                'action' => '
                    <a href="' . route('admin_supplier.edit', ['id' => $row['id']]) . '"><span title="' . trans('supplier.admin.edit') . '" type="button" class="btn btn-flat btn-primary"><i class="fa fa-edit"></i></span></a>&nbsp;

                  <span onclick="deleteItem(' . $row['id'] . ');"  title="' . trans('supplier.admin.delete') . '" class="btn btn-flat btn-danger"><i class="fa fa-trash"></i></span>
                  ',
            ];
        }

        $data['listTh'] = $listTh;
        $data['dataTr'] = $dataTr;
        $data['pagination'] = $dataTmp->appends(request()->except(['_token', '_pjax']))->links('admin.component.pagination');
        $data['resultItems'] = trans('supplier.admin.result_item', ['item_from' => $dataTmp->firstItem(), 'item_to' => $dataTmp->lastItem(), 'item_total' => $dataTmp->total()]);

//menuRight
        $data['menuRight'][] = '<a href="' . route('admin_supplier.create') . '" class="btn  btn-success  btn-flat" title="New" id="button_create_new">
        <i class="fa fa-plus" title="'.trans('admin.add_new').'"></i>
                           </a>';
//=menuRight

//menuSort        
        $optionSort = '';
        foreach ($arrSort as $key => $status) {
            $optionSort .= '<option  ' . (($sort_order == $key) ? "selected" : "") . ' value="' . $key . '">' . $status . '</option>';
        }

        $data['urlSort'] = route('admin_supplier.index');
        $data['optionSort'] = $optionSort;
//=menuSort

//menuSearch        
            $data['topMenuRight'][] = '
                <form action="' . route('admin_supplier.index') . '" id="button_search">
                   <div onclick="$(this).submit();" class="btn-group pull-right">
                           <a class="btn btn-flat btn-primary" title="Refresh">
                              <i class="fa  fa-search"></i>
                           </a>
                   </div>
                   <div class="btn-group pull-right">
                         <div class="form-group">
                           <input type="text" name="keyword" class="form-control" placeholder="' . trans('supplier.admin.search_place') . '" value="' . $keyword . '">
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
            'title' => trans('supplier.admin.add_new_title'),
            'subTitle' => '',
            'title_description' => trans('supplier.admin.add_new_des'),
            'icon' => 'fa fa-plus',
            'supplier' => [],
            'url_action' => route('admin_supplier.create'),
        ];
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
        ShopSupplier::create($dataInsert);

        return redirect()->route('admin_supplier.index')->with('success', trans('supplier.admin.create_success'));

    }

/**
 * Form edit
 */
    public function edit($id)
    {
        $supplier = ShopSupplier::find($id);
        if ($supplier === null) {
            return 'no data';
        }
        $data = [
            'title' => trans('supplier.admin.edit'),
            'subTitle' => '',
            'title_description' => '',
            'icon' => 'fa fa-pencil-square-o',
            'supplier' => $supplier,
            'url_action' => route('admin_supplier.edit', ['id' => $supplier['id']]),
        ];
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
        return redirect()->route('admin_supplier.index')->with('success', trans('supplier.admin.edit_success'));

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
