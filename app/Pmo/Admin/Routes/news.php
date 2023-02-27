<?php
if (file_exists(app_path('Admin/Controllers/AdminNewsController.php'))) {
    $nameSpaceAdminNews = 'App\Admin\Controllers';
} else {
    $nameSpaceAdminNews = 'App\Pmo\Admin\Controllers';
}
Route::group(['prefix' => 'news'], function () use ($nameSpaceAdminNews) {
    Route::get('/', $nameSpaceAdminNews.'\AdminNewsController@index')->name('admin_news.index');
    Route::get('create', $nameSpaceAdminNews.'\AdminNewsController@create')->name('admin_news.create');
    Route::post('/create', $nameSpaceAdminNews.'\AdminNewsController@postCreate')->name('admin_news.create');
    Route::get('/edit/{id}', $nameSpaceAdminNews.'\AdminNewsController@edit')->name('admin_news.edit');
    Route::post('/edit/{id}', $nameSpaceAdminNews.'\AdminNewsController@postEdit')->name('admin_news.edit');
    Route::post('/delete', $nameSpaceAdminNews.'\AdminNewsController@deleteList')->name('admin_news.delete');
});