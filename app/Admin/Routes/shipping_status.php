<?php
$router->group(['prefix' => 'shipping_status'], function ($router) {
    $router->get('/', 'AdminShipingStatusController@index')
        ->name('admin_shipping_status.index');
    $router->get('create', 'AdminShipingStatusController@create')
        ->name('admin_shipping_status.create');
    $router->post('/create', 'AdminShipingStatusController@postCreate')
        ->name('admin_shipping_status.create');
    $router->get('/edit/{id}', 'AdminShipingStatusController@edit')
        ->name('admin_shipping_status.edit');
    $router->post('/edit/{id}', 'AdminShipingStatusController@postEdit')
        ->name('admin_shipping_status.edit');
    $router->post('/delete', 'AdminShipingStatusController@deleteList')
        ->name('admin_shipping_status.delete');
});