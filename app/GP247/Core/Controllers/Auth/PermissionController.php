<?php
namespace App\GP247\Core\Controllers\Auth;

use GP247\Core\Controllers\Auth\PermissionController as VendorAdminPermissionController;


class PermissionController extends VendorAdminPermissionController
{
    public function __construct()
    {
        parent::__construct();
    }
}
