<?php
#app/Http/Admin/Controllers/ShopApiConnectionController.php
namespace App\Admin\Controllers;

use App\Http\Controllers\Controller;
use App\Models\ShopApiConnection;
use Illuminate\Http\Request;
use Validator;

class ShopApiConnectionController extends Controller
{

    public function index()
    {

        $data = [
            'title' => trans('api_connection.admin.list'),
            'subTitle' => '',
            'icon' => 'fa fa-indent',
            'urlDeleteItem' => route('admin_api_connection.delete'),
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
            'description' => trans('api_connection.description'),
            'apiconnection' => trans('api_connection.apiconnection'),
            'apikey' => trans('api_connection.apikey'),
            'expire' => trans('api_connection.expire'),
            'last_active' => trans('api_connection.last_active'),
            'status' => trans('api_connection.status'),
            'action' => trans('api_connection.admin.action'),
        ];

        $sort_order = request('sort_order') ?? 'id_desc';
        $keyword = request('keyword') ?? '';
        $arrSort = [
        ];
        $obj = new ShopApiConnection;
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
                'description' => $row['description'],
                'apiconnection' => $row['apiconnection'],
                'apikey' => $row['apikey'],
                'expire' => $row['expire'],
                'last_active' => $row['last_active'],
                'status' => $row['status'] ? '<span class="label label-success">ON</span>' : '<span class="label label-danger">OFF</span>',
                'action' => '
                    <a href="' . route('admin_api_connection.edit', ['id' => $row['id']]) . '"><span title="' . trans('api_connection.admin.edit') . '" type="button" class="btn btn-flat btn-primary"><i class="fa fa-edit"></i></span></a>&nbsp;

                  <span onclick="deleteItem(' . $row['id'] . ');"  title="' . trans('api_connection.admin.delete') . '" class="btn btn-flat btn-danger"><i class="fa fa-trash"></i></span>
                  ',
            ];
        }

        $data['listTh'] = $listTh;
        $data['dataTr'] = $dataTr;
        $data['pagination'] = $dataTmp->appends(request()->except(['_token', '_pjax']))->links('admin.component.pagination');
        $data['resultItems'] = trans('api_connection.admin.result_item', ['item_from' => $dataTmp->firstItem(), 'item_to' => $dataTmp->lastItem(), 'item_total' => $dataTmp->total()]);

//menuRight
        $data['menuRight'][] = '<a href="' . route('admin_api_connection.create') . '" class="btn  btn-success  btn-flat" title="New" id="button_create_new">
        <i class="fa fa-plus" title="'.trans('admin.add_new').'"></i>
                           </a>';
//=menuRight

//topMenuRight
$data['topMenuRight'][] ='<a href="https://s-cart.org/docs/master/api-shop-info.html" target="_new"><i class="fa fa-info-circle" aria-hidden="true"></i> '.trans('admin.more_info').'</a>';
//=topMenuRight

//menuSearch        
        $optionSort = '';
        foreach ($arrSort as $key => $status) {
            $optionSort .= '<option  ' . (($sort_order == $key) ? "selected" : "") . ' value="' . $key . '">' . $status . '</option>';
        }

        $data['urlSort'] = route('admin_api_connection.index');
        $data['optionSort'] = $optionSort;
//=menuSort

        $data['menuLeft'][] = '<input id="api_connection_required" type="checkbox"  '.(sc_config('api_connection_required')?'checked':'').'><br> '.trans('api_connection.api_connection_required_help');
        $urlUpdate = route('admin_setting.update');
        $csrf_token = csrf_token();
        $data['js'] = <<< JS
        <script type="text/javascript">
        $("#api_connection_required").bootstrapSwitch();
        $('#api_connection_required').on('switchChange.bootstrapSwitch', function (event, state) {
            var data_config;
            if (state == true) {
                data_config = 1;
            } else {
                data_config = 0;
            }
            $('#loading').show()
            $.ajax({
              type: 'POST',
              dataType:'json',
              url: "$urlUpdate",
              data: {
                "_token": "$csrf_token",
                "name": "api_connection_required",
                "value": data_config
              },
              success: function (response) {
                  console.log(response);
                if(parseInt(response.error) ==0){
                    alertMsg(response.msg, '', 'success');
                }else{
                    alertMsg(response.msg, '', 'error');
                }
                $('#loading').hide();
              }
            });
        }); 
    
    </script>
JS;
        ;
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
            'title' => trans('api_connection.admin.add_new_title'),
            'subTitle' => '',
            'title_description' => trans('api_connection.admin.add_new_des'),
            'icon' => 'fa fa-plus',
            'api_connection' => [],
            'url_action' => route('admin_api_connection.create'),
        ];
        return view('admin.screen.api_connection')
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
            'description' => 'string|required',
            'apiconnection' => 'string|required|regex:/(^([0-9a-z]+)$)/|unique:"'.ShopApiConnection::class.'",apiconnection',
            'apikey' => 'string|regex:/(^([0-9a-z]+)$)/',
        ], [
            'apiconnection.regex' => trans('api_connection.validate_regex'),
            'apikey.regex' => trans('api_connection.validate_regex'),
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        $dataInsert = [
            'description' => $data['description'],
            'apiconnection' => $data['apiconnection'],
            'apikey' => $data['apikey'],
            'expire' => $data['expire'],
            'status' => empty($data['status']) ? 0 : 1,
        ];
        ShopApiConnection::create($dataInsert);

        return redirect()->route('admin_api_connection.index')->with('success', trans('api_connection.admin.create_success'));

    }

/**
 * Form edit
 */
    public function edit($id)
    {
        $api_connection = ShopApiConnection::find($id);
        if ($api_connection === null) {
            return 'no data';
        }
        $data = [
            'title' => trans('api_connection.admin.edit'),
            'subTitle' => '',
            'title_description' => '',
            'icon' => 'fa fa-pencil-square-o',
            'api_connection' => $api_connection,
            'url_action' => route('admin_api_connection.edit', ['id' => $api_connection['id']]),
        ];
        return view('admin.screen.api_connection')
            ->with($data);
    }

/**
 * update status
 */
    public function postEdit($id)
    {
        $data = request()->all();
        $dataOrigin = request()->all();
        $obj = ShopApiConnection::find($id);
        $validator = Validator::make($dataOrigin, [
            'description' => 'string|required',
            'apiconnection' => 'string|required|regex:/(^([0-9a-z]+)$)/|unique:"'.ShopApiConnection::class.'",apiconnection,' . $obj->id . ',id',
            'apikey' => 'string|regex:/(^([0-9a-z]+)$)/',
        ],[
            'apiconnection.regex' => trans('api_connection.validate_regex'),
            'apikey.regex' => trans('api_connection.validate_regex'),
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }
//Edit

        $dataUpdate = [
            'description' => $data['description'],
            'apiconnection' => $data['apiconnection'],
            'apikey' => $data['apikey'],
            'expire' => $data['expire'],
            'status' => empty($data['status']) ? 0 : 1,
        ];
       
        $obj->update($dataUpdate);

//
        return redirect()->route('admin_api_connection.index')->with('success', trans('api_connection.admin.edit_success'));

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
            ShopApiConnection::destroy($arrID);
            return response()->json(['error' => 0, 'msg' => '']);
        }
    }

    public function generateKey(){

        return response()->json(['data' => md5(time())]);
    }


}
