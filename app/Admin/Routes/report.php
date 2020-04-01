<?php
$router->group(['prefix' => 'report'], function ($router) {
    $router->get('/product', 'AdminReportController@product')->name('admin_report.product');
});
