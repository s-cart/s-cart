<?php
$router->group(['prefix' => 'store_maintain'], function ($router) {
    $router->get('/', 'AdminStoreMaintainController@index')->name('admin_store_maintain.index');
    $router->post('/', 'AdminStoreMaintainController@postEdit');
});
