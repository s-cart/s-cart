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
     * Send a reset link to the given user.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Http\JsonResponse
     */
    public function sendResetLinkEmail(\Illuminate\Http\Request $request)
    {
        $data = $request->all();
        $dataMapping['email'] = 'required|string|email';
        if(sc_captcha_method() && in_array('forgot', sc_captcha_page())) {
            $data['captcha_field'] = $data[sc_captcha_method()->getField()];
            $dataMapping['captcha_field'] = ['required', 'string', new \App\Rules\CaptchaRule];
        }
        $validator = \Illuminate\Support\Facades\Validator::make($data, $dataMapping);
        if ($validator->fails()) {
            return redirect()->back()
                        ->withErrors($validator)
                        ->withInput();
        }

        // We will send the password reset link to this user. Once we have attempted
        // to send the link, we will examine the response then see the message we
        // need to show to the user. Finally, we'll send out a proper response.
        $response = $this->broker()->sendResetLink(
            $this->credentials($request)
        );

        return $response == \Illuminate\Support\Facades\Password::RESET_LINK_SENT
                    ? $this->sendResetLinkResponse($request, $response)
                    : $this->sendResetLinkFailedResponse($request, $response);
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
        $viewCaptcha = '';
        if(sc_captcha_method() && in_array('forgot', sc_captcha_page())) {
            if (view()->exists(sc_captcha_method()->pathPlugin.'::render')){
                $dataView = [
                    'titleButton' => trans('front.submit_form'),
                    'idForm' => 'form-process',
                    'idButtonForm' => 'button-form-process',
                ];
                $viewCaptcha = view(sc_captcha_method()->pathPlugin.'::render', $dataView)->render();
            }
        }
        return view($this->templatePath . '.auth.forgot',
            array(
                'title' => trans('front.forgot_password'),
                'layout_page' => 'shop_auth',
                'viewCaptcha' => $viewCaptcha,
            )
        );
    }
}
