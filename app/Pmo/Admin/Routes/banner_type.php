<?php
if (file_exists(app_path('Admin/Controllers/AdminBannerTypeController.php'))) {
    $nameSpaceAdminBannerType = 'App\Admin\Controllers';
} else {
    $nameSpaceAdminBannerType = 'App\Pmo\Admin\Controllers';
}
Route::group(['prefix' => 'banner_type'], function () use ($nameSpaceAdminBannerType) {
    Route::get('/', $nameSpaceAdminBannerType.'\AdminBannerTypeController@index')->name('admin_banner_type.index');
    Route::get('create', function () {
        return redirect()->route('admin_banner_type.index');
    });
    Route::post('/create', $nameSpaceAdminBannerType.'\AdminBannerTypeController@postCreate')->name('admin_banner_type.create');
    Route::get('/edit/{id}', $nameSpaceAdminBannerType.'\AdminBannerTypeController@edit')->name('admin_banner_type.edit');
    Route::post('/edit/{id}', $nameSpaceAdminBannerType.'\AdminBannerTypeController@postEdit')->name('admin_banner_type.edit');
    Route::post('/delete', $nameSpaceAdminBannerType.'\AdminBannerTypeController@deleteList')->name('admin_banner_type.delete');
});