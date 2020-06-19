<?php
Route::group(
    [
        'prefix'    => 'plugin/shipping/ShippingStandard',
        'namespace' => 'App\Plugins\Shipping\ShippingStandard\Controllers',
    ], function () {
        Route::post('updateConfig', 'FrontController@updateConfig')
            ->name('shippingstandard.updateConfig');
    });