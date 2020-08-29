<?php
#app/Http/Admin/Controllers/AdminTaxController.php
namespace App\Admin\Controllers;

use App\Http\Controllers\Controller;
use App\Models\ShopTax;
use Validator;

class AdminTaxController extends Controller
{

    public function index()
    {
        $data = [
            'title' => trans('tax.admin.list'),
            'title_action' => '<i class="fa fa-plus" aria-hidden="true"></i> ' . trans('tax.admin.add_new_title'),
            'subTitle' => '',
            'icon' => 'fa fa-indent',
            'urlDeleteItem' => sc_route('admin_tax.delete'),
            'removeList' => 0, // 1 - Enable function delete list item
            'buttonRefresh' => 0, // 1 - Enable button refresh
            'buttonSort' => 0, // 1 - Enable button sort
            'css' => '', 
            'js' => '',
            'url_action' => sc_route('admin_tax.create'),
        ];

        $listTh = [
            'id' => trans('tax.id'),
            'value' => trans('tax.value'),
            'name' => trans('tax.name'),
            'action' => trans('tax.admin.action'),
        ];
        $obj = new ShopTax;
        $obj = $obj->orderBy('id', 'desc');
        $dataTmp = $obj->paginate(20);

        $dataTr = [];
        foreach ($dataTmp as $key => $row) {
            $dataTr[] = [
                'id' => $row['id'],
                'name' => $row['name'],
                'value' => $row['value'],
                'action' => '
                    <a href="' . sc_route('admin_tax.edit', ['id' => $row['id']]) . '"><span title="' . trans('tax.admin.edit') . '" type="button" class="btn btn-flat btn-primary"><i class="fa fa-edit"></i></span></a>&nbsp;
                  <span onclick="deleteItem(' . $row['id'] . ');"  title="' . trans('tax.admin.delete') . '" class="btn btn-flat btn-danger"><i class="fas fa-trash-alt"></i></span>
                  ',
            ];
        }

        $data['listTh'] = $listTh;
        $data['dataTr'] = $dataTr;
        $data['pagination'] = $dataTmp->appends(request()->except(['_token', '_pjax']))->links('admin.component.pagination');
        $data['resultItems'] = trans('tax.admin.result_item', ['item_from' => $dataTmp->firstItem(), 'item_to' => $dataTmp->lastItem(), 'item_total' => $dataTmp->total()]);

        $data['layout'] = 'index';
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
        $obj = ShopTax::create($dataInsert);

        return redirect()->route('admin_tax.edit', ['id' => $obj['id']])->with('success', trans('tax.admin.create_success'));

    }

    /**
     * Form edit
     */
    public function edit($id)
    {
        $tax = ShopTax::find($id);
        if(!$tax) {
            return 'No data';
        }
        $data = [
            'title' => trans('tax.admin.list'),
            'title_action' => '<i class="fa fa-edit" aria-hidden="true"></i> ' . trans('tax.admin.edit'),
            'subTitle' => '',
            'icon' => 'fa fa-indent',
            'urlDeleteItem' => sc_route('admin_tax.delete'),
            'removeList' => 0, // 1 - Enable function delete list item
            'buttonRefresh' => 0, // 1 - Enable button refresh
            'buttonSort' => 0, // 1 - Enable button sort
            'css' => '', 
            'js' => '',
            'url_action' => sc_route('admin_tax.edit', ['id' => $tax['id']]),
            'tax' => $tax,
            'id' => $id,
        ];

        $listTh = [
            'id' => trans('tax.id'),
            'name' => trans('tax.name'),
            'value' => trans('tax.value'),
            'action' => trans('tax.admin.action'),
        ];
        $obj = new ShopTax;
        $obj = $obj->orderBy('id', 'desc');
        $dataTmp = $obj->paginate(20);

        $dataTr = [];
        foreach ($dataTmp as $key => $row) {
            $dataTr[] = [
                'id' => $row['id'],
                'name' => $row['name'],
                'value' => $row['value'],
                'action' => '
                    <a href="' . sc_route('admin_tax.edit', ['id' => $row['id']]) . '"><span title="' . trans('tax.admin.edit') . '" type="button" class="btn btn-flat btn-primary"><i class="fa fa-edit"></i></span></a>&nbsp;
                <span onclick="deleteItem(' . $row['id'] . ');"  title="' . trans('tax.admin.delete') . '" class="btn btn-flat btn-danger"><i class="fas fa-trash-alt"></i></span>
                ',
            ];
        }

        $data['listTh'] = $listTh;
        $data['dataTr'] = $dataTr;
        $data['pagination'] = $dataTmp->appends(request()->except(['_token', '_pjax']))->links('admin.component.pagination');
        $data['resultItems'] = trans('tax.admin.result_item', ['item_from' => $dataTmp->firstItem(), 'item_to' => $dataTmp->lastItem(), 'item_total' => $dataTmp->total()]);

        $data['layout'] = 'edit';
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
        return redirect()->back()->with('success', trans('tax.admin.edit_success'));

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
