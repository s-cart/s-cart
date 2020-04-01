<?php
#App\Plugins\Payment\Cash\Controllers\FrontController.php
namespace App\Plugins\Payment\Cash\Controllers;

use App\Http\Controllers\ShopCart;
use App\Http\Controllers\GeneralController;
class FrontController extends GeneralController
{
    /**
     * Process order
     *
     * @return  [type]  [return description]
     */
    public function processOrder(){
        
        return (new ShopCart)->completeOrder();
    }
}
