<?php
$router->group(['prefix' => 'log'], function ($router) {
    $router->get('/', 'AdminLogController@index')->name('admin_log.index');
    $router->post('/delete', 'AdminLogController@deleteList')->name('admin_log.delete');
});
