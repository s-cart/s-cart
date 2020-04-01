<?php
$router->group(['prefix' => 'menu'], function ($router) {
    $router->get('/', 'AdminMenuController@index')->name('admin_menu.index');
    $router->post('/create', 'AdminMenuController@postCreate')->name('admin_menu.create');
    $router->get('/edit/{id}', 'AdminMenuController@edit')->name('admin_menu.edit');
    $router->post('/edit/{id}', 'AdminMenuController@postEdit')->name('admin_menu.edit');
    $router->post('/delete', 'AdminMenuController@deleteList')->name('admin_menu.delete');
    $router->post('/update_sort', 'AdminMenuController@updateSort')->name('admin_menu.update_sort');
});
