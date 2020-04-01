<?php
$prefixBrand = sc_config('PREFIX_BRAND')??'brand';

Route::group(['prefix' => $prefixBrand], function ($router) use($suffix) {
    $router->get('/', 'ShopFront@allBrand')->name('brand.all');
    $router->get('/{alias}'.$suffix, 'ShopFront@brandDetail')
        ->name('brand.detail');
});