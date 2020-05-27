<?php
#app/Http/Admin/Controllers/AdminMenuController.php
namespace App\Admin\Controllers;

use App\Admin\Admin;
use App\Admin\Models\AdminMenu;
use App\Admin\Models\AdminPermission;
use App\Admin\Models\AdminRole;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Validator;

class AdminMenuController extends Controller
{
    public function index()
    {
        $data = [
            'title' => trans('menu.admin.list'),
            'subTitle' => '',
            'icon' => 'fa fa-indent',            'menu' => [],
            'treeMenu' => (new AdminMenu)->getTree(),
            'roles' => (new AdminRole)->pluck('name', 'id')->all(),
            'permissions' => (new AdminPermission)->pluck('name', 'id')->all(),
            'url_action' => route('admin_menu.create'),
            'urlDeleteItem' => route('admin_menu.delete'),
            'title_form' => '<i class="fa fa-floppy-o" aria-hidden="true"></i> ' . trans('menu.admin.create'),
        ];
        return view('admin.screen.list-menu')
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
            'title' => 'required',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        $dataInsert = [
            'title' => $data['title'],
            'parent_id' => $data['parent_id'],
            'uri' => $data['uri'],
            'icon' => $data['icon'],
            'sort' => $data['sort'],
        ];

        $menu = AdminMenu::createMenu($dataInsert);
        $permissions = $data['permissions'] ?? [];
        $roles = $data['roles'] ?? [];
        //Insert permission
        if ($permissions) {
            $menu->permissions()->attach($permissions);
        }
        $roles = $data['roles'] ?? [];
        //Insert roles
        if ($roles) {
            $menu->roles()->attach($roles);
        }
        return redirect()->route('admin_menu.index')->with('success', trans('menu.admin.create_success'));

    }

/**
 * Form edit
 */
    public function edit($id)
    {
        $menu = AdminMenu::find($id);
        if ($menu === null) {
            return 'no data';
        }
        $data = [
            'title' => trans('menu.admin.list'),
            'subTitle' => '',
            'title_description' => '',
            'icon' => 'fa fa-pencil-square-o',
            'menu' => $menu,
            'treeMenu' => (new AdminMenu)->getTree(),
            'roles' => (new AdminRole)->pluck('name', 'id')->all(),
            'permissions' => (new AdminPermission)->pluck('name', 'id')->all(),
            'url_action' => route('admin_menu.edit', ['id' => $menu['id']]),
            'title_form' => '<i class="fa fa-pencil-square-o" aria-hidden="true"></i> ' . trans('menu.admin.edit'),
        ];
        $data['urlDeleteItem'] = route('admin_menu.delete');
        return view('admin.screen.list-menu')
            ->with($data);
    }

/**
 * update status
 */
    public function postEdit($id)
    {
        $menu = AdminMenu::find($id);
        $data = request()->all();
        $dataOrigin = request()->all();
        $validator = Validator::make($dataOrigin, [
            'title' => 'required',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }
//Edit

        $dataUpdate = [
            'title' => $data['title'],
            'parent_id' => $data['parent_id'],
            'uri' => $data['uri'],
            'icon' => $data['icon'],
            'sort' => $data['sort'],
        ];

        AdminMenu::updateInfo($dataUpdate, $id);
        $permissions = $data['permissions'] ?? [];
        $menu->permissions()->detach();
        //Insert permission
        if ($permissions) {
            $menu->permissions()->attach($permissions);
        }
        $roles = $data['roles'] ?? [];
        $menu->roles()->detach();
        //Insert permission
        if ($roles) {
            $menu->roles()->attach($roles);
        }

//
        return redirect()->route('admin_menu.index')->with('success', trans('menu.admin.edit_success'));

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
            $id = request('id');
            $check = AdminMenu::where('parent_id', $id)->count();
            if ($check) {
                return response()->json(['error' => 1, 'msg' => trans('menu.admin.error_have_child')]);
            } else {
                AdminMenu::destroy($id);
            }
            return response()->json(['error' => 0, 'msg' => '']);
        }
    }

/*
Update menu resort
 */
    public function updateSort()
    {
        $data = request('menu') ?? [];
        $reSort = json_decode($data, true);
        $newTree = [];
        foreach ($reSort as $key => $level_1) {
            $newTree[$level_1['id']] = [
                'parent_id' => 0,
                'sort' => ++$key,
            ];
            if (!empty($level_1['children'])) {
                $list_level_2 = $level_1['children'];
                foreach ($list_level_2 as $key => $level_2) {
                    $newTree[$level_2['id']] = [
                        'parent_id' => $level_1['id'],
                        'sort' => ++$key,
                    ];
                    if (!empty($level_2['children'])) {
                        $list_level_3 = $level_2['children'];
                        foreach ($list_level_3 as $key => $level_3) {
                            $newTree[$level_3['id']] = [
                                'parent_id' => $level_2['id'],
                                'sort' => ++$key,
                            ];
                        }
                    }
                }
            }
        }
        $response = (new AdminMenu)->reSort($newTree);
        return $response;
    }
}
