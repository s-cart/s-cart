<?php
$router->group(['prefix' => 'attribute_group'], function ($router) {
    $router->get('/', 'AdminAttributeGroupController@index')->name('admin_attribute_group.index');
    $router->get('create', 'AdminAttributeGroupController@create')->name('admin_attribute_group.create');
    $router->post('/create', 'AdminAttributeGroupController@postCreate')->name('admin_attribute_group.create');
    $router->get('/edit/{id}', 'AdminAttributeGroupController@edit')->name('admin_attribute_group.edit');
    $router->post('/edit/{id}', 'AdminAttributeGroupController@postEdit')->name('admin_attribute_group.edit');
    $router->post('/delete', 'AdminAttributeGroupController@deleteList')->name('admin_attribute_group.delete');
});
