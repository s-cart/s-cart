<?php
$router->group(['prefix' => 'plugin'], function ($router) {
    $router->get('/{code}', 'AdminPluginsController@index')
        ->name('admin_plugin');
    $router->post('/install', 'AdminPluginsController@install')
        ->name('admin_plugin.install');
    $router->post('/uninstall', 'AdminPluginsController@uninstall')
        ->name('admin_plugin.uninstall');
    $router->post('/enable', 'AdminPluginsController@enable')
        ->name('admin_plugin.enable');
    $router->post('/disable', 'AdminPluginsController@disable')
        ->name('admin_plugin.disable');
    $router->match(['put', 'post'], '/process/{code}/{key}', 'AdminPluginsController@process')
        ->name('admin_plugin.process');

    $router->get('/{code}/online', 'AdminPluginsOnlineController@index')
        ->name('admin_plugin_online');
    $router->post('/install/online', 'AdminPluginsOnlineController@install')
        ->name('admin_plugin_online.install');
});
