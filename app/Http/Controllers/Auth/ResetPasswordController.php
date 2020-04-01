<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\GeneralController;
use Auth;
use Illuminate\Foundation\Auth\ResetsPasswords;
use Illuminate\Http\Request;
use App\Models\ShopUserPasswordReset;
class ResetPasswordController extends GeneralController
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
     * Form reset password
     *
     * @param   Request  $request
     * @param   [string]   $token
     *
     * @return  [view]
     */
    public function showResetForm(Request $request, $token = null)
    {
        if (Auth::user()) {
            return redirect()->route('home');
        }
        return view($this->templatePath . '.auth.reset',
            [
                'title' => trans('front.reset_password'),
                'token' => $token,
                'email' => $request->email,
                'layout_page' => 'shop_auth',
            ]
        );
    }
}
