<?php
$router->group(['prefix' => 'store_info'], function ($router) {
    $router->get('/', 'AdminStoreInfoController@index')->name('admin_store_info.index');
    $router->post('/delete', 'AdminStoreInfoController@deleteList')->name('admin_store_info.delete');
    $router->post('/update_info', 'AdminStoreInfoController@updateInfo')->name('admin_store_info.update');
});
