<?php

namespace App\Pmo\Admin\Controllers\Auth;

use App\Pmo\Admin\Controllers\RootAdminController;
use Auth;
use Illuminate\Foundation\Auth\ResetsPasswords;
use Illuminate\Support\Facades\Password;
use Illuminate\Http\Request;
class ResetPasswordController extends RootAdminController
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
        parent::__construct(); 
        $this->middleware('guest:admin');
    }


    /**
     * Form reset password
     *
     * @param   Request  $request
     * @param   [string]   $token
     *
     * @return  [view]
     */
    public function formResetPassword($token = null)
    {
        if (admin()->user()) {
            return redirect(sc_route_admin('admin.home'));
        }
        $data = [
                'title'       => sc_language_render('admin.password_reset'),
                'token'       => $token,
                'breadcrumbs' => [
                    ['url'    => '', 'title' => sc_language_render('admin.password_reset')],
                ],
            ];
        return view($this->templatePathAdmin.'auth.reset')
        ->with($data);
    }


    /**
     * Reset the given user's password.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Http\JsonResponse
     */
    public function reset(Request $request)
    {
        $request->validate($this->rules(), $this->validationErrorMessages());

        // Here we will attempt to reset the user's password. If it is successful we
        // will update the password on an actual user model and persist it to the
        // database. Otherwise we will parse the error and return the response.
        $response = $this->broker()->reset(
            $this->credentials($request), function ($user, $password) {
                $this->resetPassword($user, $password);
            }
        );

        // If the password was successfully reset, we will redirect the user back to
        // the application's home authenticated view. If there is an error we can
        // redirect them back to where they came from with their error message.
        return $response == Password::PASSWORD_RESET
                    ? $this->sendResetResponse($request, $response)
                    : $this->sendResetFailedResponse($request, $response);
    }
    
    public function redirectPath() {
        return sc_route_admin('admin.home');
    }

    protected function broker()
    {
        return Password::broker('admins');
    }

    protected function guard()
    {
        return Auth::guard('admin');
    }
}
