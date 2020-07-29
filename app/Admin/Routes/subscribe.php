<?php
$router->group(['prefix' => 'subscribe'], function ($router) {
    $router->get('/', 'AdminSubscribeController@index')->name('admin_subscribe.index');
    $router->get('create', 'AdminSubscribeController@create')->name('admin_subscribe.create');
    $router->post('/create', 'AdminSubscribeController@postCreate')->name('admin_subscribe.create');
    $router->get('/edit/{id}', 'AdminSubscribeController@edit')->name('admin_subscribe.edit');
    $router->post('/edit/{id}', 'AdminSubscribeController@postEdit')->name('admin_subscribe.edit');
    $router->post('/delete', 'AdminSubscribeController@deleteList')->name('admin_subscribe.delete');
});
