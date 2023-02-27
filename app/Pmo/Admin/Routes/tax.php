<?php
if (file_exists(app_path('Admin/Controllers/AdminTaxController.php'))) {
    $nameSpaceAdminTax = 'App\Admin\Controllers';
} else {
    $nameSpaceAdminTax = 'App\Pmo\Admin\Controllers';
}
Route::group(['prefix' => 'tax'], function () use ($nameSpaceAdminTax) {
    Route::get('/', $nameSpaceAdminTax.'\AdminTaxController@index')->name('admin_tax.index');
    Route::get('create', function () {
        return redirect()->route('admin_tax.index');
    });
    Route::post('/create', $nameSpaceAdminTax.'\AdminTaxController@postCreate')->name('admin_tax.create');
    Route::get('/edit/{id}', $nameSpaceAdminTax.'\AdminTaxController@edit')->name('admin_tax.edit');
    Route::post('/edit/{id}', $nameSpaceAdminTax.'\AdminTaxController@postEdit')->name('admin_tax.edit');
    Route::post('/delete', $nameSpaceAdminTax.'\AdminTaxController@deleteList')->name('admin_tax.delete');
});