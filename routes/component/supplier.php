<?php
$prefixSupplier = sc_config('PREFIX_SUPPLIER')??'supplier';

Route::group(['prefix' => $prefixSupplier], function ($router) use($suffix) {
    $router->get('/', 'ShopFront@allSupplier')->name('supplier.all');
    $router->get('/{alias}'.$suffix, 'ShopFront@supplierDetail')
        ->name('supplier.detail');
});