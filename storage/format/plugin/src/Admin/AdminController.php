<?php
#App\Plugins\Plugin_Code\Plugin_Key\Admin\AdminController.php

namespace App\Plugins\Plugin_Code\Plugin_Key\Admin;

use App\Http\Controllers\Controller;
use App\Plugins\Plugin_Code\Plugin_Key\AppConfig;

class AdminController extends Controller
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
