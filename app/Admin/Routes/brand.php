<?php
$router->group(['prefix' => 'brand'], function ($router) {
    $router->get('/', 'ShopBrandController@index')->name('admin_brand.index');
    $router->get('create', 'ShopBrandController@create')->name('admin_brand.create');
    $router->post('/create', 'ShopBrandController@postCreate')->name('admin_brand.create');
    $router->get('/edit/{id}', 'ShopBrandController@edit')->name('admin_brand.edit');
    $router->post('/edit/{id}', 'ShopBrandController@postEdit')->name('admin_brand.edit');
    $router->post('/delete', 'ShopBrandController@deleteList')->name('admin_brand.delete');
});
