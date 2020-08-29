<?php
$router->group(['prefix' => 'page'], function ($router) {
    $router->get('/', 'AdminPageController@index')->name('admin_page.index');
    $router->get('create', 'AdminPageController@create')->name('admin_page.create');
    $router->post('/create', 'AdminPageController@postCreate')->name('admin_page.create');
    $router->get('/edit/{id}', 'AdminPageController@edit')->name('admin_page.edit');
    $router->post('/edit/{id}', 'AdminPageController@postEdit')->name('admin_page.edit');
    $router->post('/delete', 'AdminPageController@deleteList')->name('admin_page.delete');
});
//=Page
