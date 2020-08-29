<?php
$router->group(['prefix' => 'weight_unit'], function ($router) {
    $router->get('/', 'AdminWeightController@index')->name('admin_weight_unit.index');
    $router->get('create', 'AdminWeightController@create')->name('admin_weight_unit.create');
    $router->post('/create', 'AdminWeightController@postCreate')->name('admin_weight_unit.create');
    $router->get('/edit/{id}', 'AdminWeightController@edit')->name('admin_weight_unit.edit');
    $router->post('/edit/{id}', 'AdminWeightController@postEdit')->name('admin_weight_unit.edit');
    $router->post('/delete', 'AdminWeightController@deleteList')->name('admin_weight_unit.delete');
});
