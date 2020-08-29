<?php
$router->group(['prefix' => 'product'], function ($router) {
    $router->get('/', 'AdminProductController@index')->name('admin_product.index');
    $router->get('create', 'AdminProductController@create')->name('admin_product.create');
    $router->post('/create', 'AdminProductController@postCreate')->name('admin_product.create');
    $router->get('/edit/{id}', 'AdminProductController@edit')->name('admin_product.edit');
    $router->post('/edit/{id}', 'AdminProductController@postEdit')->name('admin_product.edit');
    $router->post('/delete', 'AdminProductController@deleteList')->name('admin_product.delete');
    $router->get('/import', 'AdminProductController@import')->name('admin_product.import');
    $router->post('/import', 'AdminProductController@postImport')->name('admin_product.import');
});
