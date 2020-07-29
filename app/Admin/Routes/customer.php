<?php
$router->group(['prefix' => 'customer'], function ($router) {
    $router->get('/', 'AdminCustomerController@index')->name('admin_customer.index');
    $router->get('create', 'AdminCustomerController@create')->name('admin_customer.create');
    $router->post('/create', 'AdminCustomerController@postCreate')->name('admin_customer.create');
    $router->get('/edit/{id}', 'AdminCustomerController@edit')->name('admin_customer.edit');
    $router->post('/edit/{id}', 'AdminCustomerController@postEdit')->name('admin_customer.edit');
    $router->post('/delete', 'AdminCustomerController@deleteList')->name('admin_customer.delete');
    $router->get('/update-address/{id}', 'AdminCustomerController@updateAddress')->name('admin_customer.update_address');
    $router->post('/update-address/{id}', 'AdminCustomerController@postUpdateAddress')->name('admin_customer.post_update_address');
    $router->post('/delete-address', 'AdminCustomerController@deleteAddress')->name('admin_customer.delete_address');
});
