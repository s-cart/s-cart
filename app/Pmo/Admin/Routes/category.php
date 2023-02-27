<?php
if (file_exists(app_path('Admin/Controllers/AdminCategoryController.php'))) {
    $nameSpaceAdminCategory = 'App\Admin\Controllers';
} else {
    $nameSpaceAdminCategory = 'App\Pmo\Admin\Controllers';
}
Route::group(['prefix' => 'category'], function () use ($nameSpaceAdminCategory) {
    Route::get('/', $nameSpaceAdminCategory.'\AdminCategoryController@index')->name('admin_category.index');
    Route::get('create', $nameSpaceAdminCategory.'\AdminCategoryController@create')->name('admin_category.create');
    Route::post('/create', $nameSpaceAdminCategory.'\AdminCategoryController@postCreate')->name('admin_category.create');
    Route::get('/edit/{id}', $nameSpaceAdminCategory.'\AdminCategoryController@edit')->name('admin_category.edit');
    Route::post('/edit/{id}', $nameSpaceAdminCategory.'\AdminCategoryController@postEdit')->name('admin_category.edit');
    Route::post('/delete', $nameSpaceAdminCategory.'\AdminCategoryController@deleteList')->name('admin_category.delete');
});