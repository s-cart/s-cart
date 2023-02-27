<?php

namespace App\Pmo\Front\Controllers\Auth;

use App\Pmo\Front\Controllers\RootFrontController;
use Auth;
use Illuminate\Foundation\Auth\ResetsPasswords;
use Illuminate\Http\Request;

class ResetPasswordController extends RootFrontController
{
    /*
    |--------------------------------------------------------------------------
    | Password Reset Controller
    |--------------------------------------------------------------------------
    |
    | This controller is responsible for handling password reset requests
    | and uses a simple trait to include this behavior. You're free to
    | explore this trait and override any methods you wish to tweak.
    |
     */

    use ResetsPasswords;

    /**
     * Where to redirect users after resetting their password.
     *
     * @var string
     */
    // protected $redirectTo = '/home';
    protected $redirectTo = '/';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct(); //
        $this->middleware('guest');
    }

    /**
     * Process front Form forgot password
     *
     * @param [type] ...$params
     * @return void
     */
    public function showResetFormProcessFront(...$params)
    {
        if (config('app.seoLang')) {
            $lang = $params[0] ?? '';
            $token = $params[1] ?? '';
            sc_lang_switch($lang);
        } else {
            $token = $params[0] ?? '';
        }
        return $this->_showResetForm($token);
    }

    /**
     * Form reset password
     *
     * @param   Request  $request
     * @param   [string]   $token
     *
     * @return  [view]
     */
    private function _showResetForm($token = null)
    {
        if (Auth::user()) {
            return redirect()->route('home');
        }
        sc_check_view($this->templatePath . '.auth.reset');
        return view(
            $this->templatePath . '.auth.reset',
            [
                'title'       => sc_language_render('customer.password_reset'),
                'token'       => $token,
                'layout_page' => 'shop_auth',
                'breadcrumbs' => [
                    ['url'    => '', 'title' => sc_language_render('customer.password_reset')],
                ],
            ]
        );
    }
}
