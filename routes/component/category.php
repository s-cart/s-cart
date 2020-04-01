<?php
$prefixCategory = sc_config('PREFIX_CATEGORY')??'category';

Route::group(['prefix' => $prefixCategory], function ($router) use($suffix) {
    $router->get('/', 'ShopFront@allCategory')->name('category.all');
    $router->get('/{alias}'.$suffix, 'ShopFront@categoryDetail')
        ->name('category.detail');
});