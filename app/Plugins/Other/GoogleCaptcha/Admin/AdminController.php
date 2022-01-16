<?php
#App\Plugins\Other\GoogleCaptcha\Admin\AdminController.php

namespace App\Plugins\Other\GoogleCaptcha\Admin;

use SCart\Core\Admin\Controllers\RootAdminController;
use App\Plugins\Other\GoogleCaptcha\AppConfig;

class AdminController extends RootAdminController
{
    public $plugin;

    public function __construct()
    {
        $this->plugin = new AppConfig;
    }
    public function index()
    {
        return view($this->plugin->pathPlugin.'::Admin',
            [
                
            ]
        );
    }
}
