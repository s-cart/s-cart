<?php
#app/Http/Admin/Controllers/Auth/RoleController.php
namespace App\Admin\Controllers\Auth;

use App\Admin\Admin;
use App\Admin\Models\AdminPermission;
use App\Admin\Models\AdminRole;
use App\Admin\Models\AdminUser;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Validator;

class RoleController extends Controller
{
    public function index()
    {
        $data = [
            'title' => trans('role.admin.list'),
            'subTitle' => '',
            'icon' => 'fa fa-indent',
            'urlDeleteItem' => sc_route('admin_role.delete'),
            'removeList' => 0, // 1 - Enable function delete list item
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
            'id' => trans('role.id'),
            'slug' => trans('role.slug'),
            'name' => trans('role.name'),
            'permission' => trans('role.permission'),
            'created_at' => trans('role.created_at'),
            'updated_at' => trans('role.updated_at'),
            'action' => trans('role.admin.action'),
        ];
        $sort_order = request('sort_order') ?? 'id_desc';
        $keyword = request('keyword') ?? '';
        $arrSort = [
            'id__desc' => trans('role.admin.sort_order.id_desc'),
            'id__asc' => trans('role.admin.sort_order.id_asc'),
            'name__desc' => trans('role.admin.sort_order.name_desc'),
            'name__asc' => trans('role.admin.sort_order.name_asc'),
        ];
        $obj = new AdminRole;
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
            $showPermission = '';
            if ($row['permissions']->count()) {
                foreach ($row['permissions'] as $key => $p) {
                    $showPermission .= '<span class="badge badge-success"">' . $p->name . '</span> ';
                }
            }

            $dataTr[] = [
                'id' => $row['id'],
                'slug' => $row['slug'],
                'name' => $row['name'],
                'permission' => $showPermission,
                'created_at' => $row['created_at'],
                'updated_at' => $row['updated_at'],
                'action' => (in_array($row['id'], SC_GUARD_ROLES) ? '' : '
                    <a href="' . sc_route('admin_role.edit', ['id' => $row['id']]) . '"><span title="' . trans('role.admin.edit') . '" type="button" class="btn btn-flat btn-primary"><i class="fa fa-edit"></i></span></a>&nbsp;
                    ') . ((in_array($row['id'], SC_GUARD_ROLES)) ? '' : '<span onclick="deleteItem(' . $row['id'] . ');"  title="' . trans('admin.delete') . '" class="btn btn-flat btn-danger"><i class="fas fa-trash-alt"></i></span>')
                ,
            ];
        }

        $data['listTh'] = $listTh;
        $data['dataTr'] = $dataTr;
        $data['pagination'] = $dataTmp->appends(request()->except(['_token', '_pjax']))->links('admin.component.pagination');
        $data['resultItems'] = trans('role.admin.result_item', ['item_from' => $dataTmp->firstItem(), 'item_to' => $dataTmp->lastItem(), 'item_total' => $dataTmp->total()]);

//menuRight
        $data['menuRight'][] = '<a href="' . sc_route('admin_role.create') . '" class="btn  btn-success  btn-flat" title="New" id="button_create_new">
                           <i class="fa fa-plus" title="'.trans('admin.add_new').'"></i>
                           </a>';
//=menuRight

//menuSort
        $optionSort = '';
        foreach ($arrSort as $key => $status) {
            $optionSort .= '<option  ' . (($sort_order == $key) ? "selected" : "") . ' value="' . $key . '">' . $status . '</option>';
        }

        $data['urlSort'] = sc_route('admin_role.index');
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
            'title' => trans('role.admin.add_new_title'),
            'subTitle' => '',
            'title_description' => trans('role.admin.add_new_des'),
            'icon' => 'fa fa-plus',
            'role' => [],
            'permission' => (new AdminPermission)->pluck('name', 'id')->all(),
            'userList' => (new AdminUser)->pluck('name', 'id')->all(),
            'url_action' => sc_route('admin_role.create'),

        ];

        return view('admin.auth.role')
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
            'name' => 'required|string|max:50|unique:"'.AdminRole::class.'",name',
            'slug' => 'required|regex:/(^([0-9A-Za-z\._\-]+)$)/|unique:"'.AdminRole::class.'",slug|string|max:50|min:3',
        ], [
            'slug.regex' => trans('role.slug_validate'),
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        $dataInsert = [
            'name' => $data['name'],
            'slug' => $data['slug'],
        ];

        $role = AdminRole::createRole($dataInsert);
        $permission = $data['permission'] ?? [];
        $administrators = $data['administrators'] ?? [];
        //Insert permission
        if ($permission) {
            $role->permissions()->attach($permission);
        }
        //Insert administrators
        if ($administrators) {
            $role->administrators()->attach($administrators);
        }
        return redirect()->route('admin_role.index')->with('success', trans('role.admin.create_success'));

    }

/**
 * Form edit
 */
    public function edit($id)
    {
        $role = AdminRole::find($id);
        if ($role === null) {
            return 'no data';
        }
        $data = [
            'title' => trans('role.admin.edit'),
            'subTitle' => '',
            'title_description' => '',
            'icon' => 'fa fa-edit',
            'role' => $role,
            'permission' => (new AdminPermission)->pluck('name', 'id')->all(),
            'userList' => (new AdminUser)->pluck('name', 'id')->all(),
            'url_action' => sc_route('admin_role.edit', ['id' => $role['id']]),
        ];
        return view('admin.auth.role')
            ->with($data);
    }

/**
 * update status
 */
    public function postEdit($id)
    {
        $role = AdminRole::find($id);
        $data = request()->all();
        $dataOrigin = request()->all();
        $validator = Validator::make($dataOrigin, [
            'name' => 'required|string|max:50|unique:"'.AdminRole::class.'",name,' . $role->id . '',
            'slug' => 'required|regex:/(^([0-9A-Za-z\._\-]+)$)/|unique:"'.AdminRole::class.'",slug,' . $role->id . '|string|max:50|min:3',
        ], [
            'slug.regex' => trans('role.slug_validate'),
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
        ];
        $role->update($dataUpdate);
        $permission = $data['permission'] ?? [];
        $administrators = $data['administrators'] ?? [];
        $role->permissions()->detach();
        $role->administrators()->detach();
        //Insert permission
        if ($permission) {
            $role->permissions()->attach($permission);
        }
        //Insert administrators
        if ($administrators) {
            $role->administrators()->attach($administrators);
        }
//
        return redirect()->route('admin_role.index')->with('success', trans('role.admin.edit_success'));

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
            $arrID = array_diff($arrID, SC_GUARD_ROLES);
            AdminRole::destroy($arrID);
            return response()->json(['error' => 0, 'msg' => '']);
        }
    }

}
