<?php
$router->group(['prefix' => 'length_unit'], function ($router) {
    $router->get('/', 'ShopLengthController@index')->name('admin_length_unit.index');
    $router->get('create', 'ShopLengthController@create')->name('admin_length_unit.create');
    $router->post('/create', 'ShopLengthController@postCreate')->name('admin_length_unit.create');
    $router->get('/edit/{id}', 'ShopLengthController@edit')->name('admin_length_unit.edit');
    $router->post('/edit/{id}', 'ShopLengthController@postEdit')->name('admin_length_unit.edit');
    $router->post('/delete', 'ShopLengthController@deleteList')->name('admin_length_unit.delete');
});
