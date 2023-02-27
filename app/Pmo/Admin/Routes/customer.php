<?php
if (file_exists(app_path('Admin/Controllers/AdminCustomerController.php'))) {
    $nameSpaceAdminCustomer = 'App\Admin\Controllers';
} else {
    $nameSpaceAdminCustomer = 'App\Pmo\Admin\Controllers';
}
Route::group(['prefix' => 'customer'], function () use ($nameSpaceAdminCustomer) {
    Route::get('/', $nameSpaceAdminCustomer.'\AdminCustomerController@index')->name('admin_customer.index');
    Route::get('create', $nameSpaceAdminCustomer.'\AdminCustomerController@create')->name('admin_customer.create');
    Route::post('/create', $nameSpaceAdminCustomer.'\AdminCustomerController@postCreate')->name('admin_customer.create');
    Route::get('/edit/{id}', $nameSpaceAdminCustomer.'\AdminCustomerController@edit')->name('admin_customer.edit');
    Route::post('/edit/{id}', $nameSpaceAdminCustomer.'\AdminCustomerController@postEdit')->name('admin_customer.edit');
    Route::post('/delete', $nameSpaceAdminCustomer.'\AdminCustomerController@deleteList')->name('admin_customer.delete');
    Route::get('/update-address/{id}', $nameSpaceAdminCustomer.'\AdminCustomerController@updateAddress')->name('admin_customer.update_address');
    Route::post('/update-address/{id}', $nameSpaceAdminCustomer.'\AdminCustomerController@postUpdateAddress')->name('admin_customer.post_update_address');
    Route::post('/delete-address', $nameSpaceAdminCustomer.'\AdminCustomerController@deleteAddress')->name('admin_customer.delete_address');
});