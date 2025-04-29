<?php
namespace App\GP247\Front\Admin\Controllers;

use GP247\Front\Admin\Controllers\AdminTemplateController as VendorAdminTemplateController;
use GP247\Core\Controllers\ExtensionController;
use GP247\Core\Models\AdminStore;


class AdminTemplateController extends VendorAdminTemplateController
{

    public function __construct()
    {
        parent::__construct();
    }
}
