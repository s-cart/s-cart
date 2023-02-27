<?php
if (file_exists(app_path('Admin/Controllers/AdminStoreBlockController.php'))) {
    $nameSpaceAdminStoreBlock = 'App\Admin\Controllers';
} else {
    $nameSpaceAdminStoreBlock = 'App\Pmo\Admin\Controllers';
}
Route::group(['prefix' => 'store_block'], function () use ($nameSpaceAdminStoreBlock) {
    Route::get('/', $nameSpaceAdminStoreBlock.'\AdminStoreBlockController@index')->name('admin_store_block.index');
    Route::get('create', $nameSpaceAdminStoreBlock.'\AdminStoreBlockController@create')->name('admin_store_block.create');
    Route::post('/create', $nameSpaceAdminStoreBlock.'\AdminStoreBlockController@postCreate')->name('admin_store_block.create');
    Route::get('/edit/{id}', $nameSpaceAdminStoreBlock.'\AdminStoreBlockController@edit')->name('admin_store_block.edit');
    Route::post('/edit/{id}', $nameSpaceAdminStoreBlock.'\AdminStoreBlockController@postEdit')->name('admin_store_block.edit');
    Route::get('/listblock_view', $nameSpaceAdminStoreBlock.'\AdminStoreBlockController@getListViewBlockHtml')->name('admin_store_block.listblock_view');
    Route::get('/listblock_page', $nameSpaceAdminStoreBlock.'\AdminStoreBlockController@getListPageBlockHtml')->name('admin_store_block.listblock_page');
    Route::post('/delete', $nameSpaceAdminStoreBlock.'\AdminStoreBlockController@deleteList')->name('admin_store_block.delete');
});