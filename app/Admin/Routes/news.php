<?php
$router->group(['prefix' => 'news'], function ($router) {
    $router->get('/', 'ShopNewsController@index')->name('admin_news.index');
    $router->get('create', 'ShopNewsController@create')->name('admin_news.create');
    $router->post('/create', 'ShopNewsController@postCreate')->name('admin_news.create');
    $router->get('/edit/{id}', 'ShopNewsController@edit')->name('admin_news.edit');
    $router->post('/edit/{id}', 'ShopNewsController@postEdit')->name('admin_news.edit');
    $router->post('/delete', 'ShopNewsController@deleteList')->name('admin_news.delete');
});
