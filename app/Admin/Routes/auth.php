<?php
$router->group(['prefix' => 'auth'], function ($router) {
    $authController = Auth\LoginController::class;
    $router->get('login', $authController . '@getLogin')->name('admin.login');
    $router->post('login', $authController . '@postLogin')->name('admin.login');
    $router->get('logout', $authController . '@getLogout')->name('admin.logout');
    $router->get('setting', $authController . '@getSetting')->name('admin.setting');
    $router->post('setting', $authController . '@putSetting')->name('admin.setting');
});
