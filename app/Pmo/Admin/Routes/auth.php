<?php
if (file_exists(app_path('Admin/Controllers/Auth/LoginController.php'))) {
    $nameSpaceAdminAuth = 'App\Admin\Controllers';
} else {
    $nameSpaceAdminAuth = 'App\Pmo\Admin\Controllers';
}
Route::group(['prefix' => 'auth'], function () use ($nameSpaceAdminAuth) {
    Route::get('login', $nameSpaceAdminAuth . '\Auth\LoginController@getLogin')->name('admin.login');
    Route::post('login', $nameSpaceAdminAuth . '\Auth\LoginController@postLogin')->name('admin.login');
    Route::get('logout', $nameSpaceAdminAuth . '\Auth\LoginController@getLogout')->name('admin.logout');
    Route::get('setting', $nameSpaceAdminAuth . '\Auth\LoginController@getSetting')->name('admin.setting');
    Route::post('setting', $nameSpaceAdminAuth . '\Auth\LoginController@putSetting')->name('admin.setting');

    if (sc_config_global('admin_forgot_password', 1)) {
        Route::get('forgot', $nameSpaceAdminAuth .'\Auth\ForgotPasswordController@getForgot')->name('admin.forgot');
        Route::post('forgot', $nameSpaceAdminAuth .'\Auth\ForgotPasswordController@sendRepostForgotsetLinkEmail')->name('admin.forgot');
        Route::get('password/reset/{token}', $nameSpaceAdminAuth .'\Auth\ResetPasswordController@formResetPassword')->name('admin.password_reset');
        Route::post('password/reset', $nameSpaceAdminAuth .'\Auth\ResetPasswordController@reset')->name('admin.password_request');
    }
});