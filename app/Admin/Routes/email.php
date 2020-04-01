<?php
$router->group(['prefix' => 'email'], function ($router) {
    $router->get('/', 'ShopEmailController@index')->name('admin_email.index');
    $router->post('/delete', 'ShopEmailController@deleteList')->name('admin_email.delete');
    $router->post('/update_info', 'ShopEmailController@updateInfo')->name('admin_email.update');
});
