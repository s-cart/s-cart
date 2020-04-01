<?php
$router->group(['prefix' => 'banner'], function ($router) {
    $router->get('/', 'ShopBannerController@index')->name('admin_banner.index');
    $router->get('create', 'ShopBannerController@create')->name('admin_banner.create');
    $router->post('/create', 'ShopBannerController@postCreate')->name('admin_banner.create');
    $router->get('/edit/{id}', 'ShopBannerController@edit')->name('admin_banner.edit');
    $router->post('/edit/{id}', 'ShopBannerController@postEdit')->name('admin_banner.edit');
    $router->post('/delete', 'ShopBannerController@deleteList')->name('admin_banner.delete');
});
