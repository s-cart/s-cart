<?php
#app/Http/Admin/Controllers/Auth/PermissionController.php
namespace App\Admin\Controllers\Auth;

use App\Admin\Admin;
use App\Admin\Models\AdminPermission;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Validator;

class PermissionController extends Controller
{

    public $routeAdmin;

    public function __construct()
    {
        $routes = app()->routes->getRoutes();
        foreach ($routes as $value) {
            if (\Illuminate\Support\Str::startsWith($value->getPrefix(), SC_ADMIN_PREFIX)) {
                $prefix = SC_ADMIN_PREFIX?$value->getPrefix():ltrim($value->getPrefix(),'/');
                $routeAdmin[$prefix] = [
                    'uri' => 'ANY::' . $prefix . '/*',
                    'name' => $prefix . '/*',
                    'method' => 'ANY',
                ];
                foreach ($value->methods as $key => $method) {
                    if ($method != 'HEAD' && !collect($this->without())->first(function ($exp) use ($value) {
                        return Str::startsWith($value->uri, $exp);
                    })) {
                        $routeAdmin[] = [
                            'uri' => $method . '::' . $value->uri,
                            'name' => $value->uri,
                            'method' => $method,
                        ];
                    }

                }
            }
        }
        $this->routeAdmin = $routeAdmin;
    }

    public function index()
    {
        $data = [
            'title' => trans('permission.admin.list'),
            'subTitle' => '',
            'icon' => 'fa fa-indent',
            'urlDeleteItem' => sc_route('admin_permission.delete'),
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
            'id' => trans('permission.id'),
            'slug' => trans('permission.slug'),
            'name' => trans('permission.name'),
            'http_path' => trans('permission.http_path'),
            'updated_at' => trans('permission.updated_at'),
            'action' => trans('permission.admin.action'),
        ];
        $sort_order = request('sort_order') ?? 'id_desc';
        $arrSort = [
            'id__desc' => trans('permission.admin.sort_order.id_desc'),
            'id__asc' => trans('permission.admin.sort_order.id_asc'),
            'name__desc' => trans('permission.admin.sort_order.name_desc'),
            'name__asc' => trans('permission.admin.sort_order.name_asc'),
        ];
        $obj = new AdminPermission;
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
            $permissions = '';
            if ($row['http_uri']) {
                $methods = array_map(function ($value) {
                    $route = explode('::', $value);
                    $methodStyle = '';
                    if ($route[0] == 'ANY') {
                        $methodStyle = '<span class="badge badge-info">' . $route[0] . '</span>';
                    } else
                    if ($route[0] == 'POST') {
                        $methodStyle = '<span class="badge badge-warning">' . $route[0] . '</span>';
                    } else {
                        $methodStyle = '<span class="badge badge-primary">' . $route[0] . '</span>';
                    }
                    return $methodStyle . ' <code>' . $route[1] . '</code>';
                }, explode(',', $row['http_uri']));
                $permissions = implode('<br>', $methods);
            }
            $dataTr[] = [
                'id' => $row['id'],
                'slug' => $row['slug'],
                'name' => $row['name'],
                'permission' => $permissions,
                'updated_at' => $row['updated_at'],
                'action' => '
                    <a href="' . sc_route('admin_permission.edit', ['id' => $row['id']]) . '"><span title="' . trans('permission.admin.edit') . '" type="button" class="btn btn-flat btn-primary"><i class="fa fa-edit"></i></span></a>&nbsp;
                    <span onclick="deleteItem(' . $row['id'] . ');"  title="' . trans('admin.delete') . '" class="btn btn-flat btn-danger"><i class="fas fa-trash-alt"></i></span>'
                ,
            ];
        }

