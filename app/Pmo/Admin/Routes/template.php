<?php
if (file_exists(app_path('Admin/Controllers/AdminTemplateController.php'))) {
    $nameSpaceAdminTemplate = 'App\Admin\Controllers';
} else {
    $nameSpaceAdminTemplate = 'App\Pmo\Admin\Controllers';
}
Route::group(['prefix' => 'template'], function () use ($nameSpaceAdminTemplate) {
    //Process import
    Route::get('/import', $nameSpaceAdminTemplate.'\AdminTemplateController@importTemplate')
        ->name('admin_template.import');
    Route::post('/import', $nameSpaceAdminTemplate.'\AdminTemplateController@processImport')
        ->name('admin_template.process_import');
    //End process

    Route::get('/', $nameSpaceAdminTemplate.'\AdminTemplateController@index')->name('admin_template.index');
    Route::post('changeTemplate', $nameSpaceAdminTemplate.'\AdminTemplateController@changeTemplate')->name('admin_template.changeTemplate');
    Route::post('remove', $nameSpaceAdminTemplate.'\AdminTemplateController@remove')->name('admin_template.remove');
    Route::post('refresh', $nameSpaceAdminTemplate.'\AdminTemplateController@refresh')->name('admin_template.refresh');
    Route::post('enable', $nameSpaceAdminTemplate.'\AdminTemplateController@enable')->name('admin_template.enable');
    Route::post('disable', $nameSpaceAdminTemplate.'\AdminTemplateController@disable')->name('admin_template.disable');

    if (config('admin.settings.api_template')) {
        Route::get('/online', $nameSpaceAdminTemplate.'\AdminTemplateOnlineController@index')->name('admin_template_online.index');
        Route::post('/online/install', $nameSpaceAdminTemplate.'\AdminTemplateOnlineController@install')
        ->name('admin_template_online.install');
    }
});