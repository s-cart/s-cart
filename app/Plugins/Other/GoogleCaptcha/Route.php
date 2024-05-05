<?php
/**
 * Route front
 */
if(sc_config_exist('GoogleCaptcha')) {
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
if(sc_config_exist('GoogleCaptcha', SC_ID_ROOT)) {
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
}
