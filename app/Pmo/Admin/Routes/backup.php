<?php
if (file_exists(app_path('Admin/Controllers/AdminBackupController.php'))) {
    $nameSpaceAdminBackup = 'App\Admin\Controllers';
} else {
    $nameSpaceAdminBackup = 'App\Pmo\Admin\Controllers';
}
Route::group(['prefix' => 'backup'], function () use ($nameSpaceAdminBackup) {
    Route::get('/', $nameSpaceAdminBackup.'\AdminBackupController@index')->name('admin_backup.index');
    Route::post('generate', $nameSpaceAdminBackup.'\AdminBackupController@generateBackup')->name('admin.backup.generate');
    Route::post('process', $nameSpaceAdminBackup.'\AdminBackupController@processBackupFile')->name('admin.backup.process');
});