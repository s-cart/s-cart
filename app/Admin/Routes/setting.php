<?php
$router->group(['prefix' => 'setting'], function ($router) {
    $router->get('/', 'AdminSettingController@index')->name('admin_setting.index');
    $router->post('/update_info', 'AdminSettingController@updateInfo')->name('admin_setting.update');
});
