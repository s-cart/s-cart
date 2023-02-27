<?php
if (file_exists(app_path('Admin/Controllers/AdminStoreLinkGroupController.php'))) {
    $nameSpaceAdminBannerType = 'App\Admin\Controllers';
} else {
    $nameSpaceAdminBannerType = 'App\Pmo\Admin\Controllers';
}
Route::group(['prefix' => 'store_link_group'], function () use ($nameSpaceAdminBannerType) {
    Route::get('/', $nameSpaceAdminBannerType.'\AdminStoreLinkGroupController@index')->name('admin_store_link_group.index');
    Route::get('create', function () {
        return redirect()->route('admin_store_link_group.index');
    });
    Route::post('/create', $nameSpaceAdminBannerType.'\AdminStoreLinkGroupController@postCreate')->name('admin_store_link_group.create');
    Route::get('/edit/{id}', $nameSpaceAdminBannerType.'\AdminStoreLinkGroupController@edit')->name('admin_store_link_group.edit');
    Route::post('/edit/{id}', $nameSpaceAdminBannerType.'\AdminStoreLinkGroupController@postEdit')->name('admin_store_link_group.edit');
    Route::post('/delete', $nameSpaceAdminBannerType.'\AdminStoreLinkGroupController@deleteList')->name('admin_store_link_group.delete');
});