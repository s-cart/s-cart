<?php

namespace App\Pmo\Api\Controllers;

use App\Pmo\Front\Controllers\RootFrontController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use App\Pmo\Front\Controllers\Auth\AuthTrait;

class AdminAuthController extends RootFrontController
{
    use AuthTrait;

    /**
     * Login user and create token
     *
     * @param  [string] username
     * @param  [string] password
     * @param  [boolean] remember_me
     * @return [string] access_token
     * @return [string] token_type
     * @return [string] expires_at
     */
    public function login(Request $request)
    {
        $request->validate([
            'username' => 'required|string',
            'password' => 'required|string',
            'remember_me' => 'boolean'
        ]);

        $credentials = request(['username', 'password']);

        if (!$this->guard()->attempt($credentials)) {
            return response()->json([
                'error' => 1,
                'msg' => 'Unauthorized'
            ], 401);
        }

        $user = $this->guard()->user();

        $scope = explode(',', config('api.auth.api_scope_admin'));
        
        $tokenResult = $user->createToken('Admin:'.$user->email.'- '.now(), $scope);
        $token = $tokenResult->plainTextToken;
        $accessToken = $tokenResult->accessToken;
        if ($request->remember_me) {
            $accessToken->expires_at = Carbon::now()->addDays(config('api.auth.api_remmember_admin'));
        }
        $accessToken->save();

        return response()->json([
            'access_token' => $token,
            'token_type' => 'Bearer',
            'scopes' => $accessToken->abilities,
            'expires_at' => Carbon::parse(
                $accessToken->expires_at
            )->toDateTimeString()
        ]);
    }
  
    /**
     * Logout user (Revoke the token)
     *
     * @return [string] message
     */
    public function logout(Request $request)
    {
        $request->user()->token()->revoke();
        return response()->json([
            'error' => 0,
            'msg' => 'Successfully logged out'
        ]);
    }

    protected function guard()
    {
        return Auth::guard('admin');
    }

    public function getInfo()
    {
        $user = request()->user();
        return response()->json($user);
    }
}
