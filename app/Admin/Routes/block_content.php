<?php
$router->group(['prefix' => 'block_content'], function ($router) {
    $router->get('/', 'AdminBlockContentController@index')->name('admin_block_content.index');
    $router->get('create', 'AdminBlockContentController@create')->name('admin_block_content.create');
    $router->post('/create', 'AdminBlockContentController@postCreate')->name('admin_block_content.create');
    $router->get('/edit/{id}', 'AdminBlockContentController@edit')->name('admin_block_content.edit');
    $router->post('/edit/{id}', 'AdminBlockContentController@postEdit')->name('admin_block_content.edit');
    $router->post('/delete', 'AdminBlockContentController@deleteList')->name('admin_block_content.delete');
});
