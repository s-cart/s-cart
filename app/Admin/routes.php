<?php

use Illuminate\Routing\Router;

Route::group(
    [
        'prefix' => SC_ADMIN_PREFIX,
        'middleware' => SC_ADMIN_MIDDLEWARE,
        'namespace' => 'App\Admin\Controllers'
    ], 
    function (Router $router) {
    foreach (glob(__DIR__ . '/Routes/*.php') as $filename) {
        require_once $filename;
    }
    $router->get('/', 'DashboardController@index')->name('admin.home');
    $router->get('deny', 'DashboardController@deny')->name('admin.deny');
    $router->get('deny_single', 'DashboardController@denySingle')->name('admin.deny_single');

    //Language
    $router->get('locale/{code}', function ($code) {
        session(['locale' => $code]);
        return back();
    })->name('admin.locale');

    //theme
    $router->get('theme/{theme}', function ($theme) {
        session(['adminTheme' => $theme]);
        if (!\Admin::user()->isViewAll()) {
            \Admin::user()->update(['theme' => $theme]);
        }
        return back();
    })->name('admin.theme');
});
