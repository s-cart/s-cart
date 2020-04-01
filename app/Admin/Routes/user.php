<?php
$router->group(['prefix' => 'user'], function ($router) {
    $router->get('/', 'Auth\UsersController@index')->name('admin_user.index');
    $router->get('create', 'Auth\UsersController@create')->name('admin_user.create');
    $router->post('/create', 'Auth\UsersController@postCreate')->name('admin_user.create');
    $router->get('/edit/{id}', 'Auth\UsersController@edit')->name('admin_user.edit');
    $router->post('/edit/{id}', 'Auth\UsersController@postEdit')->name('admin_user.edit');
    $router->post('/delete', 'Auth\UsersController@deleteList')->name('admin_user.delete');
});
