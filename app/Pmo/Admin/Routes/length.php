<?php
if (file_exists(app_path('Admin/Controllers/AdminLengthController.php'))) {
    $nameSpaceAdminLength = 'App\Admin\Controllers';
} else {
    $nameSpaceAdminLength = 'App\Pmo\Admin\Controllers';
}
Route::group(['prefix' => 'length_unit'], function () use ($nameSpaceAdminLength) {
    Route::get('/', $nameSpaceAdminLength.'\AdminLengthController@index')->name('admin_length_unit.index');
    Route::get('create', function () {
        return redirect()->route('admin_length_unit.index');
    });
    Route::post('/create', $nameSpaceAdminLength.'\AdminLengthController@postCreate')->name('admin_length_unit.create');
    Route::get('/edit/{id}', $nameSpaceAdminLength.'\AdminLengthController@edit')->name('admin_length_unit.edit');
    Route::post('/edit/{id}', $nameSpaceAdminLength.'\AdminLengthController@postEdit')->name('admin_length_unit.edit');
    Route::post('/delete', $nameSpaceAdminLength.'\AdminLengthController@deleteList')->name('admin_length_unit.delete');
});