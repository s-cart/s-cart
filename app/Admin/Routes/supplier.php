<?php
$router->group(['prefix' => 'supplier'], function ($router) {
    $router->get('/', 'AdminSupplierController@index')->name('admin_supplier.index');
    $router->get('create', 'AdminSupplierController@create')->name('admin_supplier.create');
    $router->post('/create', 'AdminSupplierController@postCreate')->name('admin_supplier.create');
    $router->get('/edit/{id}', 'AdminSupplierController@edit')->name('admin_supplier.edit');
    $router->post('/edit/{id}', 'AdminSupplierController@postEdit')->name('admin_supplier.edit');
    $router->post('/delete', 'AdminSupplierController@deleteList')->name('admin_supplier.delete');
});
