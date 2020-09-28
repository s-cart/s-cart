<?php
$router->group(['prefix' => 'cache_config'], function ($router) {
    $router->get('/', 'AdminCacheConfigController@index')->name('admin_cache_config.index');
    $router->post('/clear_cache', 'AdminCacheConfigController@clearCache')->name('admin_cache_config.clear_cache');
});
