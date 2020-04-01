<?php
$router->group(['prefix' => 'currency'], function ($router) {
    $router->get('/', 'ShopCurrencyController@index')->name('admin_currency.index');
    $router->get('create', 'ShopCurrencyController@create')->name('admin_currency.create');
    $router->post('/create', 'ShopCurrencyController@postCreate')->name('admin_currency.create');
    $router->get('/edit/{id}', 'ShopCurrencyController@edit')->name('admin_currency.edit');
    $router->post('/edit/{id}', 'ShopCurrencyController@postEdit')->name('admin_currency.edit');
    $router->post('/delete', 'ShopCurrencyController@deleteList')->name('admin_currency.delete');
});
