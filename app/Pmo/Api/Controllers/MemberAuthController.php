<?php

namespace App\Pmo\Api\Controllers;

use App\Pmo\Front\Controllers\RootFrontController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use App\Pmo\Front\Models\ShopCustomer;
use Illuminate\Support\Facades\Validator;
use App\Pmo\Front\Controllers\Auth\AuthTrait;

class MemberAuthController extends RootFrontController
{
    use AuthTrait;

    /**
     * Login user and create token
     *
     * @param  [string] email
     * @param  [string] password
     * @param  [boolean] remember_me
     * @return [string] access_token
     * @return [string] token_type
     * @return [string] expires_at
     */
    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|string|email',
            'password' => 'required|string',
            'remember_me' => 'boolean'
        ]);
        $credentials = request(['email', 'password']);

        if (!$this->guard()->attempt($credentials)) {
            return response()->json([
                'error' => 1,
                'msg' => 'Unauthorized'
            ], 401);
        }

        $user = $this->guard()->user();

        if ($user->status == 0) {
            $scope = explode(',', config('api.auth.api_scope_user_guest'));
        } else {
            $scope = explode(',', config('api.auth.api_scope_user'));
        }
        
        $tokenResult = $user->createToken('Client:'.$user->email.'- '.now(), $scope);
        $token = $tokenResult->plainTextToken;
        $accessToken = $tokenResult->accessToken;
        if ($request->remember_me) {
            $accessToken->expires_at = Carbon::now()->addDays(config('api.auth.api_remmember'));
        } else {
            $accessToken->expires_at = Carbon::now()->addDays(config('api.auth.api_token_expire_admin_default'));
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
     * Create new customer
     */
    public function create(Request $request)
    {
        $data = $request->all();
        $data['country'] = strtoupper($data['country'] ?? '');

        $v = $this->validator($data);
        if ($v->fails()) {
            $msg = '';
            foreach ($v->errors()->toArray() as $key => $value) {
                $msg .=$key." : ".$value[0]."\n ";
            }
            return response()->json([
                'error' => 1,
                'msg' => 'Error while create new customer',
                'detail' => $msg
            ]);
        }
        
        $user = $this->insertCustomer($data);

        return response()->json($user);
    }

    /**
     * Validate data input
     */
    protected function validator(array $data)
    {
        $dataMapp = $this->mappingValidator($data);
        return Validator::make($data, $dataMapp['validate'], $dataMapp['messages']);
    }

    /**
     * Inser data new customer
     */
    protected function insertCustomer($data)
    {
        $dataMapp = $this->mappingValidator($data);
        $user = ShopCustomer::createCustomer($dataMapp['dataInsert']);

        if ($user) {
            sc_customer_created_by_client($user, $dataMapp['dataInsert']);
        }
        return $user;
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
        return Auth::guard();
    }
}
