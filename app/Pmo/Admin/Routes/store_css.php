<?php
if (file_exists(app_path('Admin/Controllers/AdminStoreCssController.php'))) {
    $nameSpaceAdminStoreCss = 'App\Admin\Controllers';
} else {
    $nameSpaceAdminStoreCss = 'App\Pmo\Admin\Controllers';
}
Route::group(['prefix' => 'store_css'], function () use ($nameSpaceAdminStoreCss) {
    Route::get('/', $nameSpaceAdminStoreCss.'\AdminStoreCssController@index')->name('admin_store_css.index');
    Route::post('/', $nameSpaceAdminStoreCss.'\AdminStoreCssController@postEdit');
});