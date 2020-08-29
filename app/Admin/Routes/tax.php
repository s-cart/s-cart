<?php
$router->group(['prefix' => 'tax'], function ($router) {
    $router->get('/', 'AdminTaxController@index')->name('admin_tax.index');
    $router->get('create', 'AdminTaxController@create')->name('admin_tax.create');
    $router->post('/create', 'AdminTaxController@postCreate')->name('admin_tax.create');
    $router->get('/edit/{id}', 'AdminTaxController@edit')->name('admin_tax.edit');
    $router->post('/edit/{id}', 'AdminTaxController@postEdit')->name('admin_tax.edit');
    $router->post('/delete', 'AdminTaxController@deleteList')->name('admin_tax.delete');
});
