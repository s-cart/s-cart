<?php
Route::group(['prefix' => 'uploads', 'namespace' => '\\UniSharp\\LaravelFilemanager\\Controllers\\'], function () {

    // display main layout
    Route::get('/', [
        'uses' => 'LfmController@show',
        'as' => 'unisharp.lfm.show',
    ]);

    // display integration error messages
    Route::get('/errors', [
        'uses' => 'LfmController@getErrors',
        'as' => 'unisharp.lfm.getErrors',
    ]);

    // upload
    Route::post('/upload', [
        'uses' => 'UploadController@upload',
        'as' => 'unisharp.lfm.upload',
    ]);

    // list images & files
    Route::get('/jsonitems', [
        'uses' => 'ItemsController@getItems',
        'as' => 'unisharp.lfm.getItems',
    ]);

    Route::get('/move', [
        'uses' => 'ItemsController@move',
        'as' => 'unisharp.lfm.move',
    ]);

    Route::get('/domove', [
        'uses' => 'ItemsController@domove',
        'as' => 'unisharp.lfm.domove',
    ]);

    // folders
    Route::get('/newfolder', [
        'uses' => 'FolderController@getAddfolder',
        'as' => 'unisharp.lfm.getAddfolder',
    ]);

    // list folders
    Route::get('/folders', [
        'uses' => 'FolderController@getFolders',
        'as' => 'unisharp.lfm.getFolders',
    ]);

    // crop
    Route::get('/crop', [
        'uses' => 'CropController@getCrop',
        'as' => 'unisharp.lfm.getCrop',
    ]);
    Route::get('/cropimage', [
        'uses' => 'CropController@getCropimage',
        'as' => 'unisharp.lfm.getCropimage',
    ]);
    Route::get('/cropnewimage', [
        'uses' => 'CropController@getNewCropimage',
        'as' => 'unisharp.lfm.getCropnewimage',
    ]);

    // rename
    Route::get('/rename', [
        'uses' => 'RenameController@getRename',
        'as' => 'unisharp.lfm.getRename',
    ]);

    // scale/resize
    Route::get('/resize', [
        'uses' => 'ResizeController@getResize',
        'as' => 'unisharp.lfm.getResize',
    ]);
    Route::get('/doresize', [
        'uses' => 'ResizeController@performResize',
        'as' => 'unisharp.lfm.performResize',
    ]);

    // download
    Route::get('/download', [
        'uses' => 'DownloadController@getDownload',
        'as' => 'unisharp.lfm.getDownload',
    ]);

    // delete
    Route::get('/delete', [
        'uses' => 'DeleteController@getDelete',
        'as' => 'unisharp.lfm.getDelete',
    ]);
});
