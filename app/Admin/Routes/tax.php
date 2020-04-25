<?php
$router->group(['prefix' => 'tax'], function ($router) {
    $router->get('/', 'ShopTaxController@index')->name('admin_tax.index');
    $router->get('create', 'ShopTaxController@create')->name('admin_tax.create');
    $router->post('/create', 'ShopTaxController@postCreate')->name('admin_tax.create');
    $router->get('/edit/{id}', 'ShopTaxController@edit')->name('admin_tax.edit');
    $router->post('/edit/{id}', 'ShopTaxController@postEdit')->name('admin_tax.edit');
    $router->post('/delete', 'ShopTaxController@deleteList')->name('admin_tax.delete');
});
