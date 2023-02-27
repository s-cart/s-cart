<?php
if (file_exists(app_path('Admin/Controllers/AdminProductPropertyController.php'))) {
    $nameSpaceAdminProductProperty = 'App\Admin\Controllers';
} else {
    $nameSpaceAdminProductProperty = 'App\Pmo\Admin\Controllers';
}
Route::group(['prefix' => 'product_property'], function () use ($nameSpaceAdminProductProperty) {
    Route::get('/', $nameSpaceAdminProductProperty.'\AdminProductPropertyController@index')->name('admin_product_property.index');
    Route::get('create', function () {
        return redirect()->route('admin_product_property.index');
    });
    Route::post('/create', $nameSpaceAdminProductProperty.'\AdminProductPropertyController@postCreate')->name('admin_product_property.create');
    Route::get('/edit/{id}', $nameSpaceAdminProductProperty.'\AdminProductPropertyController@edit')->name('admin_product_property.edit');
    Route::post('/edit/{id}', $nameSpaceAdminProductProperty.'\AdminProductPropertyController@postEdit')->name('admin_product_property.edit');
    Route::post('/delete', $nameSpaceAdminProductProperty.'\AdminProductPropertyController@deleteList')->name('admin_product_property.delete');
});