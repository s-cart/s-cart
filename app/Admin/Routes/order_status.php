<?php
$router->group(['prefix' => 'order_status'], function ($router) {
    $router->get('/', 'ShopOrderStatusController@index')->name('admin_order_status.index');
    $router->get('create', 'ShopOrderStatusController@create')->name('admin_order_status.create');
    $router->post('/create', 'ShopOrderStatusController@postCreate')->name('admin_order_status.create');
    $router->get('/edit/{id}', 'ShopOrderStatusController@edit')->name('admin_order_status.edit');
    $router->post('/edit/{id}', 'ShopOrderStatusController@postEdit')->name('admin_order_status.edit');
    $router->post('/delete', 'ShopOrderStatusController@deleteList')->name('admin_order_status.delete');
});
