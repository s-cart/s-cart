<?php
$router->group(['prefix' => 'payment_status'], function ($router) {
    $router->get('/', 'AdminPaymentStatusController@index')->name('admin_payment_status.index');
    $router->get('create', 'AdminPaymentStatusController@create')->name('admin_payment_status.create');
    $router->post('/create', 'AdminPaymentStatusController@postCreate')->name('admin_payment_status.create');
    $router->get('/edit/{id}', 'AdminPaymentStatusController@edit')->name('admin_payment_status.edit');
    $router->post('/edit/{id}', 'AdminPaymentStatusController@postEdit')->name('admin_payment_status.edit');
    $router->post('/delete', 'AdminPaymentStatusController@deleteList')->name('admin_payment_status.delete');
});
