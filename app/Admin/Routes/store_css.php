<?php
$router->group(['prefix' => 'store_css'], function ($router) {
    $router->get('/', 'AdminStoreCssController@index')->name('admin_store_css.index');
    $router->post('/', 'AdminStoreCssController@postEdit');
});
