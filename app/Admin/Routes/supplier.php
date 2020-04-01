<?php
$router->group(['prefix' => 'supplier'], function ($router) {
    $router->get('/', 'ShopSupplierController@index')->name('admin_supplier.index');
    $router->get('create', 'ShopSupplierController@create')->name('admin_supplier.create');
    $router->post('/create', 'ShopSupplierController@postCreate')->name('admin_supplier.create');
    $router->get('/edit/{id}', 'ShopSupplierController@edit')->name('admin_supplier.edit');
    $router->post('/edit/{id}', 'ShopSupplierController@postEdit')->name('admin_supplier.edit');
    $router->post('/delete', 'ShopSupplierController@deleteList')->name('admin_supplier.delete');
});
