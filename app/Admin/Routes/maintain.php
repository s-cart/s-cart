<?php
$router->group(['prefix' => 'maintain'], function ($router) {
    $router->get('/', 'AdminMaintainController@index')->name('admin_maintain.index');
    $router->get('edit', 'AdminMaintainController@edit')->name('admin_maintain.edit');
    $router->post('edit', 'AdminMaintainController@postEdit');
    $router->post('/update_info', 'AdminMaintainController@updateInfo')->name('admin_maintain.update');
});
