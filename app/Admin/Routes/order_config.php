<?php
$router->group(['prefix' => 'order_config'], function ($router) {
    $router->get('/', 'AdminOrderConfigController@index')->name('admin_order_config.index');
    $router->get('create', 'AdminOrderConfigController@create')->name('admin_order_config.create');
    $router->post('/create', 'AdminOrderConfigController@postCreate')->name('admin_order_config.create');
});
