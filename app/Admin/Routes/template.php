<?php
$router->group(['prefix' => 'template'], function ($router) {
    //Process import
        $router->get('/import', 'AdminTemplateController@importTemplate')
        ->name('admin_template.import');
    $router->post('/import', 'AdminTemplateController@processImport')
        ->name('admin_template.process_import');
    //End process

    $router->get('/', 'AdminTemplateController@index')->name('admin_template.index');
    $router->post('changeTemplate', 'AdminTemplateController@changeTemplate')->name('admin_template.changeTemplate');
    $router->post('remove', 'AdminTemplateController@remove')->name('admin_template.remove');

    if(config('scart.settings.api_template')) {
        $router->get('/online', 'AdminTemplateOnlineController@index')->name('admin_template_online.index');
        $router->post('/online/install', 'AdminTemplateOnlineController@install')
        ->name('admin_template_online.install');
    }

});
