<?php
#App\Plugins\Plugin_Code\Plugin_Key\Controllers\FrontController.php
namespace App\Plugins\Plugin_Code\Plugin_Key\Controllers;

use App\Plugins\Plugin_Code\Plugin_Key\AppConfig;
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

    public function processOrder(){
        // Function require if plugin is payment method
    }
}
