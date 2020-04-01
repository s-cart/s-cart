<?php
$router->group(['prefix' => 'page'], function ($router) {
    $router->get('/', 'ShopPageController@index')->name('admin_page.index');
    $router->get('create', 'ShopPageController@create')->name('admin_page.create');
    $router->post('/create', 'ShopPageController@postCreate')->name('admin_page.create');
    $router->get('/edit/{id}', 'ShopPageController@edit')->name('admin_page.edit');
    $router->post('/edit/{id}', 'ShopPageController@postEdit')->name('admin_page.edit');
    $router->post('/delete', 'ShopPageController@deleteList')->name('admin_page.delete');
});
//=Page
