<?php

namespace App\Admin\Controllers\Auth;

use App\Admin\Admin;
use App\Admin\Models\AdminPermission;
use App\Admin\Models\AdminRole;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Lang;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Validator;

class LoginController extends Controller
{
    /**
     * Show the login page.
     *
     * @return \Illuminate\Contracts\View\Factory|Redirect|\Illuminate\View\View
     */
    public function getLogin()
    {
        if ($this->guard()->check()) {
            return redirect($this->redirectPath());
        }

        return view('admin.auth.login',['title'=>'Login']);
    }

    /**
     * Handle a login request.
     *
     * @param Request $request
     *
     * @return mixed
     */
    public function postLogin(Request $request)
    {
        $this->loginValidator($request->all())->validate();

        $credentials = $request->only([$this->username(), 'password']);
        $remember = $request->get('remember', false);

        if ($this->guard()->attempt($credentials, $remember)) {
            return $this->sendLoginResponse($request);
        }
        return back()->withInput()->withErrors([
            $this->username() => $this->getFailedLoginMessage(),
        ]);
    }

    /**
     * Get a validator for an incoming login request.
     *
     * @param array $data
     *
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function loginValidator(array $data)
    {
        return Validator::make($data, [
            $this->username() => 'required',
            'password' => 'required',
        ]);
    }

    /**
     * User logout.
     *
     * @return Redirect
     */
    public function getLogout(Request $request)
    {
        $this->guard()->logout();

        $request->session()->invalidate();

        return redirect(SC_ADMIN_PREFIX);
    }

    public function getSetting()
    {
        $user = Admin::user();
        if ($user === null) {
            return 'no data';
        }
        $data = [
            'title' => trans('admin.setting_account'),
            'subTitle' => '',
            'title_description' => '',
            'icon' => 'fa fa-edit',
            'user' => $user,
            'roles' => (new AdminRole)->pluck('name', 'id')->all(),
            'permission' => (new AdminPermission)->pluck('name', 'id')->all(),
            'url_action' => sc_route('admin.setting'),
        ];
        return view('admin.auth.setting')
            ->with($data);
    }

    public function putSetting()
    {
        $user = Admin::user();
        $data = request()->all();
        $dataOrigin = request()->all();
        $validator = Validator::make($dataOrigin, [
            'name' => 'required|string|max:100',
            'avatar' => 'nullable|string|max:255',
            'password' => 'nullable|string|max:60|min:6|confirmed',
        ], [
            'username.regex' => trans('user.username_validate'),
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }
//Edit

        $dataUpdate = [
            'name' => $data['name'],
            'avatar' => $data['avatar'],
        ];
        if ($data['password']) {
            $dataUpdate['password'] = bcrypt($data['password']);
        }
        $user->update($dataUpdate);
//
        return redirect()->route('admin.home')->with('success', trans('user.admin.edit_success'));
    }

    /**
     * @return string|\Symfony\Component\Translation\TranslatorInterface
     */
    protected function getFailedLoginMessage()
    {
        return Lang::has('auth.failed')
        ? trans('auth.failed')
        : 'These credentials do not match our records.';
    }

    /**
     * Get the post login redirect path.
     *
     * @return string
     */
    protected function redirectPath()
    {
        if (method_exists($this, 'redirectTo')) {
            return $this->redirectTo();
        }

        return property_exists($this, 'redirectTo') ? $this->redirectTo : SC_ADMIN_PREFIX;
    }

    /**
     * Send the response after the user was authenticated.
     *
     * @param \Illuminate\Http\Request $request
     *
     * @return \Illuminate\Http\Response
     */
    protected function sendLoginResponse(Request $request)
    {

        $request->session()->regenerate();

        return redirect()->intended($this->redirectPath())->with(['success' => trans('admin.login_successful')]);
    }

    /**
     * Get the login username to be used by the controller.
     *
     * @return string
     */
    protected function username()
    {
        return 'username';
    }

    /**
     * Get the guard to be used during authentication.
     *
     * @return \Illuminate\Contracts\Auth\StatefulGuard
     */
    protected function guard()
    {
        return Auth::guard('admin');
    }
}
