<?php
$router->group(['prefix' => 'category'], function ($router) {
    $router->get('/', 'ShopCategoryController@index')->name('admin_category.index');
    $router->get('create', 'ShopCategoryController@create')->name('admin_category.create');
    $router->post('/create', 'ShopCategoryController@postCreate')->name('admin_category.create');
    $router->get('/edit/{id}', 'ShopCategoryController@edit')->name('admin_category.edit');
    $router->post('/edit/{id}', 'ShopCategoryController@postEdit')->name('admin_category.edit');
    $router->post('/delete', 'ShopCategoryController@deleteList')->name('admin_category.delete');
});
