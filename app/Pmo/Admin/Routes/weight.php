<?php
if (file_exists(app_path('Admin/Controllers/AdminWeightController.php'))) {
    $nameSpaceAdminWeight = 'App\Admin\Controllers';
} else {
    $nameSpaceAdminWeight = 'App\Pmo\Admin\Controllers';
}
Route::group(['prefix' => 'weight_unit'], function () use ($nameSpaceAdminWeight) {
    Route::get('/', $nameSpaceAdminWeight.'\AdminWeightController@index')->name('admin_weight_unit.index');
    Route::get('create', function () {
        return redirect()->route('admin_weight_unit.index');
    });
    Route::post('/create', $nameSpaceAdminWeight.'\AdminWeightController@postCreate')->name('admin_weight_unit.create');
    Route::get('/edit/{id}', $nameSpaceAdminWeight.'\AdminWeightController@edit')->name('admin_weight_unit.edit');
    Route::post('/edit/{id}', $nameSpaceAdminWeight.'\AdminWeightController@postEdit')->name('admin_weight_unit.edit');
    Route::post('/delete', $nameSpaceAdminWeight.'\AdminWeightController@deleteList')->name('admin_weight_unit.delete');
});