<?php
$prefixCustomer = sc_config('PREFIX_MEMBER') ?? 'customer';
$langUrl = config('app.seoLang');

//Process namespace
if (file_exists(app_path('Http/Controllers/Auth/LoginController.php'))) {
    $nameSpaceFrontLogin = 'App\Http\Controllers';
} else {
    $nameSpaceFrontLogin = 'App\Pmo\Front\Controllers';
}
if (file_exists(app_path('Http/Controllers/Auth/RegisterController.php'))) {
    $nameSpaceFrontRegister = 'App\Http\Controllers';
} else {
    $nameSpaceFrontRegister = 'App\Pmo\Front\Controllers';
}
if (file_exists(app_path('Http/Controllers/Auth/ForgotPasswordController.php'))) {
    $nameSpaceFrontForgot = 'App\Http\Controllers';
} else {
    $nameSpaceFrontForgot = 'App\Pmo\Front\Controllers';
}
if (file_exists(app_path('Http/Controllers/Auth/ResetPasswordController.php'))) {
    $nameSpaceFrontReset = 'App\Http\Controllers';
} else {
    $nameSpaceFrontReset = 'App\Pmo\Front\Controllers';
}

//--Auth
Route::group(
    [
        'namespace' => $nameSpaceFrontLogin.'\Auth',
        'prefix' => $langUrl.$prefixCustomer,
    ],
    function ($router) use ($suffix) {
        $router->get('/login'.$suffix, 'LoginController@showLoginFormProcessFront')
            ->name('login');
        $router->post('/login'.$suffix, 'LoginController@login')
            ->name('postLogin');
        $router->any('/logout', 'LoginController@logout')
            ->name('logout');
    }
);

Route::group(
    [
        'namespace' => $nameSpaceFrontRegister.'\Auth',
        'prefix' => $langUrl.$prefixCustomer,
    ],
    function ($router) use ($suffix) {
        $router->get('/register'.$suffix, 'RegisterController@showRegisterFormProcessFront')
            ->name('register');
        $router->post('/register'.$suffix, 'RegisterController@register')
            ->name('postRegister');
    }
);

Route::group(
    [
        'namespace' => $nameSpaceFrontForgot.'\Auth',
        'prefix' => $langUrl.$prefixCustomer,
    ],
    function ($router) use ($suffix) {
        $router->get('/forgot'.$suffix, 'ForgotPasswordController@showLinkRequestFormProcessFront')
            ->name('forgot');
            $router->post('/password/email', 'ForgotPasswordController@sendResetLinkEmail')
            ->name('password.email');
    }
);

Route::group(
    [
        'namespace' => $nameSpaceFrontReset.'\Auth',
        'prefix' => $langUrl.$prefixCustomer,
    ],
    function ($router) {
        $router->get('/password/reset/{token}', 'ResetPasswordController@showResetFormProcessFront')
            ->name('password.reset');
        $router->post('/password/reset', 'ResetPasswordController@reset')
            ->name('password.request');
    }
);
//End Auth
