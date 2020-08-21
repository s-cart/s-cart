<?php
#app/Http/Admin/Controllers/AdminLogController.php
namespace App\Admin\Controllers;

use App\Admin\Models\AdminLog;
use App\Admin\Models\AdminUser;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class AdminLogController extends Controller
{

    public function index()
    {

        $data = [
            'title' => trans('log.admin.list'),
            'subTitle' => '',
            'icon' => 'fa fa-indent',
            'urlDeleteItem' => sc_route('admin_log.delete'),
            'removeList' => 1, // 1 - Enable function delete list item
            'buttonRefresh' => 1, // 1 - Enable button refresh
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
            'id' => trans('log.id'),
            'user' => trans('log.user'),
            'method' => trans('log.method'),
            'path' => trans('log.path'),
            'ip' => trans('log.ip'),
            'user_agent' => trans('log.user_agent'),
            'input' => trans('log.input'),
            'created_at' => trans('log.created_at'),
            'action' => trans('log.admin.action'),
        ];

        $sort_order = request('sort_order') ?? 'id_desc';
        $arrSort = [
            'id__desc' => trans('log.admin.sort_order.id_desc'),
            'id__asc' => trans('log.admin.sort_order.id_asc'),
            'user_id__desc' => trans('log.admin.sort_order.user_id_desc'),
            'user_id__asc' => trans('log.admin.sort_order.user_id_asc'),
            'path__desc' => trans('log.admin.sort_order.path_desc'),
            'path__asc' => trans('log.admin.sort_order.path_asc'),
            'user_agent__desc' => trans('log.admin.sort_order.user_agent_desc'),
            'user_agent__asc' => trans('log.admin.sort_order.user_agent_asc'),
            'method__desc' => trans('log.admin.sort_order.method_desc'),
            'method__asc' => trans('log.admin.sort_order.method_asc'),
            'ip__desc' => trans('log.admin.sort_order.ip_desc'),
            'ip__asc' => trans('log.admin.sort_order.ip_asc'),

        ];
        $obj = new AdminLog;

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
                'user_id' => ($user = AdminUser::find($row['user_id'])) ? $user->name : 'N/A',
                'method' => '<span class="badge bg-' . (AdminLog::$methodColors[$row['method']] ?? '') . '">' . $row['method'] . '</span>',
                'path' => '<code>' . $row['path'] . '</code>',
                'ip' => $row['ip'],
                'user_agent' => $row['user_agent'],
                'input' => $row['input'],
                'created_at' => $row['created_at'],
                'action' => '
                  <span  onclick="deleteItem(' . $row['id'] . ');"  title="' . trans('log.admin.delete') . '" class="btn btn-flat btn-danger"><i class="fas fa-trash-alt"></i></span>
                  ',
            ];
        }

        $data['listTh'] = $listTh;
        $data['dataTr'] = $dataTr;
        $data['pagination'] = $dataTmp->appends(request()->except(['_token', '_pjax']))->links('admin.component.pagination');
        $data['resultItems'] = trans('log.admin.result_item', ['item_from' => $dataTmp->firstItem(), 'item_to' => $dataTmp->lastItem(), 'item_total' => $dataTmp->total()]);

//menuSearch        
        $optionSort = '';
        foreach ($arrSort as $key => $status) {
            $optionSort .= '<option  ' . (($sort_order == $key) ? "selected" : "") . ' value="' . $key . '">' . $status . '</option>';
        }
        $data['optionSort'] = $optionSort;
        $data['urlSort'] = sc_route('admin_log.index');
//=menuSort

        return view('admin.screen.list')
            ->with($data);
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
            AdminLog::destroy($arrID);
            return response()->json(['error' => 0, 'msg' => '']);
        }
    }

}
