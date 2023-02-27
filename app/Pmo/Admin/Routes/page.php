<?php
if (file_exists(app_path('Admin/Controllers/AdminPageController.php'))) {
    $nameSpaceAdminPage = 'App\Admin\Controllers';
} else {
    $nameSpaceAdminPage = 'App\Pmo\Admin\Controllers';
}
Route::group(['prefix' => 'page'], function () use ($nameSpaceAdminPage) {
    Route::get('/', $nameSpaceAdminPage.'\AdminPageController@index')->name('admin_page.index');
    Route::get('create', $nameSpaceAdminPage.'\AdminPageController@create')->name('admin_page.create');
    Route::post('/create', $nameSpaceAdminPage.'\AdminPageController@postCreate')->name('admin_page.create');
    Route::get('/edit/{id}', $nameSpaceAdminPage.'\AdminPageController@edit')->name('admin_page.edit');
    Route::post('/edit/{id}', $nameSpaceAdminPage.'\AdminPageController@postEdit')->name('admin_page.edit');
    Route::post('/delete', $nameSpaceAdminPage.'\AdminPageController@deleteList')->name('admin_page.delete');
});