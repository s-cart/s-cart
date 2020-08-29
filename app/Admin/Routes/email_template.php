<?php
$router->group(['prefix' => 'email_template'], function ($router) {
    $router->get('/', 'AdminEmailTemplateController@index')->name('admin_email_template.index');
    $router->get('create', 'AdminEmailTemplateController@create')->name('admin_email_template.create');
    $router->post('/create', 'AdminEmailTemplateController@postCreate')->name('admin_email_template.create');
    $router->get('/edit/{id}', 'AdminEmailTemplateController@edit')->name('admin_email_template.edit');
    $router->post('/edit/{id}', 'AdminEmailTemplateController@postEdit')->name('admin_email_template.edit');
    $router->post('/delete', 'AdminEmailTemplateController@deleteList')->name('admin_email_template.delete');
    $router->get('/list_variable', 'AdminEmailTemplateController@listVariable')->name('admin_email_template.list_variable');
});
