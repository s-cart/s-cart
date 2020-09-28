<?php
$router->group(['prefix' => 'store'], function ($router) {
    $router->get('/', 'AdminStoreController@index')->name('admin_store.index');  
    $router->post('/update_info', 'AdminStoreController@updateInfo')->name('admin_store.update');
    $router->get('/process/{storeId}', function ($storeId) {
        session(['adminStoreId' => $storeId]);
        return back();
    })->name('admin_store.process');
});
