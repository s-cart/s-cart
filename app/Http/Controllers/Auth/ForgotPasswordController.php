<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\GeneralController;
use Auth;
use Illuminate\Foundation\Auth\SendsPasswordResetEmails;

class ForgotPasswordController extends GeneralController
{
    /*
    |--------------------------------------------------------------------------
    | Password Reset Controller
    |--------------------------------------------------------------------------
    |
    | This controller is responsible for handling password reset emails and
    | includes a trait which assists in sending these notifications from
    | your application to your users. Feel free to explore this trait.
    |
     */

    use SendsPasswordResetEmails;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
        $this->middleware('guest');

    }

    /**
     * Form forgot password
     * @return [view] 
     */
    public function showLinkRequestForm()
    {
        if (Auth::user()) {
            return redirect()->route('home');
        }
        return view($this->templatePath . '.auth.forgot',
            array(
                'title' => trans('front.forgot_password'),
                'layout_page' => 'shop_auth',
            )
        );
    }
}
