<?php
if (file_exists(app_path('Admin/Controllers/AdminMenuController.php'))) {
    $nameSpaceAdminMenu = 'App\Admin\Controllers';
} else {
    $nameSpaceAdminMenu = 'App\Pmo\Admin\Controllers';
}
Route::group(['prefix' => 'menu'], function () use ($nameSpaceAdminMenu) {
    Route::get('/', $nameSpaceAdminMenu.'\AdminMenuController@index')->name('admin_menu.index');
    Route::post('/create', $nameSpaceAdminMenu.'\AdminMenuController@postCreate')->name('admin_menu.create');
    Route::get('/edit/{id}', $nameSpaceAdminMenu.'\AdminMenuController@edit')->name('admin_menu.edit');
    Route::post('/edit/{id}', $nameSpaceAdminMenu.'\AdminMenuController@postEdit')->name('admin_menu.edit');
    Route::post('/delete', $nameSpaceAdminMenu.'\AdminMenuController@deleteList')->name('admin_menu.delete');
    Route::post('/update_sort', $nameSpaceAdminMenu.'\AdminMenuController@updateSort')->name('admin_menu.update_sort');
});