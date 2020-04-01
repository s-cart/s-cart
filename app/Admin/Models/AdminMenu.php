<?php
#app/Admin/Models/AdminMenu.php
namespace App\Admin\Models;

use DB;
use Illuminate\Database\Eloquent\Model;

class AdminMenu extends Model
{
    public $table = SC_DB_PREFIX.'admin_menu';
    protected $guarded = [];
    private static $getList = null;

    /**
     * A menu has and belongs to many roles.
     *
     * @return BelongsToMany
     */
    public function roles()
    {
        return $this->belongsToMany(AdminRole::class, SC_DB_PREFIX.'admin_role_menu', 'menu_id', 'role_id');
    }

    /**
     * A Menu has and belongs to many permissions.
     *
     * @return BelongsToMany
     */
    public function permissions()
    {
        return $this->belongsToMany(AdminPermission::class, SC_DB_PREFIX.'admin_menu_permission', 'menu_id', 'permission_id');
    }

    public static function getList()
    {
        if (self::$getList == null) {
            self::$getList = self::with('permissions','roles')
                ->orderBy('sort', 'asc')->get();
        }
        return self::$getList;
    }

    /**
     * Get list menu can visible for user
     *
     * @return  [type]  [return description]
     */
    public static function getListVisible()
    {
        $list = self::getList();
        $listVisible = [];
        $admin = \Admin::user();
        foreach ($list as  $menu) {
            $allPermissionsMenuAllow = $menu->permissions
                ->pluck('slug')->flatten()->toArray();
            $allRolesMenuAllow       = $menu->roles
                ->pluck('slug')->flatten()->toArray();
            if ((!count($allPermissionsMenuAllow) 
            && !count($allRolesMenuAllow))
            || $admin->isAdministrator() 
            || $admin->isViewAll()){
                $listVisible[] = $menu;
            }
        }
        $listVisible = collect($listVisible)->groupBy('parent_id');
        return $listVisible;
    }

    public function getTree($parent = 0, &$tree = null, $menus = null, &$st = '')
    {
        $menus = $menus ?? $this->getList()->groupBy('parent_id');
        $tree = $tree ?? [];
        $lisMenu = $menus[$parent] ?? [];
        foreach ($lisMenu as $menu) {
            $tree[$menu->id] = $st . ' ' . sc_language_render($menu->title);
            if (!empty($menus[$menu->id])) {
                $st .= '--';
                $this->getTree($menu->id, $tree, $menus, $st);
                $st = '';
            }
        }

        return $tree;
    }

    /**
     * Detach models from the relationship.
     *
     * @return void
     */
    protected static function boot()
    {
        parent::boot();

        static::deleting(function ($model) {
            $model->roles()->detach();
            $model->permissions()->detach();
        });
    }

/*
Re-sort menu
 */
    public function reSort(array $data)
    {
        try {
            DB::connection(SC_CONNECTION)->beginTransaction();
            foreach ($data as $key => $menu) {
                $this->where('id', $key)->update($menu);
            }
            DB::connection(SC_CONNECTION)->commit();
            $return = ['error' => 0, 'msg' => ""];
        } catch (\Exception $e) {
            DB::connection(SC_CONNECTION)->rollBack();
            $return = ['error' => 1, 'msg' => $e->getMessage()];
        }
        return $return;
    }

/**
 * [updateInfo description]
 */
    public static function updateInfo($arrFields, $id)
    {
        return self::where('id', $id)->update($arrFields);
    }

    /**
     * Create new menu
     * @return [type] [description]
     */
    public static function createMenu($dataInsert)
    {
        $dataUpdate = sc_clean($dataInsert, 'password');
        return self::create($dataUpdate);
    }

}
