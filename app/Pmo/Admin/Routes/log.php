<?php
if (file_exists(app_path('Admin/Controllers/AdminLogController.php'))) {
    $nameSpaceAdminLog = 'App\Admin\Controllers';
} else {
    $nameSpaceAdminLog = 'App\Pmo\Admin\Controllers';
}
Route::group(['prefix' => 'log'], function () use ($nameSpaceAdminLog) {
    Route::get('/', $nameSpaceAdminLog.'\AdminLogController@index')->name('admin_log.index');
    Route::post('/delete', $nameSpaceAdminLog.'\AdminLogController@deleteList')->name('admin_log.delete');
});