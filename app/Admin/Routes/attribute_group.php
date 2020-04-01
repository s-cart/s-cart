<?php
$router->group(['prefix' => 'attribute_group'], function ($router) {
    $router->get('/', 'ShopAttributeGroupController@index')->name('admin_attribute_group.index');
    $router->get('create', 'ShopAttributeGroupController@create')->name('admin_attribute_group.create');
    $router->post('/create', 'ShopAttributeGroupController@postCreate')->name('admin_attribute_group.create');
    $router->get('/edit/{id}', 'ShopAttributeGroupController@edit')->name('admin_attribute_group.edit');
    $router->post('/edit/{id}', 'ShopAttributeGroupController@postEdit')->name('admin_attribute_group.edit');
    $router->post('/delete', 'ShopAttributeGroupController@deleteList')->name('admin_attribute_group.delete');
});
