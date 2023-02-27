<?php
if (file_exists(app_path('Admin/Controllers/AdminStoreMaintainController.php'))) {
    $nameSpaceAdminStoreMaintain = 'App\Admin\Controllers';
} else {
    $nameSpaceAdminStoreMaintain = 'App\Pmo\Admin\Controllers';
}
Route::group(['prefix' => 'store_maintain'], function () use ($nameSpaceAdminStoreMaintain) {
    Route::get('/', $nameSpaceAdminStoreMaintain.'\AdminStoreMaintainController@index')->name('admin_store_maintain.index');
    Route::post('/', $nameSpaceAdminStoreMaintain.'\AdminStoreMaintainController@postEdit');
});
