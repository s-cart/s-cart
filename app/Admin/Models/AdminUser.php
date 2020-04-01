<?php
#app/Admin/Models/AdminUser.php
namespace App\Admin\Models;

use Illuminate\Auth\Authenticatable;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class AdminUser extends Model implements AuthenticatableContract
{
    use Authenticatable;
    public $table      = SC_DB_PREFIX.'admin_user';
    protected $guarded = [];
    protected $hidden  = [
        'password', 'remember_token',
    ];
    protected static $allPermissions = null;

    /**
     * A user has and belongs to many roles.
     *
     * @return BelongsToMany
     */
    public function roles()
    {
        return $this->belongsToMany(AdminRole::class, SC_DB_PREFIX.'admin_role_user', 'user_id', 'role_id');
    }

    /**
     * A User has and belongs to many permissions.
     *
     * @return BelongsToMany
     */
    public function permissions()
    {
        return $this->belongsToMany(AdminPermission::class, SC_DB_PREFIX.'admin_user_permission', 'user_id', 'permission_id');
    }

    /**
     * Update info customer
     * @param  [array] $dataUpdate
     * @param  [int] $id
     */
    public static function updateInfo($dataUpdate, $id)
    {
        $dataUpdate = sc_clean($dataUpdate, 'password');
        $obj        = self::find($id);
        return $obj->update($dataUpdate);
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
            if (in_array($model->id, SC_GUARD_ADMIN)) {
                return false;
            }
            $model->roles()->detach();
            $model->permissions()->detach();
        });
    }

    /**
     * Create new customer
     * @return [type] [description]
     */
    public static function createUser($dataInsert)
    {
        $dataUpdate = sc_clean($dataInsert, 'password');
        return self::create($dataUpdate);
    }

    /**
     * Get all permissions of user.
     *
     * @return mixed
     */
    public static function allPermissions()
    {
        if (self::$allPermissions === null) {
            $user                 = \Admin::user();
            self::$allPermissions = $user->roles()->with('permissions')->get()->pluck('permissions')->flatten()->merge($user->permissions);
        }
        return self::$allPermissions;
    }

    /**
     * Check if user has permission.
     *
     * @param $ability
     * @param array $arguments
     *
     * @return bool
     */
    public function can($ability, $arguments = []): bool
    {
        if ($this->isAdministrator()) {
            return true;
        }

        if ($this->permissions->pluck('slug')->contains($ability)) {
            return true;
        }

        return $this->roles->pluck('permissions')->flatten()->pluck('slug')->contains($ability);
    }

    /**
     * Check if user has no permission.
     *
     * @param $permission
     *
     * @return bool
     */
    public function cannot(string $permission): bool
    {
        return !$this->can($permission);
    }

    /**
     * Check if user is administrator.
     *
     * @return mixed
     */
    public function isAdministrator(): bool
    {
        return $this->isRole('administrator');
    }

    /**
     * Check if user is view_all.
     *
     * @return mixed
     */
    public function isViewAll(): bool
    {
        return $this->isRole('view.all');
    }

    /**
     * Check if user is $role.
     *
     * @param string $role
     *
     * @return mixed
     */
    public function isRole(string $role): bool
    {
        return $this->roles->pluck('slug')->contains($role);
    }

    /**
     * Check if user in $roles.
     *
     * @param array $roles
     *
     * @return mixed
     */
    public function inRoles(array $roles = []): bool
    {
        return $this->roles->pluck('slug')->intersect($roles)->isNotEmpty();
    }

     /**
      * Check user can visile menu.
      * Allow: is isAdministrator, is viewAll group, 
      * or menu not yet require psermission, or require permission same user
      *
      *
      * @param  \App\Admin\Models\AdminMenu  $menu 
      *
      * @return bool                                
      */
    public function visible(\App\Admin\Models\AdminMenu $menu): bool
    {
        $allPermissionsMenuAllow = $menu->permissions()
            ->pluck('slug')->flatten()->toArray();
        $allRolesMenuAllow       = $menu->roles()
            ->pluck('slug')->flatten()->toArray();
        /*
            Allow if: user is administrator, is isViewAll
            or 
            menu not specify permission and role
         */
        if ((!count($allPermissionsMenuAllow) 
            && !count($allRolesMenuAllow))
            || $this->isAdministrator() 
            || $this->isViewAll()){
            return true;
        }

        /*
            Allow if: user contains  role menu
        */
        if ($allRolesMenuAllow) {
            return $this->inRoles($allRolesMenuAllow);
        }
        /*
            Allow if: user contains  permission menu
        */        
        if ($allPermissionsMenuAllow) {
            return $this->permissions
                ->pluck('slug')->intersect($allPermissionsMenuAllow)
                ->isNotEmpty();
        }

        return false;
    }

}
