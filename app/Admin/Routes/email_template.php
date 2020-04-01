<?php
$router->group(['prefix' => 'email_template'], function ($router) {
    $router->get('/', 'ShopEmailTemplateController@index')->name('admin_email_template.index');
    $router->get('create', 'ShopEmailTemplateController@create')->name('admin_email_template.create');
    $router->post('/create', 'ShopEmailTemplateController@postCreate')->name('admin_email_template.create');
    $router->get('/edit/{id}', 'ShopEmailTemplateController@edit')->name('admin_email_template.edit');
    $router->post('/edit/{id}', 'ShopEmailTemplateController@postEdit')->name('admin_email_template.edit');
    $router->post('/delete', 'ShopEmailTemplateController@deleteList')->name('admin_email_template.delete');
    $router->get('/list_variable', 'ShopEmailTemplateController@listVariable')->name('admin_email_template.list_variable');
});
