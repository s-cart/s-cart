<?php
namespace App\Pmo\Admin\Models;

use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Support\Str;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Laravel\Sanctum\HasApiTokens;

class AdminUser extends Authenticatable
{
    use \App\Pmo\Front\Models\UuidTrait;
    use  Notifiable, HasApiTokens;
    public $table      = SC_DB_PREFIX.'admin_user';
    protected $guarded = [];
    protected $hidden  = [
        'password', 'remember_token',
    ];
    protected static $allPermissions = null;
    protected static $allViewPermissions = null;
    protected static $canChangeConfig = null;
    protected static $listStoreId = null;
    protected static $listStore = null;

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
        $dataUpdate = sc_clean($dataUpdate);
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

        //Uuid
        static::creating(function ($model) {
            if (empty($model->{$model->getKeyName()})) {
                $model->{$model->getKeyName()} = sc_generate_id($type = 'admin_user');
            }
        });
    }

    /**
     * Create new customer
     * @return [type] [description]
     */
    public static function createUser($dataInsert)
    {
        $dataUpdate = sc_clean($dataInsert);
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
            self::$allPermissions = $user->roles()->with('permissions')
                ->get()->pluck('permissions')->flatten()
                ->merge($user->permissions);
        }
        return self::$allPermissions;
    }

    /**
     * Get all view permissions of user.
     *
     * @return mixed
     */
    protected static function allViewPermissions()
    {
        if (self::$allViewPermissions === null) {
            $arrView = [];
            $allPermissionTmp = self::allPermissions();
            $allPermissionTmp = $allPermissionTmp->pluck('http_uri')->toArray();
            if ($allPermissionTmp) {
                foreach ($allPermissionTmp as  $actionList) {
                    foreach (explode(',', $actionList) as  $action) {
                        if (strpos($action, 'ANY::') === 0 || strpos($action, 'GET::') === 0) {
                            $arrPrefix = ['ANY::', 'GET::'];
                            $arrScheme = ['https://', 'http://'];
                            $arrView[] = str_replace($arrScheme, '', url(str_replace($arrPrefix, '', $action)));
                        }
                    }
                }
            }
            self::$allViewPermissions = $arrView;
        }
        return self::$allViewPermissions;
    }

    /**
     * Check url menu can display
     *
     * @param   [type]  $url  [$url description]
     *
     * @return  [type]        [return description]
     */
    public function checkUrlAllowAccess($url)
    {
        if ($this->isAdministrator() || $this->isViewAll()) {
            return true;
        }
        $listUrlAllowAccess = self::allViewPermissions();
        $arrScheme = ['https://', 'http://'];
        $pathCheck = strtolower(str_replace($arrScheme, '', $url));
        if ($listUrlAllowAccess) {
            foreach ($listUrlAllowAccess as  $pathAllow) {
                if ($pathCheck === $pathAllow
                    || $pathCheck  === $pathAllow.'/'
                    || (Str::endsWith($pathAllow, '*') && ($pathCheck === str_replace('/*', '', $pathAllow) || strpos($pathCheck, str_replace('*', '', $pathAllow)) === 0))
                    || (Str::endsWith($pathAllow, '{id}') && ($pathCheck === str_replace('/{id}', '', $pathAllow) || strpos($pathCheck, str_replace('{id}', '', $pathAllow)) === 0))
                    ) {
                    return true;
                }
            }
        }
        return false;
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
    public function cannot($permission, $arguments = []): bool
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
     * Check user can change config value
     *
     * @return  [type]  [return description]
     */
    public static function checkPermissionConfig()
    {
        if (self::$canChangeConfig === null) {
            if (\Admin::user()->isAdministrator()) {
                return self::$canChangeConfig = true;
            }

            if (self::allPermissions()->first(function ($permission) {
                if (!$permission->http_uri) {
                    return false;
                }
                $actions = explode(',', $permission->http_uri);
                foreach ($actions as $key => $action) {
                    $method = explode('::', $action);
                    if (
                        in_array($method[0], ['ANY', 'POST'])
                        && (
                            SC_ADMIN_PREFIX . '/config/*' == $method[1]
                        || SC_ADMIN_PREFIX . '/config/update_info' == $method[1]
                        || SC_ADMIN_PREFIX . '/config' == $method[1]
                        )
                    ) {
                        return true;
                    }
                }
            })) {
                return self::$canChangeConfig = true;
            } else {
                return self::$canChangeConfig = false;
            }
        } else {
            return self::$canChangeConfig;
        }
    }


    /**
     * Send email reset password
     * @param  [type] $token [description]
     * @return [type]        [description]
     */
    public function sendPasswordResetNotification($token)
    {
        $emailReset = $this->getEmailForPasswordReset();
        return sc_admin_sendmail_reset_notification($token, $emailReset);
    }
}
