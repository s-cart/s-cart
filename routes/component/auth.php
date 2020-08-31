<?php
Auth::routes();
$prefixMember = sc_config('PREFIX_MEMBER')??'member';
//--Auth
Route::group(['namespace' => 'Auth', 'prefix' => $prefixMember], function ($router) use($suffix){
    $router->get('/login'.$suffix, 'LoginController@showLoginForm')
        ->name('login');
    $router->post('/login'.$suffix, 'LoginController@login')
        ->name('postLogin');
    $router->get('/register'.$suffix, 'RegisterController@showRegisterForm')
        ->name('register');
    $router->post('/register'.$suffix, 'RegisterController@register')
        ->name('postRegister');
    $router->post('/logout', 'LoginController@logout')
        ->name('logout');
    $router->post('/password/email', 'ForgotPasswordController@sendResetLinkEmail')
        ->name('password.email');
    $router->post('/password/reset', 'ResetPasswordController@reset');
    $router->get('/password/reset/{token}', 'ResetPasswordController@showResetForm')
        ->name('password.reset');
    $router->get('/forgot'.$suffix, 'ForgotPasswordController@showLinkRequestForm')
        ->name('forgot');
});
//End Auth