<?php
$router->group(['prefix' => 'language'], function ($router) {
    $router->get('/', 'AdminLanguageController@index')->name('admin_language.index');
    $router->get('create', 'AdminLanguageController@create')->name('admin_language.create');
    $router->post('/create', 'AdminLanguageController@postCreate')->name('admin_language.create');
    $router->get('/edit/{id}', 'AdminLanguageController@edit')->name('admin_language.edit');
    $router->post('/edit/{id}', 'AdminLanguageController@postEdit')->name('admin_language.edit');
    $router->post('/delete', 'AdminLanguageController@deleteList')->name('admin_language.delete');
});
