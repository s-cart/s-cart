<?php
$router->group(['prefix' => 'category'], function ($router) {
    $router->get('/', 'AdminCategoryController@index')->name('admin_category.index');
    $router->get('create', 'AdminCategoryController@create')->name('admin_category.create');
    $router->post('/create', 'AdminCategoryController@postCreate')->name('admin_category.create');
    $router->get('/edit/{id}', 'AdminCategoryController@edit')->name('admin_category.edit');
    $router->post('/edit/{id}', 'AdminCategoryController@postEdit')->name('admin_category.edit');
    $router->post('/delete', 'AdminCategoryController@deleteList')->name('admin_category.delete');
});
