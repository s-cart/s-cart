<?php
$router->group(['prefix' => 'api_connection'], function ($router) {
    $router->get('/', 'AdminApiConnectionController@index')->name('admin_api_connection.index');
    $router->get('create', 'AdminApiConnectionController@create')->name('admin_api_connection.create');
    $router->post('/create', 'AdminApiConnectionController@postCreate')->name('admin_api_connection.create');
    $router->get('/edit/{id}', 'AdminApiConnectionController@edit')->name('admin_api_connection.edit');
    $router->post('/edit/{id}', 'AdminApiConnectionController@postEdit')->name('admin_api_connection.edit');
    $router->post('/delete', 'AdminApiConnectionController@deleteList')->name('admin_api_connection.delete');
    $router->get('/generate_key', 'AdminApiConnectionController@generateKey')->name('admin_api_connection.generate_key');
});
