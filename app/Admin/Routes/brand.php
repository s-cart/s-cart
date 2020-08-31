<?php
$router->group(['prefix' => 'brand'], function ($router) {
    $router->get('/', 'AdminBrandController@index')->name('admin_brand.index');
    $router->get('create', 'AdminBrandController@create')->name('admin_brand.create');
    $router->post('/create', 'AdminBrandController@postCreate')->name('admin_brand.create');
    $router->get('/edit/{id}', 'AdminBrandController@edit')->name('admin_brand.edit');
    $router->post('/edit/{id}', 'AdminBrandController@postEdit')->name('admin_brand.edit');
    $router->post('/delete', 'AdminBrandController@deleteList')->name('admin_brand.delete');
});
