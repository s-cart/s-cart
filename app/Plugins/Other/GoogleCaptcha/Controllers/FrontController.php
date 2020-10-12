<?php
#App\Plugins\Other\GoogleCaptcha\Controllers\FrontController.php
namespace App\Plugins\Other\GoogleCaptcha\Controllers;

use App\Plugins\Other\GoogleCaptcha\AppConfig;
use App\Http\Controllers\RootFrontController;
class FrontController extends RootFrontController
{
    public $plugin;

    public function __construct()
    {
        parent::__construct();
        $this->plugin = new AppConfig;
    }

    public function index() {
        return view($this->plugin->pathPlugin.'::Front',
            [
                //
            ]
        );
    }
}
