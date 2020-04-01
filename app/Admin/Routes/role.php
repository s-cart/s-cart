<?php
    $router->group(['prefix' => 'role'], function ($router) {
        $router->get('/', 'Auth\RoleController@index')->name('admin_role.index');
        $router->get('create', 'Auth\RoleController@create')->name('admin_role.create');
        $router->post('/create', 'Auth\RoleController@postCreate')->name('admin_role.create');
        $router->get('/edit/{id}', 'Auth\RoleController@edit')->name('admin_role.edit');
        $router->post('/edit/{id}', 'Auth\RoleController@postEdit')->name('admin_role.edit');
        $router->post('/delete', 'Auth\RoleController@deleteList')->name('admin_role.delete');
    });