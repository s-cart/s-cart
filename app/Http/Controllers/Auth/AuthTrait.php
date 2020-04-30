<?php

namespace App\Http\Controllers\Auth;
use App\Models\ShopUser;
use App\Models\ShopCountry;

/**
 * Trait Auth controller.
 */
trait AuthTrait
{
    /**
     * Map validate when edit customer
     *
     * @param   [array]  $data  [$data description]
     *
     * @return  [array]         [return description]
     */
    public function mappingValidatorEdit($data) {
        $dataUpdate = [
            'first_name' => $data['first_name'],
            'address1' => $data['address1'],
        ];
        $validate = [
            'first_name' => 'required|string|max:100',
            'address1' => 'required|string|max:255',
            'password' => 'nullable|string|min:6',
        ];

        if (!empty($data['password'])) {
            $dataUpdate['password'] = bcrypt($data['password']);
        }
        if (!empty($data['email'])) {
            $dataUpdate['email'] = $data['email'];
            $validate['email'] = 'required|string|email|max:255|unique:' . (new ShopUser)->getTable() . ',email, '.$data['id'].',id';
        }
        //Dont update id
        unset($data['id']);

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
            $arraycountry = (new ShopCountry)->pluck('code')->toArray();
            $validate['country'] = 'required|min:2|in:'. implode(',', $arraycountry);
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
            $dataUpdate['birthday'] = $data['birthday']??'';
        } 
        if(sc_config('customer_group')) {
            $validate['group'] = 'nullable|integer|max:10';
            $dataUpdate['group'] = $data['group']?? 0;
        }
        $messages = [
            'last_name.required' => trans('validation.required',['attribute'=> trans('customer.last_name')]),
            'first_name.required' => trans('validation.required',['attribute'=> trans('customer.first_name')]),
            'email.required' => trans('validation.required',['attribute'=> trans('customer.email')]),
            'password.required' => trans('validation.required',['attribute'=> trans('customer.password')]),
            'address1.required' => trans('validation.required',['attribute'=> trans('customer.address1')]),
            'address2.required' => trans('validation.required',['attribute'=> trans('customer.address2')]),
            'phone.required' => trans('validation.required',['attribute'=> trans('customer.phone')]),
            'country.required' => trans('validation.required',['attribute'=> trans('customer.country')]),
            'postcode.required' => trans('validation.required',['attribute'=> trans('customer.postcode')]),
            'company.required' => trans('validation.required',['attribute'=> trans('customer.company')]),
            'sex.required' => trans('validation.required',['attribute'=> trans('customer.sex')]),
            'birthday.required' => trans('validation.required',['attribute'=> trans('customer.birthday')]),
            'email.email' => trans('validation.email',['attribute'=> trans('customer.email')]),
            'phone.regex' => trans('validation.regex',['attribute'=> trans('customer.phone')]),
            'password.confirmed' => trans('validation.confirmed',['attribute'=> trans('customer.password')]),
            'postcode.min' => trans('validation.min',['attribute'=> trans('customer.postcode')]),
            'password.min' => trans('validation.min',['attribute'=> trans('customer.password')]),
            'country.min' => trans('validation.min',['attribute'=> trans('customer.country')]),
            'first_name.max' => trans('validation.max',['attribute'=> trans('customer.first_name')]),
            'email.max' => trans('validation.max',['attribute'=> trans('customer.email')]),
            'address1.max' => trans('validation.max',['attribute'=> trans('customer.address1')]),
            'address2.max' => trans('validation.max',['attribute'=> trans('customer.address2')]),
            'last_name.max' => trans('validation.max',['attribute'=> trans('customer.last_name')]),
            'birthday.date' => trans('validation.date',['attribute'=> trans('customer.birthday')]),
            'birthday.date_format' => trans('validation.date_format',['attribute'=> trans('customer.birthday')]),
        ];
        $dataMap = [
            'validate' => $validate,
            'messages' => $messages,
            'dataUpdate' => $dataUpdate
        ];
        return $dataMap;
    }

    /**
     * Mapp validate when register new customer
     *
     * @param   [array]  $data  [$data description]
     *
     * @return  [array]         [return description]
     */
    public function mappingValidator($data) {
        $dataInsert = $this->mappDataInsert($data);
        $validate = [
            'first_name' => 'required|string|max:100',
            'email' => 'required|string|email|max:255|unique:' . (new ShopUser)->getTable() . ',email',
            'password' => 'required|string|min:6',
            'address1' => 'required|string|max:255',
        ];
        if(sc_config('customer_lastname')) {
            $validate['last_name'] = 'required|max:100';
        }
        if(sc_config('customer_address2')) {
            $validate['address2'] = 'required|max:100';
        }
        if(sc_config('customer_phone')) {
            $validate['phone'] = 'required|regex:/^0[^0][0-9\-]{7,13}$/';
        }
        if(sc_config('customer_country')) {
            $arraycountry = (new ShopCountry)->pluck('code')->toArray();
            $validate['country'] = 'required|min:2|in:'. implode(',', $arraycountry);
        }
        if(sc_config('customer_postcode')) {
            $validate['postcode'] = 'nullable|min:5';
        }
        if(sc_config('customer_company')) {
            $validate['company'] = 'nullable';
        }   
        if(sc_config('customer_sex')) {
            $validate['sex'] = 'required';
        }   
        if(sc_config('customer_birthday')) {
            $validate['birthday'] = 'nullable|date|date_format:Y-m-d';
        } 
        if(sc_config('customer_group')) {
            $validate['group'] = 'nullable|integer|max:10';
        }
        $messages = [
            'last_name.required' => trans('validation.required',['attribute'=> trans('customer.last_name')]),
            'first_name.required' => trans('validation.required',['attribute'=> trans('customer.first_name')]),
            'email.required' => trans('validation.required',['attribute'=> trans('customer.email')]),
            'password.required' => trans('validation.required',['attribute'=> trans('customer.password')]),
            'address1.required' => trans('validation.required',['attribute'=> trans('customer.address1')]),
            'address2.required' => trans('validation.required',['attribute'=> trans('customer.address2')]),
            'phone.required' => trans('validation.required',['attribute'=> trans('customer.phone')]),
            'country.required' => trans('validation.required',['attribute'=> trans('customer.country')]),
            'postcode.required' => trans('validation.required',['attribute'=> trans('customer.postcode')]),
            'company.required' => trans('validation.required',['attribute'=> trans('customer.company')]),
            'sex.required' => trans('validation.required',['attribute'=> trans('customer.sex')]),
            'birthday.required' => trans('validation.required',['attribute'=> trans('customer.birthday')]),
            'email.email' => trans('validation.email',['attribute'=> trans('customer.email')]),
            'phone.regex' => trans('validation.regex',['attribute'=> trans('customer.phone')]),
            'password.confirmed' => trans('validation.confirmed',['attribute'=> trans('customer.password')]),
            'postcode.min' => trans('validation.min',['attribute'=> trans('customer.postcode')]),
            'password.min' => trans('validation.min',['attribute'=> trans('customer.password')]),
            'country.min' => trans('validation.min',['attribute'=> trans('customer.country')]),
            'first_name.max' => trans('validation.max',['attribute'=> trans('customer.first_name')]),
            'email.max' => trans('validation.max',['attribute'=> trans('customer.email')]),
            'address1.max' => trans('validation.max',['attribute'=> trans('customer.address1')]),
            'address2.max' => trans('validation.max',['attribute'=> trans('customer.address2')]),
            'last_name.max' => trans('validation.max',['attribute'=> trans('customer.last_name')]),
            'birthday.date' => trans('validation.date',['attribute'=> trans('customer.birthday')]),
            'birthday.date_format' => trans('validation.date_format',['attribute'=> trans('customer.birthday')]),
        ];
        $dataMap = [
            'validate' => $validate,
            'messages' => $messages,
            'dataInsert' => $dataInsert
        ];
        return $dataMap;
    }

    /**
     * Mapping data before inser
     *
     * @param   [type]  $data  [$data description]
     *
     * @return  [type]         [return description]
     */
    public function mappDataInsert($data){
        return  
        [
            'first_name' => $data['first_name'],
            'last_name' => $data['last_name']??'',
            'email' => $data['email'],
            'password' => bcrypt($data['password']),
            'phone' => $data['phone']??null,
            'address1' => $data['address1'],
            'address2' => $data['address2']??'',
            'country' => $data['country']??'VN',
            'group' => $data['group']??1,
            'sex' => $data['sex']??0,
            'postcode' => $data['postcode']??null,
            'birthday' => $data['birthday']??null,
        ];
    }
}
