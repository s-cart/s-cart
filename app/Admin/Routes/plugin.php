<?php
$router->group(['prefix' => 'plugin'], function ($router) {
    //Process import
    $router->get('/import', 'AdminPluginsController@importPlugin')
        ->name('admin_plugin.import');
    $router->post('/import', 'AdminPluginsController@processImport')
        ->name('admin_plugin.process_import');
    //End process
    
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

    if(config('scart.settings.api_plugin')) {
        $router->get('/{code}/online', 'AdminPluginsOnlineController@index')
        ->name('admin_plugin_online');
        $router->post('/install/online', 'AdminPluginsOnlineController@install')
            ->name('admin_plugin_online.install');
    }
});
