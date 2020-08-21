<?php
#app/Http/Admin/Controllers/AdminEmailTemplateController.php
namespace App\Admin\Controllers;

use App\Http\Controllers\Controller;
use App\Models\ShopEmailTemplate;
use Illuminate\Http\Request;
use Validator;

class AdminEmailTemplateController extends Controller
{
    public function index()
    {

        $data = [
            'title' => trans('email_template.admin.list'),
            'subTitle' => '',
            'icon' => 'fa fa-indent',
            'urlDeleteItem' => sc_route('admin_email_template.delete'),
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
            'id' => trans('email_template.id'),
            'name' => trans('email_template.name'),
            'group' => trans('email_template.group'),
            'status' => trans('email_template.status'),
            'action' => trans('email_template.admin.action'),
        ];
        $obj = new ShopEmailTemplate;
        $obj = $obj->orderBy('id', 'desc');
        $dataTmp = $obj->paginate(20);

        $dataTr = [];
        foreach ($dataTmp as $key => $row) {
            $dataTr[] = [
                'id' => $row['id'],
                'name' => $row['name'] ?? 'N/A',
                'group' => $row['group'] ?? 'N/A',
                'status' => $row['status'] ? '<span class="badge badge-success">ON</span>' : '<span class="badge badge-danger">OFF</span>',
                'action' => '
                    <a href="' . sc_route('admin_email_template.edit', ['id' => $row['id']]) . '"><span title="' . trans('email_template.admin.edit') . '" type="button" class="btn btn-flat btn-primary"><i class="fa fa-edit"></i></span></a>&nbsp;

                  <span onclick="deleteItem(' . $row['id'] . ');"  title="' . trans('email_template.admin.delete') . '" class="btn btn-flat btn-danger"><i class="fas fa-trash-alt"></i></span>
                  ',
            ];
        }

        $data['listTh'] = $listTh;
        $data['dataTr'] = $dataTr;
        $data['pagination'] = $dataTmp->appends(request()->except(['_token', '_pjax']))->links('admin.component.pagination');
        $data['resultItems'] = trans('email_template.admin.result_item', ['item_from' => $dataTmp->firstItem(), 'item_to' => $dataTmp->lastItem(), 'item_total' => $dataTmp->total()]);

//menuRight
        $data['menuRight'][] = '<a href="' . sc_route('admin_email_template.create') . '" class="btn  btn-success  btn-flat" title="New" id="button_create_new">
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
        $data = [
            'title' => trans('email_template.admin.add_new_title'),
            'subTitle' => '',
            'title_description' => trans('email_template.admin.add_new_des'),
            'icon' => 'fa fa-plus',
            'arrayGroup' => $this->arrayGroup(),
            'obj' => [],
            'url_action' => sc_route('admin_email_template.create'),
        ];
        return view('admin.screen.email_template')
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
            'group' => 'required',
            'text' => 'required',
        ]);

        if ($validator->fails()) {
            // dd($validator->messages());
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }
        $dataInsert = [
            'name' => $data['name'],
            'group' => $data['group'],
            'text' => $data['text'],
            'status' => !empty($data['status']) ? 1 : 0,
        ];
        ShopEmailTemplate::create($dataInsert);
//
        return redirect()->route('admin_email_template.index')->with('success', trans('email_template.admin.create_success'));

    }

/**
 * Form edit
 */
    public function edit($id)
    {
        $obj = ShopEmailTemplate::find($id);
        if ($obj === null) {
            return 'no data';
        }
        $data = [
            'title' => trans('email_template.admin.edit'),
            'subTitle' => '',
            'title_description' => '',
            'icon' => 'fa fa-edit',
            'obj' => $obj,
            'arrayGroup' => $this->arrayGroup(),
            'url_action' => sc_route('admin_email_template.edit', ['id' => $obj['id']]),
        ];
        return view('admin.screen.email_template')
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
            'group' => 'required',
            'text' => 'required',
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
            'group' => $data['group'],
            'text' => $data['text'],
            'status' => !empty($data['status']) ? 1 : 0,
        ];
        $obj = ShopEmailTemplate::find($id);
        $obj->update($dataUpdate);
//
        return redirect()->route('admin_email_template.index')->with('success', trans('email_template.admin.edit_success'));

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
            ShopEmailTemplate::destroy($arrID);
            return response()->json(['error' => 0, 'msg' => '']);
        }
    }

    /**
     * Get list variables support for email template
     *
     * @return json
     */
    public function listVariable()
    {
        $key = request('key');
        $list = [];
        switch ($key) {
            case 'order_success_to_customer':
            case 'order_success_to_admin':
                $list = [
                    '$title',
                    '$orderID',
                    '$toname',
                    '$firstName',
                    '$lastName',
                    '$address',
                    '$address1',
                    '$address2',
                    '$email',
                    '$phone',
                    '$comment',
                    '$orderDetail',
                    '$subtotal',
                    '$shipping',
                    '$discount',
                    '$total',
                ];
                break;

            case 'forgot_password':
                $list = [
                    '$title',
                    '$reason_sednmail',
                    '$note_sendmail',
                    '$note_access_link',
                    '$reset_link',
                    '$reset_button',
                ];
                break;
            case 'contact_to_admin':
                $list = [
                    '$title',
                    '$name',
                    '$email',
                    '$phone',
                    '$content',
                ];
                break;
            case 'welcome_customer':
                    $list = [
                        '$title',
                        '$first_name',
                        '$last_name',
                        '$email',
                        '$phone',
                        '$password',
                        '$address1',
                        '$address2',
                        '$country',
                    ];
                    break;
            default:
                # code...
                break;
        }
        return response()->json($list);
    }

    public function arrayGroup()
    {
        return  [
            'order_success_to_admin' => trans('email.email_action.order_success_to_admin'),
            'order_success_to_customer' => trans('email.email_action.order_success_to_cutomer'),
            'forgot_password' => trans('email.email_action.forgot_password'),
            'welcome_customer' => trans('email.email_action.welcome_customer'),
            'contact_to_admin' => trans('email.email_action.contact_to_admin'),
            'other' => trans('email.email_action.other'),
        ];
    }
}
