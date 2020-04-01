<?php
$router->group(['prefix' => 'payment_status'], function ($router) {
    $router->get('/', 'ShopPaymentStatusController@index')->name('admin_payment_status.index');
    $router->get('create', 'ShopPaymentStatusController@create')->name('admin_payment_status.create');
    $router->post('/create', 'ShopPaymentStatusController@postCreate')->name('admin_payment_status.create');
    $router->get('/edit/{id}', 'ShopPaymentStatusController@edit')->name('admin_payment_status.edit');
    $router->post('/edit/{id}', 'ShopPaymentStatusController@postEdit')->name('admin_payment_status.edit');
    $router->post('/delete', 'ShopPaymentStatusController@deleteList')->name('admin_payment_status.delete');
});
