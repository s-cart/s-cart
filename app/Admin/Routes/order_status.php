<?php
$router->group(['prefix' => 'order_status'], function ($router) {
    $router->get('/', 'AdminOrderStatusController@index')->name('admin_order_status.index');
    $router->get('create', 'AdminOrderStatusController@create')->name('admin_order_status.create');
    $router->post('/create', 'AdminOrderStatusController@postCreate')->name('admin_order_status.create');
    $router->get('/edit/{id}', 'AdminOrderStatusController@edit')->name('admin_order_status.edit');
    $router->post('/edit/{id}', 'AdminOrderStatusController@postEdit')->name('admin_order_status.edit');
    $router->post('/delete', 'AdminOrderStatusController@deleteList')->name('admin_order_status.delete');
});
