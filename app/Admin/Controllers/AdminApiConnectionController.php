<?php
#app/Http/Admin/Controllers/AdminApiConnectionController.php
namespace App\Admin\Controllers;

use App\Http\Controllers\Controller;
use App\Models\ShopApiConnection;
use Illuminate\Http\Request;
use Validator;

class AdminApiConnectionController extends Controller
{

    public function index()
    {
        $data = [
            'title' => trans('api_connection.admin.list'),
            'title_action' => '<i class="fa fa-plus" aria-hidden="true"></i> ' . trans('api_connection.admin.add_new_title'),
            'subTitle' => '',
            'icon' => 'fa fa-indent',
            'urlDeleteItem' => sc_route('admin_api_connection.delete'),
            'removeList' => 0, // 1 - Enable function delete list item
            'buttonRefresh' => 0, // 1 - Enable button refresh
            'buttonSort' => 0, // 1 - Enable button sort
            'css' => '', 
            'js' => '',
            'url_action' => sc_route('admin_api_connection.create'),
            'layout' => 'index',
        ];

        $listTh = [
            'id' => trans('api_connection.id'),
            'description' => trans('api_connection.description'),
            'apiconnection' => trans('api_connection.apiconnection'),
            'apikey' => trans('api_connection.apikey'),
            'expire' => trans('api_connection.expire'),
            'last_active' => trans('api_connection.last_active'),
            'status' => trans('api_connection.status'),
            'action' => trans('api_connection.admin.action'),
        ];

        $obj = new ShopApiConnection;
        $obj = $obj->orderBy('id', 'desc');
        $dataTmp = $obj->paginate(20);

        $dataTr = [];
        foreach ($dataTmp as $key => $row) {
            $dataTr[] = [
                'description' => $row['description'],
                'id' => $row['id'],
                'apiconnection' => $row['apiconnection'],
                'apikey' => $row['apikey'],
                'expire' => $row['expire'],
                'last_active' => $row['last_active'],
                'status' => $row['status'] ? '<span class="badge badge-success">ON</span>' : '<span class="badge badge-danger">OFF</span>',
                'action' => '
                    <a href="' . sc_route('admin_api_connection.edit', ['id' => $row['id']]) . '"><span title="' . trans('api_connection.admin.edit') . '" type="button" class="btn btn-flat btn-primary"><i class="fa fa-edit"></i></span></a>&nbsp;

                  <span onclick="deleteItem(' . $row['id'] . ');"  title="' . trans('api_connection.admin.delete') . '" class="btn btn-flat btn-danger"><i class="fas fa-trash-alt"></i></span>
                  ',
            ];
        }

        $data['listTh'] = $listTh;
        $data['dataTr'] = $dataTr;
        $data['pagination'] = $dataTmp->appends(request()->except(['_token', '_pjax']))->links('admin.component.pagination');
        $data['resultItems'] = trans('api_connection.admin.result_item', ['item_from' => $dataTmp->firstItem(), 'item_to' => $dataTmp->lastItem(), 'item_total' => $dataTmp->total()]);

        $data['rightContentMain'] = '<input id="api_connection_required" type="checkbox"  '.(sc_config('api_connection_required')?'checked':'').'><br> '.trans('api_connection.api_connection_required_help');
    
        $optionSort = '';
        $data['urlSort'] = sc_route('admin_api_connection.index');
        $data['optionSort'] = $optionSort;

        $urlUpdate = sc_route('admin_config.update');
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
                    alertJs('success', response.msg);
                    
                }else{
                    alertJs('error', response.msg);
                }
                $('#loading').hide();
              }
            });
        }); 
    
    </script>
JS;
        ;
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
        $obj = ShopApiConnection::create($dataInsert);

        return redirect()->route('admin_api_connection.edit', ['id' => $obj['id']])->with('success', trans('api_connection.admin.create_success'));

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
        'title' => trans('api_connection.admin.list'),
        'title_action' => '<i class="fa fa-edit" aria-hidden="true"></i> ' . trans('api_connection.admin.edit'),
        'subTitle' => '',
        'icon' => 'fa fa-indent',
        'urlDeleteItem' => sc_route('admin_api_connection.delete'),
        'removeList' => 0, // 1 - Enable function delete list item
        'buttonRefresh' => 0, // 1 - Enable button refresh
        'buttonSort' => 0, // 1 - Enable button sort
        'css' => '', 
        'js' => '',
        'api_connection' => $api_connection,
        'url_action' => sc_route('admin_api_connection.edit', ['id' => $api_connection['id']]),
        'layout' => 'edit',
        'id' => $id,
    ];

    $listTh = [
        'id' => trans('api_connection.id'),
        'description' => trans('api_connection.description'),
        'apiconnection' => trans('api_connection.apiconnection'),
        'apikey' => trans('api_connection.apikey'),
        'expire' => trans('api_connection.expire'),
        'last_active' => trans('api_connection.last_active'),
        'status' => trans('api_connection.status'),
        'action' => trans('api_connection.admin.action'),
    ];

    $obj = new ShopApiConnection;
    $obj = $obj->orderBy('id', 'desc');
    $dataTmp = $obj->paginate(20);

    $dataTr = [];
    foreach ($dataTmp as $key => $row) {
        $dataTr[] = [
            'id' => $row['id'],
            'description' => $row['description'],
            'apiconnection' => $row['apiconnection'],
            'apikey' => $row['apikey'],
            'expire' => $row['expire'],
            'last_active' => $row['last_active'],
            'status' => $row['status'] ? '<span class="badge badge-success">ON</span>' : '<span class="badge badge-danger">OFF</span>',
            'action' => '
                <a href="' . sc_route('admin_api_connection.edit', ['id' => $row['id']]) . '"><span title="' . trans('api_connection.admin.edit') . '" type="button" class="btn btn-flat btn-primary"><i class="fa fa-edit"></i></span></a>&nbsp;

              <span onclick="deleteItem(' . $row['id'] . ');"  title="' . trans('api_connection.admin.delete') . '" class="btn btn-flat btn-danger"><i class="fas fa-trash-alt"></i></span>
              ',
        ];
    }

    $data['listTh'] = $listTh;
    $data['dataTr'] = $dataTr;
    $data['pagination'] = $dataTmp->appends(request()->except(['_token', '_pjax']))->links('admin.component.pagination');
    $data['resultItems'] = trans('api_connection.admin.result_item', ['item_from' => $dataTmp->firstItem(), 'item_to' => $dataTmp->lastItem(), 'item_total' => $dataTmp->total()]);

    $data['rightContentMain'] = '<input id="api_connection_required" type="checkbox"  '.(sc_config('api_connection_required')?'checked':'').'><br> '.trans('api_connection.api_connection_required_help');

    $optionSort = '';
    $data['urlSort'] = sc_route('admin_api_connection.index');
    $data['optionSort'] = $optionSort;

    $urlUpdate = sc_route('admin_config.update');
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
        return redirect()->back()->with('success', trans('api_connection.admin.edit_success'));

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
