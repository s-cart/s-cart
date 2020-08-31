<?php
$router->group(['prefix' => 'store_maintain'], function ($router) {
    $router->get('/', 'AdminStoreMaintainController@index')->name('admin_store_maintain.index');
    $router->get('/edit/{id}', 'AdminStoreMaintainController@edit')->name('admin_store_maintain.edit');
    $router->post('/edit/{id}', 'AdminStoreMaintainController@postEdit');
    $router->post('/update_info', 'AdminStoreMaintainController@updateInfo')->name('admin_store_maintain.update');
});
