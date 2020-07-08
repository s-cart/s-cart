<?php

namespace App\Api\Controllers;

use App\Http\Controllers\GeneralController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use App\Models\ShopUser;
use Illuminate\Support\Facades\Validator;
use App\Models\ShopEmailTemplate;
use App\Http\Controllers\Auth\AuthTrait;
class AuthController extends GeneralController
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

        if(!Auth::attempt($credentials)){
            return response()->json([
                'error' => 1,
                'msg' => 'Unauthorized'
            ], 401);
        }

        $user = $request->user();
        $tokenResult = $user->createToken('Personal Access Token');
        $token = $tokenResult->token;

        if ($request->remember_me){
            $token->expires_at = Carbon::now()->addWeeks(1);
        }

        $token->save();

        return response()->json([
            'access_token' => $tokenResult->accessToken,
            'token_type' => 'Bearer',
            'expires_at' => Carbon::parse(
                $tokenResult->token->expires_at
            )->toDateTimeString()
        ]);
    }

    /**
     * Create new customer
     */
    public function create(Request $request)
    {
        $data = $request->all();
        $data['reg_country'] = strtoupper($data['reg_country'] ?? '');
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
        $user = $this->insert($data);
        return response()->json($user);
    }

    /**
     * Validate data input
     */
    protected function validator(array $data)
    {
        $dataMapping = $this->mappingValidator($data);
        return Validator::make($data, $dataMapping['validate'], $dataMapping['messages']);
    }

    /**
     * Inser data new customer
     */
    protected function insert($data)
    {
        $dataMap = $this->mappDataInsert($data);

        $user = ShopUser::createCustomer($dataMap);
        if ($user) {
            if (sc_config('welcome_customer')) {

                $checkContent = (new ShopEmailTemplate)->where('group', 'welcome_customer')->where('status', 1)->first();
                if ($checkContent) {
                    $content = $checkContent->text;
                    $dataFind = [
                        '/\{\{\$title\}\}/',
                        '/\{\{\$first_name\}\}/',
                        '/\{\{\$last_name\}\}/',
                        '/\{\{\$email\}\}/',
                        '/\{\{\$phone\}\}/',
                        '/\{\{\$password\}\}/',
                        '/\{\{\$address1\}\}/',
                        '/\{\{\$address2\}\}/',
                        '/\{\{\$country\}\}/',
                    ];
                    $dataReplace = [
                        trans('email.welcome_customer.title'),
                        $dataMap['first_name'],
                        $dataMap['last_name'],
                        $dataMap['email'],
                        $dataMap['phone'],
                        $dataMap['password'],
                        $dataMap['address1'],
                        $dataMap['address2'],
                        $dataMap['country'],
                    ];
                    $content = preg_replace($dataFind, $dataReplace, $content);
                    $dataView = [
                        'content' => $content,
                    ];

                    $config = [
                        'to' => $data['email'],
                        'subject' => trans('email.welcome_customer.title'),
                    ];

                    sc_send_mail($this->templatePath . '.mail.welcome_customer', $dataView, $config, []);
                }

            }
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
  
}