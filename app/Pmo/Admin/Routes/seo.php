<?php
if (file_exists(app_path('Admin/Controllers/AdminSeoConfigController.php'))) {
    $nameSpaceAdminSeo = 'App\Admin\Controllers';
} else {
    $nameSpaceAdminSeo = 'App\Pmo\Admin\Controllers';
}
Route::group(['prefix' => 'seo'], function () use ($nameSpaceAdminSeo) {
    Route::get('/config', $nameSpaceAdminSeo.'\AdminSeoConfigController@index')->name('admin_seo.config');
});