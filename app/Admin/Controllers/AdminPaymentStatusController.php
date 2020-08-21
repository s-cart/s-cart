<?php
#app/Http/Admin/Controllers/AdminPaymentStatusController.php
namespace App\Admin\Controllers;

use App\Http\Controllers\Controller;
use App\Models\ShopPaymentStatus;
use Illuminate\Http\Request;
use Validator;

class AdminPaymentStatusController extends Controller
{

    /**
     * Index interface.
     *
     * @return Content
     */
    public function index()
    {
        $data = [
            'title' => trans('payment_status.admin.list'),
            'title_action' => '<i class="fa fa-plus" aria-hidden="true"></i> ' . trans('payment_status.admin.add_new_title'),
            'subTitle' => '',
            'icon' => 'fa fa-indent',
            'urlDeleteItem' => sc_route('admin_payment_status.delete'),
            'removeList' => 0, // 1 - Enable function delete list item
            'buttonRefresh' => 0, // 1 - Enable button refresh
            'buttonSort' => 0, // 1 - Enable button sort
            'css' => '', 
            'js' => '',
            'url_action' => sc_route('admin_payment_status.create'),
        ];

        $listTh = [
            'id' => trans('payment_status.admin.id'),
            'name' => trans('payment_status.admin.name'),
            'action' => trans('payment_status.admin.action'),
        ];
        $obj = new ShopPaymentStatus;
        $obj = $obj->orderBy('id', 'desc');
        $dataTmp = $obj->paginate(20);

        $dataTr = [];
        foreach ($dataTmp as $key => $row) {
            $dataTr[] = [
                'id' => $row['id'],
                'name' => $row['name'] ?? 'N/A',
                'action' => '
                    <a href="' . sc_route('admin_payment_status.edit', ['id' => $row['id']]) . '"><span title="' . trans('payment_status.admin.edit') . '" type="button" class="btn btn-flat btn-primary"><i class="fa fa-edit"></i></span></a>&nbsp;

                  <span onclick="deleteItem(' . $row['id'] . ');"  title="' . trans('payment_status.admin.delete') . '" class="btn btn-flat btn-danger"><i class="fas fa-trash-alt"></i></span>
                  ',
            ];
        }

        $data['listTh'] = $listTh;
        $data['dataTr'] = $dataTr;
        $data['pagination'] = $dataTmp->appends(request()->except(['_token', '_pjax']))->links('admin.component.pagination');
        $data['resultItems'] = trans('payment_status.admin.result_item', ['item_from' => $dataTmp->firstItem(), 'item_to' => $dataTmp->lastItem(), 'item_total' => $dataTmp->total()]);

        $data['layout'] = 'index';
        return view('admin.screen.payment_status')
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
        ], [
            'name.required' => trans('validation.required'),
        ]);

        if ($validator->fails()) {
            // dd($validator->messages());
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }
        $dataInsert = [
            'name' => $data['name'],
        ];
        $obj = ShopPaymentStatus::create($dataInsert);
//
        return redirect()->route('admin_payment_status.edit', ['id' => $obj['id']])->with('success', trans('payment_status.admin.create_success'));

    }

/**
 * Form edit
 */
public function edit($id)
{
    $payment_status = ShopPaymentStatus::find($id);
    if(!$payment_status) {
        return 'No data';
    }
    $data = [
        'title' => trans('payment_status.admin.list'),
        'title_action' => '<i class="fa fa-edit" aria-hidden="true"></i> ' . trans('payment_status.admin.edit'),
        'subTitle' => '',
        'icon' => 'fa fa-indent',
        'urlDeleteItem' => sc_route('admin_payment_status.delete'),
        'removeList' => 0, // 1 - Enable function delete list item
        'buttonRefresh' => 0, // 1 - Enable button refresh
        'buttonSort' => 0, // 1 - Enable button sort
        'css' => '', 
        'js' => '',
        'url_action' => sc_route('admin_payment_status.edit', ['id' => $payment_status['id']]),
        'payment_status' => $payment_status,
        'id' => $id,
    ];

    $listTh = [
        'id' => trans('payment_status.admin.id'),
        'name' => trans('payment_status.admin.name'),
        'action' => trans('payment_status.admin.action'),
    ];
    $obj = new ShopPaymentStatus;
    $obj = $obj->orderBy('id', 'desc');
    $dataTmp = $obj->paginate(20);

    $dataTr = [];
    foreach ($dataTmp as $key => $row) {
        $dataTr[] = [
            'id' => $row['id'],
            'name' => $row['name'] ?? 'N/A',
            'action' => '
                <a href="' . sc_route('admin_payment_status.edit', ['id' => $row['id']]) . '"><span title="' . trans('payment_status.admin.edit') . '" type="button" class="btn btn-flat btn-primary"><i class="fa fa-edit"></i></span></a>&nbsp;

              <span onclick="deleteItem(' . $row['id'] . ');"  title="' . trans('payment_status.admin.delete') . '" class="btn btn-flat btn-danger"><i class="fas fa-trash-alt"></i></span>
              ',
        ];
    }

    $data['listTh'] = $listTh;
    $data['dataTr'] = $dataTr;
    $data['pagination'] = $dataTmp->appends(request()->except(['_token', '_pjax']))->links('admin.component.pagination');
    $data['resultItems'] = trans('payment_status.admin.result_item', ['item_from' => $dataTmp->firstItem(), 'item_to' => $dataTmp->lastItem(), 'item_total' => $dataTmp->total()]);

    $data['layout'] = 'edit';
    return view('admin.screen.payment_status')
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
        ];
        $obj = ShopPaymentStatus::find($id);
        $obj->update($dataUpdate);
//
        return redirect()->back()->with('success', trans('payment_status.admin.edit_success'));

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
            ShopPaymentStatus::destroy($arrID);
            return response()->json(['error' => 0, 'msg' => '']);
        }
    }

}
