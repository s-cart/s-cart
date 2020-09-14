<?php
$router->group(['prefix' => 'config_store_default'], function ($router) {
    $router->get('/', 'AdminConfigStoreDefaultController@index')->name('admin_config_store_default.index');
});
