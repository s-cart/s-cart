<?php
#app/Http/Controller/ShopAccount.php
namespace App\Http\Controllers;

use App\Models\ShopCountry;
use App\Models\ShopOrder;
use App\Models\ShopOrderStatus;
use App\Models\ShopUser;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class ShopAccount extends GeneralController
{
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Index user profile
     *
     * @return  [view]
     */
    public function index()
    {
        $user = Auth::user();
        return view($this->templatePath . '.account.index')
            ->with(
                [
                    'title' => trans('account.my_profile'),
                    'user' => $user,
                    'layout_page' => 'shop_profile',
                ]
            );
    }

    /**
     * Form Change password
     *
     * @return  [view]
     */
    public function changePassword()
    {
        $user = Auth::user();
        return view($this->templatePath . '.account.change_password')
        ->with(
            [
                'title' => trans('account.change_password'),
                'user' => $user,
                'layout_page' => 'shop_profile',
            ]
        );
    }

    /**
     * Post change password
     *
     * @param   Request  $request  [$request description]
     *
     * @return  [redirect]
     */
    public function postChangePassword(Request $request)
    {
        $user = Auth::user();
        $id = $user->id;
        $dataUser = ShopUser::find($id);
        $password = $request->get('password');
        $password_old = $request->get('password_old');
        if (trim($password_old) == '') {
            return redirect()->back()
                ->with(
                    [
                        'password_old_error' => trans('account.password_old_required')
                    ]
                );
        } else {
            if (!\Hash::check($password_old, $dataUser->password)) {
                return redirect()->back()
                    ->with(
                        [
                            'password_old_error' => trans('account.password_old_notcorrect')
                        ]
                    );
            }
        }
        $messages = [
            'password.required' => trans('validation.required',['attribute'=> trans('account.password')]),
            'password.confirmed' => trans('validation.confirmed',['attribute'=> trans('account.password')]),
            'password_old.required' => trans('validation.required',['attribute'=> trans('account.password_old')]),
        ];
        $v = Validator::make(
            $request->all(), 
            [
                'password_old' => 'required',
                'password' => 'required|string|min:6|confirmed',
            ],
            $messages
        );
        if ($v->fails()) {
            return redirect()->back()->withErrors($v->errors());
        }

        ShopUser::updateInfo(['password' => bcrypt($password)], $id);

        return redirect()->route('member.index')
            ->with(['message' => trans('account.update_success')]);
    }

    /**
     * Form change info
     *
     * @return  [view]
     */
    public function changeInfomation()
    {
        $user = Auth::user();
        return view($this->templatePath . '.account.change_infomation')
            ->with(
                [
                    'title' => trans('account.change_infomation'),
                    'user' => $user,
                    'countries' => ShopCountry::getArray(),
                    'layout_page' => 'shop_profile',
                ]
            );
    }

    /**
     * Process update info
     *
     * @param   Request  $request  [$request description]
     *
     * @return  [redirect] 
     */
    public function postChangeInfomation(Request $request)
    {
        $user = Auth::user();
        $id = $user->id;
        $data = request()->all();
        $dataUpdate = [
            'first_name' => $data['first_name'],
            'address1' => $data['address1'],
        ];
        $validate = [
            'first_name' => 'required|string|max:100',
            'address1' => 'required|string|max:255',
        ];
        if(sc_config('customer_lastname')) {
            $validate['last_name'] = 'required|max:100';
            $dataUpdate['last_name'] = $data['last_name']??'';
        }
        if(sc_config('customer_address2')) {
            $validate['address2'] = 'required|max:100';
            $dataUpdate['address2'] = $data['address2']??'';
        }
        if(sc_config('customer_phone')) {
            $validate['phone'] = 'required|regex:/^0[^0][0-9\-]{7,13}$/';
            $dataUpdate['phone'] = $data['phone']??'';
        }
        if(sc_config('customer_country')) {
            $validate['country'] = 'required|min:2';
            $dataUpdate['country'] = $data['country']??'';
        }
        if(sc_config('customer_postcode')) {
            $validate['postcode'] = 'nullable|min:5';
            $dataUpdate['postcode'] = $data['postcode']??'';
        }
        if(sc_config('customer_company')) {
            $validate['company'] = 'nullable';
            $dataUpdate['company'] = $data['company']??'';
        }   
        if(sc_config('customer_sex')) {
            $validate['sex'] = 'required';
            $dataUpdate['sex'] = $data['sex']??'';
        }   
        if(sc_config('customer_birthday')) {
            $validate['birthday'] = 'nullable|date|date_format:Y-m-d';
            if(!empty($data['birthday'])) {
                $dataUpdate['birthday'] = $data['birthday'];
            }
        } 
        if(sc_config('customer_group')) {
            $validate['group'] = 'nullable';
            $dataUpdate['group'] = $data['group']??1;
        }


        $messages = [
            'last_name.required' => trans('validation.required',['attribute'=> trans('account.last_name')]),
            'first_name.required' => trans('validation.required',['attribute'=> trans('account.first_name')]),
            'email.required' => trans('validation.required',['attribute'=> trans('account.email')]),
            'address1.required' => trans('validation.required',['attribute'=> trans('account.address1')]),
            'address2.required' => trans('validation.required',['attribute'=> trans('account.address2')]),
            'phone.required' => trans('validation.required',['attribute'=> trans('account.phone')]),
            'country.required' => trans('validation.required',['attribute'=> trans('account.country')]),
            'postcode.required' => trans('validation.required',['attribute'=> trans('account.postcode')]),
            'company.required' => trans('validation.required',['attribute'=> trans('account.company')]),
            'sex.required' => trans('validation.required',['attribute'=> trans('account.sex')]),
            'birthday.required' => trans('validation.required',['attribute'=> trans('account.birthday')]),
            'email.email' => trans('validation.email',['attribute'=> trans('account.email')]),
            'phone.regex' => trans('validation.regex',['attribute'=> trans('account.phone')]),
            'postcode.min' => trans('validation.min',['attribute'=> trans('account.postcode')]),
            'country.min' => trans('validation.min',['attribute'=> trans('account.country')]),
            'first_name.max' => trans('validation.max',['attribute'=> trans('account.first_name')]),
            'email.max' => trans('validation.max',['attribute'=> trans('account.email')]),
            'address1.max' => trans('validation.max',['attribute'=> trans('account.address1')]),
            'address2.max' => trans('validation.max',['attribute'=> trans('account.address2')]),
            'last_name.max' => trans('validation.max',['attribute'=> trans('account.last_name')]),
            'birthday.date' => trans('validation.date',['attribute'=> trans('account.birthday')]),
            'birthday.date_format' => trans('validation.date_format',['attribute'=> trans('account.birthday')]),
        ];

        $v = Validator::make(
            $dataUpdate, 
            $validate, 
            $messages
        );
        if ($v->fails()) {
            return redirect()->back()->withErrors($v->errors());
        }

        ShopUser::updateInfo($dataUpdate, $id);

        return redirect()->route('member.index')
            ->with(['message' => trans('account.update_success')]);
    }

    /**
     * Render order list
     * @return [view]
     */
    public function orderList()
    {
        $statusOrder = ShopOrderStatus::pluck('name', 'id')->all();
        return view($this->templatePath . '.account.order_list')
            ->with(
                [
                'title' => trans('account.order_list'),
                'statusOrder' => $statusOrder,
                'layout_page' => 'shop_profile',
                ]
            );
    }

}
