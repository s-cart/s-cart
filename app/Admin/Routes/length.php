<?php
$router->group(['prefix' => 'length_unit'], function ($router) {
    $router->get('/', 'AdminLengthController@index')->name('admin_length_unit.index');
    $router->get('create', 'AdminLengthController@create')->name('admin_length_unit.create');
    $router->post('/create', 'AdminLengthController@postCreate')->name('admin_length_unit.create');
    $router->get('/edit/{id}', 'AdminLengthController@edit')->name('admin_length_unit.edit');
    $router->post('/edit/{id}', 'AdminLengthController@postEdit')->name('admin_length_unit.edit');
    $router->post('/delete', 'AdminLengthController@deleteList')->name('admin_length_unit.delete');
});
