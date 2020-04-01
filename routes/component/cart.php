<?php
$prefixCartWishlist = sc_config('PREFIX_CART_WISHLIST')??'wishlist';
$prefixCartCompare = sc_config('PREFIX_CART_COMPARE')??'compare';
$prefixCartDefault = sc_config('PREFIX_CART_DEFAULT')??'cart';
$prefixCartCheckout = sc_config('PREFIX_CART_CHECKOUT')??'checkout';
$prefixOrderSuccess = sc_config('PREFIX_ORDER_SUCCESS')??'order-success';

Route::get('/'.$prefixCartWishlist.$suffix, 'ShopCart@wishlist')
->name('wishlist');
Route::get('/wishlist_remove/{id}', 'ShopCart@removeItemWishlist')
->name('wishlist.remove');

Route::get('/'.$prefixCartCompare.$suffix, 'ShopCart@compare')
->name('compare');
Route::get('/compare_remove/{id}', 'ShopCart@removeItemCompare')
->name('compare.remove');    

Route::get('/'.$prefixCartDefault.$suffix, 'ShopCart@getCart')
->name('cart');
Route::post('/cart_add', 'ShopCart@addToCart')
->name('cart.add');
Route::get('/cart_remove/{id}', 'ShopCart@removeItem')
->name('cart.remove');
Route::get('/clear_Cart/{instance?}', 'ShopCart@clearCart')
->name('cart.clear');
Route::post('/add_to_cart_ajax', 'ShopCart@addToCartAjax')
->name('cart.add_ajax');
Route::post('/update_to_cart', 'ShopCart@updateToCart')
->name('cart.update');
Route::post('/checkout_prepare', 'ShopCart@processCart')
->name('cart.process');

Route::get('/'.$prefixCartCheckout.$suffix, 'ShopCart@getCheckout')
->name('checkout');

Route::post('/order_add', 'ShopCart@addOrder')
->name('order.add');

Route::get('/'.$prefixOrderSuccess.$suffix, 'ShopCart@orderSuccess')
->name('order.success');