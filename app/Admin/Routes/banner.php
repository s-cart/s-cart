<?php
$router->group(['prefix' => 'banner'], function ($router) {
    $router->get('/', 'AdminBannerController@index')->name('admin_banner.index');
    $router->get('create', 'AdminBannerController@create')->name('admin_banner.create');
    $router->post('/create', 'AdminBannerController@postCreate')->name('admin_banner.create');
    $router->get('/edit/{id}', 'AdminBannerController@edit')->name('admin_banner.edit');
    $router->post('/edit/{id}', 'AdminBannerController@postEdit')->name('admin_banner.edit');
    $router->post('/delete', 'AdminBannerController@deleteList')->name('admin_banner.delete');
});
