<?php
namespace App\Pmo\Admin\Controllers\Auth;

use App\Pmo\Admin\Admin;
use App\Pmo\Admin\Models\AdminPermission;
use App\Pmo\Admin\Models\AdminRole;
use App\Pmo\Admin\Models\AdminUser;
use App\Pmo\Admin\Controllers\RootAdminController;
use Validator;

class UsersController extends RootAdminController
{
    public $permissions;
    public $roles;
    public function __construct()
    {
        parent::__construct();
        $this->permissions = AdminPermission::pluck('name', 'id')->all();
        $this->roles       = AdminRole::pluck('name', 'id')->all();
    }

    public function index()
    {
        $data = [
            'title'         => sc_language_render('admin.user.list'),
            'subTitle'      => '',
            'icon'          => 'fa fa-indent',
            'urlDeleteItem' => sc_route_admin('admin_user.delete'),
            'removeList'    => 0, // 1 - Enable function delete list item
            'buttonRefresh' => 1, // 1 - Enable button refresh
            'buttonSort'    => 1, // 1 - Enable button sort
            'css'           => '',
            'js'            => '',
        ];
        //Process add content
        $data['menuRight']    = sc_config_group('menuRight', \Request::route()->getName());
        $data['menuLeft']     = sc_config_group('menuLeft', \Request::route()->getName());
        $data['topMenuRight'] = sc_config_group('topMenuRight', \Request::route()->getName());
        $data['topMenuLeft']  = sc_config_group('topMenuLeft', \Request::route()->getName());
        $data['blockBottom']  = sc_config_group('blockBottom', \Request::route()->getName());

        $listTh = [
            'id'         => 'ID',
            'username'   => sc_language_render('admin.user.user_name'),
            'name'       => sc_language_render('admin.user.name'),
            'roles'      => sc_language_render('admin.user.roles'),
            'permission' => sc_language_render('admin.user.permission'),
            'created_at' => sc_language_render('admin.created_at'),
            'action'     => sc_language_render('action.title'),
        ];
        $sort_order = sc_clean(request('sort_order') ?? 'id_desc');
        $keyword    = sc_clean(request('keyword') ?? '');
        $arrSort = [
            'id__desc'       => sc_language_render('filter_sort.id_desc'),
            'id__asc'        => sc_language_render('filter_sort.id_asc'),
            'username__desc' => sc_language_render('filter_sort.alpha_desc', ['alpha' => 'username']),
            'alpha__asc'  => sc_language_render('filter_sort.alpha_asc', ['alpha' => 'username']),
            'name__desc'     => sc_language_render('filter_sort.name_desc'),
            'name__asc'      => sc_language_render('filter_sort.name_asc'),
        ];
        $obj = new AdminUser;

        if ($keyword) {
            $obj = $obj->whereRaw('(id = ' . $keyword . '  OR name like "%' . $keyword . '%" OR username like "%' . $keyword . '%"  )');
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
            $showRoles = '';
            if ($row['roles']->count()) {
                foreach ($row['roles'] as $key => $rols) {
                    $showRoles .= '<span class="badge badge-success">' . $rols->name . '</span> ';
                }
            }
            $showPermission = '';
            if ($row['permissions']->count()) {
                foreach ($row['permissions'] as $key => $p) {
                    $showPermission .= '<span class="badge badge-success">' . $p->name . '</span> ';
                }
            }
            $dataTr[] = [
                'id' => $row['id'],
                'username' => $row['username'],
                'name' => $row['name'],
                'roles' => $showRoles,
                'permission' => $showPermission,
                'created_at' => $row['created_at'],
                'action' => '
                    <a href="' . sc_route_admin('admin_user.edit', ['id' => $row['id'] ? $row['id'] : 'not-found-id']) . '"><span title="' . sc_language_render('action.edit') . '" type="button" class="btn btn-flat btn-sm btn-primary"><i class="fa fa-edit"></i></span></a>&nbsp;
                    ' . ((Admin::user()->id == $row['id'] || in_array($row['id'], SC_GUARD_ADMIN)) ? '' : '<span onclick="deleteItem(\'' . $row['id'] . '\');"  title="' . sc_language_render('action.delete') . '" class="btn btn-flat btn-sm btn-danger"><i class="fas fa-trash-alt"></i></span>')
                ,
            ];
        }

        $data['listTh'] = $listTh;
        $data['dataTr'] = $dataTr;
        $data['pagination'] = $dataTmp->appends(request()->except(['_token', '_pjax']))->links($this->templatePathAdmin.'component.pagination');
        $data['resultItems'] = sc_language_render('admin.result_item', ['item_from' => $dataTmp->firstItem(), 'item_to' => $dataTmp->lastItem(), 'total' =>  $dataTmp->total()]);

        //menuRight
        $data['menuRight'][] = '<a href="' . sc_route_admin('admin_user.create') . '" class="btn  btn-success  btn-flat" title="New" id="button_create_new">
                           <i class="fa fa-plus" title="'.sc_language_render('action.add').'"></i>
                           </a>';
        //=menuRight

        //menuSort
        $optionSort = '';
        foreach ($arrSort as $key => $status) {
            $optionSort .= '<option  ' . (($sort_order == $key) ? "selected" : "") . ' value="' . $key . '">' . $status . '</option>';
        }

        $data['urlSort'] = sc_route_admin('admin_user.index', request()->except(['_token', '_pjax', 'sort_order']));

        $data['optionSort'] = $optionSort;
        //=menuSort

        //menuSearch
        $data['topMenuRight'][] = '
                <form action="' . sc_route_admin('admin_user.index') . '" id="button_search">
                <div class="input-group input-group" style="width: 350px;">
                    <input type="text" name="keyword" class="form-control rounded-0 float-right" placeholder="' . sc_language_render('admin.user.search_place') . '" value="' . $keyword . '">
                    <div class="input-group-append">
                        <button type="submit" class="btn btn-primary"><i class="fas fa-search"></i></button>
                    </div>
                </div>
                </form>';
        //=menuSearch


        return view($this->templatePathAdmin.'screen.list')
            ->with($data);
    }

