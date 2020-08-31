<?php
$router->group(['prefix' => 'store'], function ($router) {
    $router->get('/', 'AdminStoreController@index')->name('admin_store.index');
    $router->post('/delete', 'AdminStoreController@delete')->name('admin_store.delete');
    $router->post('/update_info', 'AdminStoreController@updateInfo')->name('admin_store.update');
    $router->get('config/{id}', 'AdminStoreController@config')->name('admin_store.config');
    $router->get('create', 'AdminStoreController@create')->name('admin_store.create');
    $router->post('/create', 'AdminStoreController@postCreate')->name('admin_store.create');
});
