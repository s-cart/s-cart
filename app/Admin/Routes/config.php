<?php
$router->group(['prefix' => 'config'], function ($router) {
    $router->get('/', 'AdminConfigController@index')->name('admin_config.index');
    $router->post('/update_info', 'AdminConfigController@updateInfo')->name('admin_config.update');
});
