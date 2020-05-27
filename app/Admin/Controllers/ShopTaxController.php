<?php
#app/Http/Admin/Controllers/ShopTaxController.php
namespace App\Admin\Controllers;

use App\Http\Controllers\Controller;
use App\Models\ShopTax;
use Validator;

class ShopTaxController extends Controller
{

    public function index()
    {

        $data = [
            'title' => trans('tax.admin.list'),
            'subTitle' => '',
            'icon' => 'fa fa-indent',
            'urlDeleteItem' => route('admin_tax.delete'),
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
            'id' => trans('tax.id'),
            'name' => trans('tax.name'),
            'value' => trans('tax.value'),
        ];

        $sort_order = request('sort_order') ?? 'id_desc';
        $keyword = request('keyword') ?? '';
        $arrSort = [
            'id__desc' => trans('tax.admin.sort_order.id_desc'),
            'id__asc' => trans('tax.admin.sort_order.id_asc'),
            'name__desc' => trans('tax.admin.sort_order.name_desc'),
            'name__asc' => trans('tax.admin.sort_order.name_asc'),
        ];
        $obj = new ShopTax;

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
            $dataMap = [
                'id' => $row['id'],
                'name' => $row['name'],
                'value' => $row['value']
            ];
            if($row['id'] == sc_config('SITE_TAX')){
                $dataMap['action'] = '<a href="' . route('admin_tax.edit', ['id' => $row['id']]) . '"><span title="' . trans('tax.admin.edit') . '" type="button" class="btn btn-flat btn-primary"><i class="fa fa-edit"></i></span></a>&nbsp;
                <span class="btn btn-default">'.trans('tax.admin.default').'</span>';
            } else{
                $dataMap['action'] = '<a href="' . route('admin_tax.edit', ['id' => $row['id']]) . '"><span title="' . trans('tax.admin.edit') . '" type="button" class="btn btn-flat btn-primary"><i class="fa fa-edit"></i></span></a>&nbsp;
                <span onclick="deleteItem(' . $row['id'] . ');"  title="' . trans('tax.admin.delete') . '" class="btn btn-flat btn-danger"><i class="fa fa-trash"></i></span>
                ';
            }
            $dataTr[] = $dataMap;
        }

        $data['listTh'] = $listTh;
        $data['dataTr'] = $dataTr;
        $data['pagination'] = $dataTmp->appends(request()->except(['_token', '_pjax']))->links('admin.component.pagination');
        $data['resultItems'] = trans('tax.admin.result_item', ['item_from' => $dataTmp->firstItem(), 'item_to' => $dataTmp->lastItem(), 'item_total' => $dataTmp->total()]);

//menuRight
        $data['menuRight'][] = '<a href="' . route('admin_tax.create') . '" class="btn  btn-success  btn-flat" title="New" id="button_create_new">
        <i class="fa fa-plus" title="'.trans('admin.add_new').'"></i>
                           </a>';
//=menuRight

//menuSort        
        $optionSort = '';
        foreach ($arrSort as $key => $status) {
            $optionSort .= '<option  ' . (($sort_order == $key) ? "selected" : "") . ' value="' . $key . '">' . $status . '</option>';
        }

        $data['urlSort'] = route('admin_tax.index');
        $data['optionSort'] = $optionSort;
//=menuSort

//menuSearch        
            $data['topMenuRight'][] = '
                <form action="' . route('admin_tax.index') . '" id="button_search">
                   <div onclick="$(this).submit();" class="btn-group pull-right">
                           <a class="btn btn-flat btn-primary" title="Refresh">
                              <i class="fa  fa-search"></i>
                           </a>
                   </div>
                   <div class="btn-group pull-right">
                         <div class="form-group">
                           <input type="text" name="keyword" class="form-control" placeholder="' . trans('tax.admin.search_place') . '" value="' . $keyword . '">
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
            'title' => trans('tax.admin.add_new_title'),
            'subTitle' => '',
            'title_description' => trans('tax.admin.add_new_des'),
            'icon' => 'fa fa-plus',
            'tax' => [],
            'url_action' => route('admin_tax.create'),
        ];
        return view('admin.screen.tax')
            ->with($data);
    }

/**
 * Post create new order in admin
 * @return [type] [description]
 */
    public function postCreate()
    {
        $data = request()->all();

        $validator = Validator::make($data, [
            'name' => 'required',
            'value' => 'numeric|min:0',
        ],[
            'name.required' => trans('validation.required', ['attribute' => trans('tax.name')]),
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput($data);
        }

        $dataInsert = [
            'value' => (int)$data['value'],
            'name' => $data['name'],
        ];
        ShopTax::create($dataInsert);

        return redirect()->route('admin_tax.index')->with('success', trans('tax.admin.create_success'));

    }

/**
 * Form edit
 */
    public function edit($id)
    {
        $tax = ShopTax::find($id);
        if ($tax === null) {
            return 'no data';
        }
        $data = [
            'title' => trans('tax.admin.edit'),
            'subTitle' => '',
            'title_description' => '',
            'icon' => 'fa fa-pencil-square-o',
            'tax' => $tax,
            'url_action' => route('admin_tax.edit', ['id' => $tax['id']]),
        ];
        return view('admin.screen.tax')
            ->with($data);
    }

/**
 * update status
 */
    public function postEdit($id)
    {
        $tax = ShopTax::find($id);
        $data = request()->all();
        $validator = Validator::make($data, [
            'name' => 'required',
            'value' => 'numeric|min:0',
        ],[
            'name.required' => trans('validation.required', ['attribute' => trans('tax.name')]),
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput($data);
        }
//Edit

        $dataUpdate = [
            'value' => (int)$data['value'],
            'name' => $data['name'],
        ];
        
        $tax->update($dataUpdate);

//
        return redirect()->route('admin_tax.index')->with('success', trans('tax.admin.edit_success'));

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
            ShopTax::destroy($arrID);
            return response()->json(['error' => 0, 'msg' => '']);
        }
    }

}
