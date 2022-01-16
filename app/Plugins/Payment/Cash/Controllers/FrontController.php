<?php
#App\Plugins\Payment\Cash\Controllers\FrontController.php
namespace App\Plugins\Payment\Cash\Controllers;

use SCart\Core\Front\Controllers\ShopCartController;
use SCart\Core\Front\Controllers\RootFrontController;
class FrontController extends RootFrontController
{
    /**
     * Process order
     *
     * @return  [type]  [return description]
     */
    public function processOrder(){
        
        return (new ShopCartController)->completeOrder();
    }
}
