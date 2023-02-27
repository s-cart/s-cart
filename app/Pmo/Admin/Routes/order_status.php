<?php
if (file_exists(app_path('Admin/Controllers/AdminOrderStatusController.php'))) {
    $nameSpaceAdminOrderStatus = 'App\Admin\Controllers';
} else {
    $nameSpaceAdminOrderStatus = 'App\Pmo\Admin\Controllers';
}
Route::group(['prefix' => 'order_status'], function () use ($nameSpaceAdminOrderStatus) {
    Route::get('/', $nameSpaceAdminOrderStatus.'\AdminOrderStatusController@index')->name('admin_order_status.index');
    Route::get('create', function () {
        return redirect()->route('admin_order_status.index');
    });
    Route::post('/create', $nameSpaceAdminOrderStatus.'\AdminOrderStatusController@postCreate')->name('admin_order_status.create');
    Route::get('/edit/{id}', $nameSpaceAdminOrderStatus.'\AdminOrderStatusController@edit')->name('admin_order_status.edit');
    Route::post('/edit/{id}', $nameSpaceAdminOrderStatus.'\AdminOrderStatusController@postEdit')->name('admin_order_status.edit');
    Route::post('/delete', $nameSpaceAdminOrderStatus.'\AdminOrderStatusController@deleteList')->name('admin_order_status.delete');
});