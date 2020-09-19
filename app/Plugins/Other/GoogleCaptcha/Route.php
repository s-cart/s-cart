<?php
/**
 * Route front
 */
if(sc_config('GoogleCaptcha')) {
Route::group(
    [
        'prefix'    => 'plugin/googlecaptcha',
        'namespace' => 'App\Plugins\Other\GoogleCaptcha\Controllers',
    ],
    function () {
        Route::get('index', 'FrontController@index')
        ->name('googlecaptcha.index');
    }
);
}
/**
 * Route admin
 */
Route::group(
    [
        'prefix' => SC_ADMIN_PREFIX.'/googlecaptcha',
        'middleware' => SC_ADMIN_MIDDLEWARE,
        'namespace' => 'App\Plugins\Other\GoogleCaptcha\Admin',
    ], 
    function () {
        Route::get('/', 'AdminController@index')
        ->name('admin_googlecaptcha.index');
    }
);