    /**
     * Form create new item in admin
     * @return [type] [description]
     */
    public function create()
    {
        $data = [
            'title'             => sc_language_render('admin.user.add_new_title'),
            'subTitle'          => '',
            'title_description' => sc_language_render('admin.user.add_new_des'),
            'icon'              => 'fa fa-plus',
            'user'              => [],
            'roles'             => $this->roles,
            'permissions'       => $this->permissions,
            'url_action'        => sc_route_admin('admin_user.create'),
        ];

        return view($this->templatePathAdmin.'auth.user')
            ->with($data);
    }

    /**
     * Post create new item in admin
     * @return [type] [description]
     */
    public function postCreate()
    {
        $data = request()->all();
        $dataOrigin = request()->all();
        $validator = Validator::make($dataOrigin, [
            'name'     => 'required|string|max:100',
            'username' => 'required|regex:/(^([0-9A-Za-z@\._]+)$)/|unique:"'.AdminUser::class.'",username|string|max:100|min:3',
            'avatar'   => 'nullable|string|max:255',
            'password' => 'required|string|max:60|min:6|confirmed',
            'email'    => 'required|string|email|max:255|unique:"'.AdminUser::class.'",email',
        ], [
            'username.regex' => sc_language_render('admin.user.username_validate'),
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }
        $dataCreate = [
            'name'     => $data['name'],
            'username' => strtolower($data['username']),
            'avatar'   => $data['avatar'],
            'email'    => strtolower($data['email']),
            'password' => bcrypt($data['password']),
        ];
        $dataCreate = sc_clean($dataCreate, [], true);
        $user = AdminUser::createUser($dataCreate);

        $roles = $data['roles'] ?? [];
        $permission = $data['permission'] ?? [];

        //Process role special
        if (in_array(1, $roles)) {
            // If group admin
            $roles = [1];
            $permission = [];
        } elseif (in_array(2, $roles)) {
            // If group onlyview
            $roles = [2];
            $permission = [];
        }
        //End process role special

        //Insert roles
        if ($roles) {
            $user->roles()->attach($roles);
        }
        //Insert permission
        if ($permission) {
            $user->permissions()->attach($permission);
        }

        return redirect()->route('admin_user.index')->with('success', sc_language_render('action.create_success'));
    }

    /**
     * Form edit
     */
    public function edit($id)
    {
        $user = AdminUser::find($id);
        if ($user === null) {
            return 'no data';
        }
        $data = [
            'title'             => sc_language_render('action.edit'),
            'subTitle'          => '',
            'title_description' => '',
            'icon'              => 'fa fa-edit',
            'user'              => $user,
            'roles'             => $this->roles,
            'permissions'       => $this->permissions,
            'url_action'        => sc_route_admin('admin_user.edit', ['id' => $user['id']]),
            'isAllStore'        => ($user->isAdministrator() || $user->isViewAll()) ? 1: 0,

        ];
        return view($this->templatePathAdmin.'auth.user')
            ->with($data);
    }

    /**
     * update status
     */
    public function postEdit($id)
    {
        $user = AdminUser::find($id);
        $data = request()->all();
        $dataOrigin = request()->all();
        $validator = Validator::make($dataOrigin, [
            'name'     => 'required|string|max:100',
            'username' => 'required|regex:/(^([0-9A-Za-z@\._]+)$)/|unique:"'.AdminUser::class.'",username,' . $user->id . '|string|max:100|min:3',
            'avatar'   => 'nullable|string|max:255',
            'password' => 'nullable|string|max:60|min:6|confirmed',
            'email'    => 'required|string|email|max:255|unique:"'.AdminUser::class.'",email,' . $user->id,
        ], [
            'username.regex' => sc_language_render('admin.user.username_validate'),
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }
        //Edit
        $dataUpdate = [
            'name' => $data['name'],
            'username' => strtolower($data['username']),
            'avatar' => $data['avatar'],
            'email' => strtolower($data['email']),
        ];
        if ($data['password']) {
            $dataUpdate['password'] = bcrypt($data['password']);
        }
        $dataUpdate = sc_clean($dataUpdate, [], true);
        AdminUser::updateInfo($dataUpdate, $id);

        if (!in_array($user->id, SC_GUARD_ADMIN)) {
            $roles = $data['roles'] ?? [];
            $permission = $data['permission'] ?? [];
            $user->roles()->detach();
            $user->permissions()->detach();
            //Insert roles
            if ($roles) {
                $user->roles()->attach($roles);
            }
            //Insert permission
            if ($permission) {
                $user->permissions()->attach($permission);
            }
        }

//
        return redirect()->route('admin_user.index')->with('success', sc_language_render('action.edit_success'));
    }

    /*
    Delete list Item
    Need mothod destroy to boot deleting in model
     */
    public function deleteList()
    {
        if (!request()->ajax()) {
            return response()->json(['error' => 1, 'msg' => sc_language_render('admin.method_not_allow')]);
        } else {
            $ids = request('ids');
            $arrID = explode(',', $ids);
            $arrID = array_diff($arrID, SC_GUARD_ADMIN);
            AdminUser::destroy($arrID);
            return response()->json(['error' => 1, 'msg' => '']);
        }
    }
}
