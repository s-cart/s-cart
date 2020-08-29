<?php
$router->group(['prefix' => 'order'], function ($router) {
    $router->get('/', 'AdminOrderController@index')->name('admin_order.index');
    $router->get('/detail/{id}', 'AdminOrderController@detail')->name('admin_order.detail');
    $router->get('create', 'AdminOrderController@create')->name('admin_order.create');
    $router->post('/create', 'AdminOrderController@postCreate')->name('admin_order.create');
    $router->post('/add_item', 'AdminOrderController@postAddItem')->name('admin_order.add_item');
    $router->post('/edit_item', 'AdminOrderController@postEditItem')->name('admin_order.edit_item');
    $router->post('/delete_item', 'AdminOrderController@postDeleteItem')->name('admin_order.delete_item');
    $router->post('/update', 'AdminOrderController@postOrderUpdate')->name('admin_order.update');
    $router->post('/delete', 'AdminOrderController@deleteList')->name('admin_order.delete');
    $router->get('/product_info', 'AdminOrderController@getInfoProduct')->name('admin_order.product_info');
    $router->get('/user_info', 'AdminOrderController@getInfoUser')->name('admin_order.user_info');
    $router->get('/export_detail', 'AdminOrderController@exportDetail')->name('admin_order.export_detail');

});
