<?php
$router->group(['prefix' => 'product_config'], function ($router) {
    $router->get('/', 'AdminProductConfigController@index')->name('admin_product_config.index');
    $router->get('create', 'AdminProductConfigController@create')->name('admin_product_config.create');
    $router->post('/create', 'AdminProductConfigController@postCreate')->name('admin_product_config.create');
    $router->post('/ ', 'AdminProductConfigController@deleteList')->name('admin_product_config.delete');
    $router->post('/update_info', 'AdminProductConfigController@updateInfo')->name('admin_product_config.update');
});
