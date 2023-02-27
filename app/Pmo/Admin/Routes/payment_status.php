<?php
if (file_exists(app_path('Admin/Controllers/AdminPaymentStatusController.php'))) {
    $nameSpaceAdminPaymentStatus = 'App\Admin\Controllers';
} else {
    $nameSpaceAdminPaymentStatus = 'App\Pmo\Admin\Controllers';
}
Route::group(['prefix' => 'payment_status'], function () use ($nameSpaceAdminPaymentStatus) {
    Route::get('/', $nameSpaceAdminPaymentStatus.'\AdminPaymentStatusController@index')->name('admin_payment_status.index');
    Route::get('create', function () {
        return redirect()->route('admin_payment_status.index');
    });
    Route::post('/create', $nameSpaceAdminPaymentStatus.'\AdminPaymentStatusController@postCreate')->name('admin_payment_status.create');
    Route::get('/edit/{id}', $nameSpaceAdminPaymentStatus.'\AdminPaymentStatusController@edit')->name('admin_payment_status.edit');
    Route::post('/edit/{id}', $nameSpaceAdminPaymentStatus.'\AdminPaymentStatusController@postEdit')->name('admin_payment_status.edit');
    Route::post('/delete', $nameSpaceAdminPaymentStatus.'\AdminPaymentStatusController@deleteList')->name('admin_payment_status.delete');
});