<?php

namespace App\Http\Controllers\Auth;
use App\Models\ShopUser;
use App\Models\ShopCountry;

/**
 * Trait Auth controller.
 */
trait AuthTrait
{

    public function mappingValidator($data) {
        
        $validate = [
            'reg_first_name' => 'required|string|max:100',
            'reg_email' => 'required|string|email|max:255|unique:' . (new ShopUser)->getTable() . ',email',
            'reg_password' => 'required|string|min:6',
            'reg_address1' => 'required|string|max:255',
        ];
        if(sc_config('customer_lastname')) {
            $validate['reg_last_name'] = 'required|max:100';
        }
        if(sc_config('customer_address2')) {
            $validate['reg_address2'] = 'required|max:100';
        }
        if(sc_config('customer_phone')) {
            $validate['reg_phone'] = 'required|regex:/^0[^0][0-9\-]{7,13}$/';
        }
        if(sc_config('customer_country')) {
            $arraycountry = (new ShopCountry)->pluck('code')->toArray();
            $validate['reg_country'] = 'required|min:2|in:'. implode(',', $arraycountry);
        }
        if(sc_config('customer_postcode')) {
            $validate['reg_postcode'] = 'nullable|min:5';
        }
        if(sc_config('customer_company')) {
            $validate['reg_company'] = 'nullable';
        }   
        if(sc_config('customer_sex')) {
            $validate['reg_sex'] = 'required';
        }   
        if(sc_config('customer_birthday')) {
            $validate['reg_birthday'] = 'nullable|date|date_format:Y-m-d';
        } 
        if(sc_config('customer_group')) {
            $validate['reg_group'] = 'nullable';
        }
        $messages = [
            'reg_last_name.required' => trans('validation.required',['attribute'=> trans('customer.last_name')]),
            'reg_first_name.required' => trans('validation.required',['attribute'=> trans('customer.first_name')]),
            'reg_email.required' => trans('validation.required',['attribute'=> trans('customer.email')]),
            'reg_password.required' => trans('validation.required',['attribute'=> trans('customer.password')]),
            'reg_address1.required' => trans('validation.required',['attribute'=> trans('customer.address1')]),
            'reg_address2.required' => trans('validation.required',['attribute'=> trans('customer.address2')]),
            'reg_phone.required' => trans('validation.required',['attribute'=> trans('customer.phone')]),
            'reg_country.required' => trans('validation.required',['attribute'=> trans('customer.country')]),
            'reg_postcode.required' => trans('validation.required',['attribute'=> trans('customer.postcode')]),
            'reg_company.required' => trans('validation.required',['attribute'=> trans('customer.company')]),
            'reg_sex.required' => trans('validation.required',['attribute'=> trans('customer.sex')]),
            'reg_birthday.required' => trans('validation.required',['attribute'=> trans('customer.birthday')]),
            'reg_email.email' => trans('validation.email',['attribute'=> trans('customer.email')]),
            'reg_phone.regex' => trans('validation.regex',['attribute'=> trans('customer.phone')]),
            'reg_password.confirmed' => trans('validation.confirmed',['attribute'=> trans('customer.password')]),
            'reg_postcode.min' => trans('validation.min',['attribute'=> trans('customer.postcode')]),
            'reg_password.min' => trans('validation.min',['attribute'=> trans('customer.password')]),
            'reg_country.min' => trans('validation.min',['attribute'=> trans('customer.country')]),
            'reg_first_name.max' => trans('validation.max',['attribute'=> trans('customer.first_name')]),
            'reg_email.max' => trans('validation.max',['attribute'=> trans('customer.email')]),
            'reg_address1.max' => trans('validation.max',['attribute'=> trans('customer.address1')]),
            'reg_address2.max' => trans('validation.max',['attribute'=> trans('customer.address2')]),
            'reg_last_name.max' => trans('validation.max',['attribute'=> trans('customer.last_name')]),
            'reg_birthday.date' => trans('validation.date',['attribute'=> trans('customer.birthday')]),
            'reg_birthday.date_format' => trans('validation.date_format',['attribute'=> trans('customer.birthday')]),
        ];
        $dataMap = [
            'validate' => $validate,
            'messages' => $messages
        ];
        return $dataMap;
    }


    public function mappDataInsert($data) {
        $dataMap = [
            'first_name' => $data['reg_first_name'],
            'last_name' => $data['reg_last_name']??'',
            'email' => $data['reg_email'],
            'password' => bcrypt($data['reg_password']),
            'phone' => $data['reg_phone']??null,
            'address1' => $data['reg_address1'],
            'address2' => $data['reg_address2']??'',
            'country' => $data['reg_country']??'VN',
            'group' => $data['reg_group']??1,
            'sex' => $data['reg_sex']??0,
            'postcode' => $data['reg_postcode']??null,
        ];
        if(!empty($data['reg_birthday'])) {
            $dataMap['birthday'] = $data['reg_birthday'];
        }
        return $dataMap;
    }

}
