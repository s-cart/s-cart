<?php
/**
 * Route for cart
 */
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
        $prefixCartWishlist = sc_config('PREFIX_CART_WISHLIST') ?? 'wishlist';
        $prefixCartCompare = sc_config('PREFIX_CART_COMPARE') ?? 'compare';
        $prefixCartDefault = sc_config('PREFIX_CART_DEFAULT') ?? 'cart';

        //Wishlist
        $router->get($prefixCartWishlist.$suffix, $nameSpaceFrontCart.'\ShopCartController@wishlistProcessFront')
            ->name('wishlist');

        //Compare
        $router->get($prefixCartCompare.$suffix, $nameSpaceFrontCart.'\ShopCartController@compareProcessFront')
            ->name('compare');

        //Cart
        $router->get($prefixCartDefault.$suffix, $nameSpaceFrontCart.'\ShopCartController@getCartFront')
            ->name('cart');

        //Add to cart
        $router->post('/cart_add', $nameSpaceFrontCart.'\ShopCartController@addToCart')
            ->name('cart.add');

        //Add to cart ajax
        $router->post('/add_to_cart_ajax', $nameSpaceFrontCart.'\ShopCartController@addToCartAjax')
            ->name('cart.add_ajax');

        //Update cart
        $router->post('/update_to_cart', $nameSpaceFrontCart.'\ShopCartController@updateToCart')
            ->name('cart.update');

        //Remove item from cart
        $router->get('/{instance}/remove/{id}', $nameSpaceFrontCart.'\ShopCartController@removeItemProcessFront')
            ->name('cart.remove');

        //Clear cart
        $router->get('/clear_cart/{instance}', $nameSpaceFrontCart.'\ShopCartController@clearCartProcessFront')
            ->name('cart.clear');
    }
);
