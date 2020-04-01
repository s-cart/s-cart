<?php
$router->group(['prefix' => 'shipping_status'], function ($router) {
    $router->get('/', 'ShopShipingStatusController@index')
        ->name('admin_shipping_status.index');
    $router->get('create', 'ShopShipingStatusController@create')
        ->name('admin_shipping_status.create');
    $router->post('/create', 'ShopShipingStatusController@postCreate')
        ->name('admin_shipping_status.create');
    $router->get('/edit/{id}', 'ShopShipingStatusController@edit')
        ->name('admin_shipping_status.edit');
    $router->post('/edit/{id}', 'ShopShipingStatusController@postEdit')
        ->name('admin_shipping_status.edit');
    $router->post('/delete', 'ShopShipingStatusController@deleteList')
        ->name('admin_shipping_status.delete');
});