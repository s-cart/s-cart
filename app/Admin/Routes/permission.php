<?php
$router->group(['prefix' => 'permission'], function ($router) {
    $router->get('/', 'Auth\PermissionController@index')->name('admin_permission.index');
    $router->get('create', 'Auth\PermissionController@create')->name('admin_permission.create');
    $router->post('/create', 'Auth\PermissionController@postCreate')->name('admin_permission.create');
    $router->get('/edit/{id}', 'Auth\PermissionController@edit')->name('admin_permission.edit');
    $router->post('/edit/{id}', 'Auth\PermissionController@postEdit')->name('admin_permission.edit');
    $router->post('/delete', 'Auth\PermissionController@deleteList')->name('admin_permission.delete');
});
