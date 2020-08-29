<?php
$router->group(['prefix' => 'email'], function ($router) {
    $router->get('/', 'AdminEmailController@index')->name('admin_email.index');
    $router->post('/delete', 'AdminEmailController@deleteList')->name('admin_email.delete');
    $router->post('/update_info', 'AdminEmailController@updateInfo')->name('admin_email.update');
});
