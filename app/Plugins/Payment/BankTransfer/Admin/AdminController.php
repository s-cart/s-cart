<?php
#App\Plugins\Payment\BankTransfer\Admin\AdminController.php

namespace App\Plugins\Payment\BankTransfer\Admin;

use App\Http\Controllers\RootAdminController;
use App\Plugins\Payment\BankTransfer\AppConfig;

class AdminController extends RootAdminController
{
    public $plugin;

    public function __construct()
    {
        $this->plugin = new AppConfig;
    }

    public function index()
    {
        $pathPlugin = $this->plugin->pathPlugin;
        return view($pathPlugin.'::Admin',
            [
                'title' => sc_language_render($pathPlugin.'::Lang.info'),
                'pathPlugin' => $pathPlugin
            ]
        );
    }
}
