<?php
$router->group(['prefix' => 'template'], function ($router) {
    $router->get('/', 'AdminTemplateController@index')->name('admin_template.index');
    $router->post('changeTemplate', 'AdminTemplateController@changeTemplate')->name('admin_template.changeTemplate');
    $router->post('remove', 'AdminTemplateController@remove')->name('admin_template.remove');

    $router->get('/online', 'AdminTemplateOnlineController@index')->name('admin_template_online.index');
    $router->post('/online/install', 'AdminTemplateOnlineController@install')
    ->name('admin_template_online.install');
});
