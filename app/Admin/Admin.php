<?php

namespace App\Admin;

use App\Admin\Models\AdminMenu;
use Illuminate\Support\Facades\Auth;

/**
 * Class Admin.
 */
class Admin
{

    public static function user()
    {
        return Auth::guard('admin')->user();
    }

    public static function isLoginPage()
    {
        return (request()->route()->getName() == 'admin.login');
    }

    public static function isLogoutPage()
    {
        return (request()->route()->getName() == 'admin.logout');
    }
    public static function getMenu()
    {
        return AdminMenu::getList()->groupBy('parent_id');
    }
    public static function getMenuVisible()
    {
        return AdminMenu::getListVisible();
    }   
}
