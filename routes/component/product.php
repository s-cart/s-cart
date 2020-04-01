<?php
$prefixProduct = sc_config('PREFIX_PRODUCT')??'product';

Route::group(['prefix' => $prefixProduct], function ($router) use($suffix) {
    $router->get('/', 'ShopFront@allProduct')->name('product.all');
    $router->post('/info', 'ShopFront@productInfo')
        ->name('product.info');
    $router->get('/{alias}'.$suffix, 'ShopFront@productDetail')
        ->name('product.detail');
});