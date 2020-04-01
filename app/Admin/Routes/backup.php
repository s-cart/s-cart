<?php
$router->group(['prefix' => 'backup'], function ($router) {
    $router->get('/', 'AdminBackupController@index')->name('admin_backup.index');
    $router->post('generate', 'AdminBackupController@generateBackup')->name('admin.backup.generate');
    $router->post('process', 'AdminBackupController@processBackupFile')->name('admin.backup.process');
});
