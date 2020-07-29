<?php
$router->group(['prefix' => 'link'], function ($router) {
    $router->get('/', 'AdminLinkController@index')->name('admin_link.index');
    $router->get('create', 'AdminLinkController@create')->name('admin_link.create');
    $router->post('/create', 'AdminLinkController@postCreate')->name('admin_link.create');
    $router->get('/edit/{id}', 'AdminLinkController@edit')->name('admin_link.edit');
    $router->post('/edit/{id}', 'AdminLinkController@postEdit')->name('admin_link.edit');
    $router->post('/delete', 'AdminLinkController@deleteList')->name('admin_link.delete');
});
