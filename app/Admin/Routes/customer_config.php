<?php
$router->group(['prefix' => 'customer_config'], function ($router) {
    $router->get('/', 'AdminCustomerConfigController@index')->name('admin_customer_config.index');
    $router->get('create', 'AdminCustomerConfigController@create')->name('admin_customer_config.create');
    $router->post('/create', 'AdminCustomerConfigController@postCreate')->name('admin_customer_config.create');
});
