<?php

namespace App\Pmo\Front\Controllers\Auth;

use App\Pmo\Front\Controllers\RootFrontController;
use App\Pmo\Front\Models\ShopCountry;
use Auth;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;

class LoginController extends RootFrontController
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
     */

    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    // protected $redirectTo = '/';
    protected function redirectTo()
    {
        return sc_route('customer.index');
    }
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
        $this->middleware('guest')->except('logout');
    }

    protected function validateLogin(Request $request)
    {
        $messages = [
            'email.email'       => sc_language_render('validation.email', ['attribute'=> sc_language_render('customer.email')]),
            'email.required'    => sc_language_render('validation.required', ['attribute'=> sc_language_render('customer.email')]),
            'password.required' => sc_language_render('validation.required', ['attribute'=> sc_language_render('customer.password')]),
            ];
        $this->validate($request, [
            'email'    => 'required|string|email',
            'password' => 'required|string',
        ], $messages);
    }

    /**
     * Process front form login
     *
     * @param [type] ...$params
     * @return void
     */
    public function showLoginFormProcessFront(...$params)
    {
        if (config('app.seoLang')) {
            $lang = $params[0] ?? '';
            sc_lang_switch($lang);
        }
        return $this->_showLoginForm();
    }


    /**
     * Form login
     *
     * @return  [type]  [return description]
     */
    private function _showLoginForm()
    {
        if (Auth::user()) {
            return redirect()->route('home');
        }
        sc_check_view($this->templatePath . '.auth.login');
        return view(
            $this->templatePath . '.auth.login',
            array(
                'title'       => sc_language_render('customer.login_title'),
                'countries'   => ShopCountry::getCodeAll(),
                'layout_page' => 'shop_auth',
                'breadcrumbs' => [
                    ['url'    => '', 'title' => sc_language_render('customer.login_title')],
                ],
            )
        );
    }


    public function logout(Request $request)
    {
        $this->guard()->logout();

        $request->session()->invalidate();

        return $this->loggedOut($request) ?: redirect(sc_route('login'));
    }

    protected function authenticated(Request $request, $user)
    {
        if (auth()->user()) {
            session(['customer' => auth()->user()->toJson()]);
        } else {
            session(['customer' => []]);
        }
    }
}
