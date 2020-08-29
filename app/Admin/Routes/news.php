<?php
$router->group(['prefix' => 'news'], function ($router) {
    $router->get('/', 'AdminNewsController@index')->name('admin_news.index');
    $router->get('create', 'AdminNewsController@create')->name('admin_news.create');
    $router->post('/create', 'AdminNewsController@postCreate')->name('admin_news.create');
    $router->get('/edit/{id}', 'AdminNewsController@edit')->name('admin_news.edit');
    $router->post('/edit/{id}', 'AdminNewsController@postEdit')->name('admin_news.edit');
    $router->post('/delete', 'AdminNewsController@deleteList')->name('admin_news.delete');
});
