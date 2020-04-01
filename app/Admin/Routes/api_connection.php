<?php
$router->group(['prefix' => 'api_connection'], function ($router) {
    $router->get('/', 'ShopApiConnectionController@index')->name('admin_api_connection.index');
    $router->get('create', 'ShopApiConnectionController@create')->name('admin_api_connection.create');
    $router->post('/create', 'ShopApiConnectionController@postCreate')->name('admin_api_connection.create');
    $router->get('/edit/{id}', 'ShopApiConnectionController@edit')->name('admin_api_connection.edit');
    $router->post('/edit/{id}', 'ShopApiConnectionController@postEdit')->name('admin_api_connection.edit');
    $router->post('/delete', 'ShopApiConnectionController@deleteList')->name('admin_api_connection.delete');
    $router->get('/generate_key', 'ShopApiConnectionController@generateKey')->name('admin_api_connection.generate_key');
});
