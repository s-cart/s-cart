<?php
$router->group(['prefix' => 'customer'], function ($router) {
    $router->get('/', 'ShopCustomerController@index')->name('admin_customer.index');
    $router->get('create', 'ShopCustomerController@create')->name('admin_customer.create');
    $router->post('/create', 'ShopCustomerController@postCreate')->name('admin_customer.create');
    $router->get('/edit/{id}', 'ShopCustomerController@edit')->name('admin_customer.edit');
    $router->post('/edit/{id}', 'ShopCustomerController@postEdit')->name('admin_customer.edit');
    $router->post('/delete', 'ShopCustomerController@deleteList')->name('admin_customer.delete');
});
