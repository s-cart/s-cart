<?php
namespace App\GP247\Front\Controllers\Admin;

use GP247\Front\Controllers\Admin\AdminTemplateController as FrontAdminTemplateController;
use GP247\Core\Controllers\ExtensionController;
use GP247\Core\Models\AdminStore;


class AdminTemplateController extends FrontAdminTemplateController
{

    public function __construct()
    {
        parent::__construct();
    }
}
