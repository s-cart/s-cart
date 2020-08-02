<?php
$router->group(['prefix' => 'store'], function ($router) {
    $router->get('/', 'AdminStoreController@index')->name('admin_store.index');
    $router->post('/delete', 'AdminStoreController@deleteList')->name('admin_store.delete');
    $router->post('/update_info', 'AdminStoreController@updateInfo')->name('admin_store.update');
});
