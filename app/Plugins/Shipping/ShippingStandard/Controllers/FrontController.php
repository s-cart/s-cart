<?php
/**
 * @package    App\Plugins\Shipping\ShippingStandard\Controllers
 * @subpackage FrontController
 * @copyright  Copyright (c) 2020 SCart opensource.
 * @author     Lanh le <lanhktc@gmail.com>
 */

#App\Plugins\Shipping\ShippingStandard\Controllers\FrontController.php
namespace App\Plugins\Shipping\ShippingStandard\Controllers;

use App\Plugins\Shipping\ShippingStandard\AppConfig;
use App\Http\Controllers\RootFrontController;
class FrontController extends RootFrontController
{
    public $plugin;

    public function __construct()
    {
        parent::__construct();
        $this->plugin = new AppConfig;
    }

    /**
     * Update config
     */
    public function updateConfig() {
        $data = request()->all();
        return $this->plugin->updateConfig($data);
    }

}
