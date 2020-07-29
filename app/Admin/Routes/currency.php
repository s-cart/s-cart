<?php
$router->group(['prefix' => 'currency'], function ($router) {
    $router->get('/', 'AdminCurrencyController@index')->name('admin_currency.index');
    $router->get('create', 'AdminCurrencyController@create')->name('admin_currency.create');
    $router->post('/create', 'AdminCurrencyController@postCreate')->name('admin_currency.create');
    $router->get('/edit/{id}', 'AdminCurrencyController@edit')->name('admin_currency.edit');
    $router->post('/edit/{id}', 'AdminCurrencyController@postEdit')->name('admin_currency.edit');
    $router->post('/delete', 'AdminCurrencyController@deleteList')->name('admin_currency.delete');
});
