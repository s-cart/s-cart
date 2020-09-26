<?php
$router->group(['prefix' => 'store_config'], function ($router) {
    $router->get('/', 'AdminStoreConfigController@index')->name('store_config.index');
});
