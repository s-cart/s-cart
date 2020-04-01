<?php
$router->group(['prefix' => 'subscribe'], function ($router) {
    $router->get('/', 'ShopSubscribeController@index')->name('admin_subscribe.index');
    $router->get('create', 'ShopSubscribeController@create')->name('admin_subscribe.create');
    $router->post('/create', 'ShopSubscribeController@postCreate')->name('admin_subscribe.create');
    $router->get('/edit/{id}', 'ShopSubscribeController@edit')->name('admin_subscribe.edit');
    $router->post('/edit/{id}', 'ShopSubscribeController@postEdit')->name('admin_subscribe.edit');
    $router->post('/delete', 'ShopSubscribeController@deleteList')->name('admin_subscribe.delete');
});