        $data['listTh'] = $listTh;
        $data['dataTr'] = $dataTr;
        $data['pagination'] = $dataTmp->appends(request()->except(['_token', '_pjax']))->links('admin.component.pagination');
        $data['resultItems'] = trans('permission.admin.result_item', ['item_from' => $dataTmp->firstItem(), 'item_to' => $dataTmp->lastItem(), 'item_total' => $dataTmp->total()]);

//menuRight
        $data['menuRight'][] = '<a href="' . sc_route('admin_permission.create') . '" class="btn  btn-success  btn-flat" title="New" id="button_create_new">
                           <i class="fa fa-plus" title="'.trans('admin.add_new').'"></i>
                           </a>';
//=menuRight

//menuSort
        $optionSort = '';
        foreach ($arrSort as $key => $status) {
            $optionSort .= '<option  ' . (($sort_order == $key) ? "selected" : "") . ' value="' . $key . '">' . $status . '</option>';
        }

        $data['urlSort'] = sc_route('admin_permission.index');
        $data['optionSort'] = $optionSort;
//=menuSort

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
            'title' => trans('permission.admin.add_new_title'),
            'subTitle' => '',
            'title_description' => trans('permission.admin.add_new_des'),
            'icon' => 'fa fa-plus',
            'permission' => [],
            'routeAdmin' => $this->routeAdmin,
            'url_action' => sc_route('admin_permission.create'),

        ];

        return view('admin.auth.permission')
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
            'name' => 'required|string|max:50|unique:"'.AdminPermission::class.'",name',
            'slug' => 'required|regex:/(^([0-9A-Za-z\._\-]+)$)/|unique:"'.AdminPermission::class.'",slug|string|max:50|min:3',
        ], [
            'slug.regex' => trans('permission.slug_validate'),
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        $dataInsert = [
            'name' => $data['name'],
            'slug' => $data['slug'],
            'http_uri' => implode(',', ($data['http_uri'] ?? [])),
        ];

        $permission = AdminPermission::createPermission($dataInsert);

        return redirect()->route('admin_permission.index')->with('success', trans('permission.admin.create_success'));

    }

/**
 * Form edit
 */
    public function edit($id)
    {
        $permission = AdminPermission::find($id);
        if ($permission === null) {
            return 'no data';
        }
        $data = [
            'title' => trans('permission.admin.edit'),
            'subTitle' => '',
            'title_description' => '',
            'icon' => 'fa fa-edit',
            'permission' => $permission,
            'routeAdmin' => $this->routeAdmin,
            'url_action' => sc_route('admin_permission.edit', ['id' => $permission['id']]),
        ];
        return view('admin.auth.permission')
            ->with($data);
    }

/**
 * update status
 */
    public function postEdit($id)
    {
        $permission = AdminPermission::find($id);
        $data = request()->all();
        $dataOrigin = request()->all();
        $validator = Validator::make($dataOrigin, [
            'name' => 'required|string|max:50|unique:"'.AdminPermission::class.'",name,' . $permission->id . '',
            'slug' => 'required|regex:/(^([0-9A-Za-z\._\-]+)$)/|unique:"'.AdminPermission::class.'",slug,' . $permission->id . '|string|max:50|min:3',
        ], [
            'slug.regex' => trans('permission.slug_validate'),
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }
//Edit

        $dataUpdate = [
            'name' => $data['name'],
            'slug' => $data['slug'],
            'http_uri' => implode(',', ($data['http_uri'] ?? [])),
        ];
        $permission->update($dataUpdate);
//
        return redirect()->route('admin_permission.index')->with('success', trans('permission.admin.edit_success'));

    }

/*
Delete list Item
Need mothod destroy to boot deleting in model
 */
    public function deleteList()
    {
        if (!request()->ajax()) {
            return response()->json(['error' => 1, 'msg' => 'Method not allow!']);
        } else {
            $ids = request('ids');
            $arrID = explode(',', $ids);
            AdminPermission::destroy($arrID);
            return response()->json(['error' => 0, 'msg' => '']);
        }
    }

    public function without()
    {
        $prefix = SC_ADMIN_PREFIX?SC_ADMIN_PREFIX.'/':'';
        return [
            $prefix . 'login',
            $prefix . 'logout',
            $prefix . 'forgot',
            $prefix . 'deny',
            $prefix . 'locale',
            $prefix . 'uploads',
        ];
    }

}
