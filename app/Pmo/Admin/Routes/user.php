<?php
if (file_exists(app_path('Admin/Controllers/Auth/UsersController.php'))) {
    $nameSpaceAdminUser = 'App\Admin\Controllers';
} else {
    $nameSpaceAdminUser = 'App\Pmo\Admin\Controllers';
}
Route::group(['prefix' => 'user'], function () use ($nameSpaceAdminUser) {
    Route::get('/', $nameSpaceAdminUser.'\Auth\UsersController@index')->name('admin_user.index');
    Route::get('create', $nameSpaceAdminUser.'\Auth\UsersController@create')->name('admin_user.create');
    Route::post('/create', $nameSpaceAdminUser.'\Auth\UsersController@postCreate')->name('admin_user.create');
    Route::get('/edit/{id}', $nameSpaceAdminUser.'\Auth\UsersController@edit')->name('admin_user.edit');
    Route::post('/edit/{id}', $nameSpaceAdminUser.'\Auth\UsersController@postEdit')->name('admin_user.edit');
    Route::post('/delete', $nameSpaceAdminUser.'\Auth\UsersController@deleteList')->name('admin_user.delete');
});