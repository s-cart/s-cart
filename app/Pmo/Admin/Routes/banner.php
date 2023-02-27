<?php
if (file_exists(app_path('Admin/Controllers/AdminBannerController.php'))) {
    $nameSpaceAdminBanner = 'App\Admin\Controllers';
} else {
    $nameSpaceAdminBanner = 'App\Pmo\Admin\Controllers';
}
Route::group(['prefix' => 'banner'], function () use ($nameSpaceAdminBanner) {
    Route::get('/', $nameSpaceAdminBanner.'\AdminBannerController@index')->name('admin_banner.index');
    Route::get('create', $nameSpaceAdminBanner.'\AdminBannerController@create')->name('admin_banner.create');
    Route::post('/create', $nameSpaceAdminBanner.'\AdminBannerController@postCreate')->name('admin_banner.create');
    Route::get('/edit/{id}', $nameSpaceAdminBanner.'\AdminBannerController@edit')->name('admin_banner.edit');
    Route::post('/edit/{id}', $nameSpaceAdminBanner.'\AdminBannerController@postEdit')->name('admin_banner.edit');
    Route::post('/delete', $nameSpaceAdminBanner.'\AdminBannerController@deleteList')->name('admin_banner.delete');
});