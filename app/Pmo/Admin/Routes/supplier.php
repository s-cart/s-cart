<?php
if (file_exists(app_path('Admin/Controllers/AdminSupplierController.php'))) {
    $nameSpaceAdminSupplier = 'App\Admin\Controllers';
} else {
    $nameSpaceAdminSupplier = 'App\Pmo\Admin\Controllers';
}
Route::group(['prefix' => 'supplier'], function () use ($nameSpaceAdminSupplier) {
    Route::get('/', $nameSpaceAdminSupplier.'\AdminSupplierController@index')->name('admin_supplier.index');
    Route::get('create', function () {
        return redirect()->route('admin_supplier.index');
    });
    Route::post('/create', $nameSpaceAdminSupplier.'\AdminSupplierController@postCreate')->name('admin_supplier.create');
    Route::get('/edit/{id}', $nameSpaceAdminSupplier.'\AdminSupplierController@edit')->name('admin_supplier.edit');
    Route::post('/edit/{id}', $nameSpaceAdminSupplier.'\AdminSupplierController@postEdit')->name('admin_supplier.edit');
    Route::post('/delete', $nameSpaceAdminSupplier.'\AdminSupplierController@deleteList')->name('admin_supplier.delete');
});