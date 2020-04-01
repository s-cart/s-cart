<?php
$router->group(['prefix' => 'language'], function ($router) {
    $router->get('/', 'ShopLanguageController@index')->name('admin_language.index');
    $router->get('create', 'ShopLanguageController@create')->name('admin_language.create');
    $router->post('/create', 'ShopLanguageController@postCreate')->name('admin_language.create');
    $router->get('/edit/{id}', 'ShopLanguageController@edit')->name('admin_language.edit');
    $router->post('/edit/{id}', 'ShopLanguageController@postEdit')->name('admin_language.edit');
    $router->post('/delete', 'ShopLanguageController@deleteList')->name('admin_language.delete');
});
