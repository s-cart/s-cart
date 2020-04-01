<?php
$router->group(['prefix' => 'link'], function ($router) {
    $router->get('/', 'ShopLinkController@index')->name('admin_link.index');
    $router->get('create', 'ShopLinkController@create')->name('admin_link.create');
    $router->post('/create', 'ShopLinkController@postCreate')->name('admin_link.create');
    $router->get('/edit/{id}', 'ShopLinkController@edit')->name('admin_link.edit');
    $router->post('/edit/{id}', 'ShopLinkController@postEdit')->name('admin_link.edit');
    $router->post('/delete', 'ShopLinkController@deleteList')->name('admin_link.delete');
});
