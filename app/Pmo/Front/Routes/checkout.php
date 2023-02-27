<?php
if (file_exists(app_path('Http/Controllers/ShopCartController.php'))) {
    $nameSpaceFrontCart = 'App\Http\Controllers';
} else {
    $nameSpaceFrontCart = 'App\Pmo\Front\Controllers';
}
Route::group(
    [
        'prefix' => $langUrl
    ],
    function ($router) use ($suffix, $nameSpaceFrontCart) {
        $prefixCartCheckout = sc_config('PREFIX_CART_CHECKOUT') ?? 'checkout';
        $prefixCartCheckoutConfirm = sc_config('PREFIX_CART_CHECKOUT_CONFIRM') ?? 'checkout-confirm';
        $prefixOrderSuccess = sc_config('PREFIX_ORDER_SUCCESS') ?? 'order-success';
        
        //Checkout prepare, from screen cart to checkout
        $router->post('/checkout-prepare', $nameSpaceFrontCart.'\ShopCartController@prepareCheckout')
            ->name('checkout.prepare');

        //Checkout screen
        $router->get($prefixCartCheckout.$suffix, $nameSpaceFrontCart.'\ShopCartController@getCheckoutFront')
            ->name('checkout');

        //Checkout process, from screen checkout to checkout confirm
        $router->post('/checkout-process', $nameSpaceFrontCart.'\ShopCartController@processCheckout')
            ->name('checkout.process');

        //Checkout process, from screen checkout confirm to order
        $router->get($prefixCartCheckoutConfirm.$suffix, $nameSpaceFrontCart.'\ShopCartController@getCheckoutConfirmFront')
            ->name('checkout.confirm');

        //Add order
        $router->post('/order-add', $nameSpaceFrontCart.'\ShopCartController@addOrder')
            ->name('order.add');

        //Order success
        $router->get($prefixOrderSuccess.$suffix, $nameSpaceFrontCart.'\ShopCartController@orderSuccessProcessFront')
            ->name('order.success');
    }
);
