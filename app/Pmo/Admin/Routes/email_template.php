<?php
if (file_exists(app_path('Admin/Controllers/AdminEmailTemplateController.php'))) {
    $nameSpaceAdminEmailTemplate = 'App\Admin\Controllers';
} else {
    $nameSpaceAdminEmailTemplate = 'App\Pmo\Admin\Controllers';
}
Route::group(['prefix' => 'email_template'], function () use ($nameSpaceAdminEmailTemplate) {
    Route::get('/', $nameSpaceAdminEmailTemplate.'\AdminEmailTemplateController@index')->name('admin_email_template.index');
    Route::get('create', $nameSpaceAdminEmailTemplate.'\AdminEmailTemplateController@create')->name('admin_email_template.create');
    Route::post('/create', $nameSpaceAdminEmailTemplate.'\AdminEmailTemplateController@postCreate')->name('admin_email_template.create');
    Route::get('/edit/{id}', $nameSpaceAdminEmailTemplate.'\AdminEmailTemplateController@edit')->name('admin_email_template.edit');
    Route::post('/edit/{id}', $nameSpaceAdminEmailTemplate.'\AdminEmailTemplateController@postEdit')->name('admin_email_template.edit');
    Route::post('/delete', $nameSpaceAdminEmailTemplate.'\AdminEmailTemplateController@deleteList')->name('admin_email_template.delete');
    Route::get('/list_variable', $nameSpaceAdminEmailTemplate.'\AdminEmailTemplateController@listVariable')->name('admin_email_template.list_variable');
});