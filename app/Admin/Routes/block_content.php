<?php
$router->group(['prefix' => 'block_content'], function ($router) {
    $router->get('/', 'ShopBlockContentController@index')->name('admin_block_content.index');
    $router->get('create', 'ShopBlockContentController@create')->name('admin_block_content.create');
    $router->post('/create', 'ShopBlockContentController@postCreate')->name('admin_block_content.create');
    $router->get('/edit/{id}', 'ShopBlockContentController@edit')->name('admin_block_content.edit');
    $router->post('/edit/{id}', 'ShopBlockContentController@postEdit')->name('admin_block_content.edit');
    $router->post('/delete', 'ShopBlockContentController@deleteList')->name('admin_block_content.delete');
});
