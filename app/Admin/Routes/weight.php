<?php
$router->group(['prefix' => 'weight_unit'], function ($router) {
    $router->get('/', 'ShopWeightController@index')->name('admin_weight_unit.index');
    $router->get('create', 'ShopWeightController@create')->name('admin_weight_unit.create');
    $router->post('/create', 'ShopWeightController@postCreate')->name('admin_weight_unit.create');
    $router->get('/edit/{id}', 'ShopWeightController@edit')->name('admin_weight_unit.edit');
    $router->post('/edit/{id}', 'ShopWeightController@postEdit')->name('admin_weight_unit.edit');
    $router->post('/delete', 'ShopWeightController@deleteList')->name('admin_weight_unit.delete');
});
