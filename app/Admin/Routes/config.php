<?php
$router->group(['prefix' => 'config'], function ($router) {
    $router->get('/webhook', 'AdminConfigController@webhook')->name('admin_config.webhook');
    $router->post('/update_info', 'AdminConfigController@updateInfo')->name('admin_config.update');
});
