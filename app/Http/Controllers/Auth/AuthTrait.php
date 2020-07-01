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
        ];
        $validate = [
            'first_name' => 'required|string|max:100',
            'password' => 'nullable|string|min:6',
        ];

        if (!empty($data['password'])) {
            $dataUpdate['password'] = bcrypt($data['password']);
        }
        if (!empty($data['email'])) {
            $dataUpdate['email'] = $data['email'];
            $validate['email'] = 'required|string|email|max:255|unique:"'.ShopUser::class.'",email, '.$data['id'].',id';
        }
        //Dont update id
        unset($data['id']);

        if(sc_config('customer_lastname')) {
            $validate['last_name'] = 'required|string|max:100';
            $dataUpdate['last_name'] = $data['last_name']??'';
        }
        if(sc_config('customer_address1')) {
            $validate['address1'] = 'required|string|max:100';
            $dataUpdate['address1'] = $data['address1']??'';
        }

        if(sc_config('customer_address2')) {
            $validate['address2'] = 'required|string|max:100';
            $dataUpdate['address2'] = $data['address2']??'';
        }
        if(sc_config('customer_phone')) {
            $validate['phone'] = 'required|regex:/^0[^0][0-9\-]{7,13}$/';
            $dataUpdate['phone'] = $data['phone']??'';
        }
        if(sc_config('customer_country')) {
            $arraycountry = (new ShopCountry)->pluck('code')->toArray();
            $validate['country'] = 'required|string|min:2|in:'. implode(',', $arraycountry);
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
            'reg_first_name' => 'required|string|max:100',
            'reg_email' => 'required|string|email|max:255|unique:"'.ShopUser::class.'",email',
            'reg_password' => 'required|string|min:6',
        ];
        if(sc_config('customer_lastname')) {
            $validate['reg_last_name'] = 'required|string|max:100';
        }
        if(sc_config('customer_address1')) {
            $validate['reg_address1'] = 'required|string|max:100';
        }
        if(sc_config('customer_address2')) {
            $validate['reg_address2'] = 'required|string|max:100';
        }
        if(sc_config('customer_phone')) {
            $validate['reg_phone'] = 'required|regex:/^0[^0][0-9\-]{7,13}$/';
        }
        if(sc_config('customer_country')) {
            $arraycountry = (new ShopCountry)->pluck('code')->toArray();
            $validate['reg_country'] = 'required|string|min:2|in:'. implode(',', $arraycountry);
        }
        if(sc_config('customer_postcode')) {
            $validate['reg_postcode'] = 'nullable|string|min:5';
        }
        if(sc_config('customer_company')) {
            $validate['reg_company'] = 'nullable|string|min:100';
        }   
        if(sc_config('customer_sex')) {
            $validate['reg_sex'] = 'required|integer';
        }   
        if(sc_config('customer_birthday')) {
            $validate['reg_birthday'] = 'nullable|date|date_format:Y-m-d';
        } 
        if(sc_config('customer_group')) {
            $validate['reg_group'] = 'nullable|integer|max:10';
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
    public function mappDataInsert($data) {

        $dataInsert = [
            'first_name' => $data['reg_first_name'],
            'email' => $data['reg_email'],
            'password' => bcrypt($data['reg_password']),
        ];
        if(sc_config('customer_lastname')) {
            $dataInsert['last_name'] = $data['reg_last_name'] ?? '';
        }
        if(sc_config('customer_address1')) {
            $dataInsert['address1'] = $data['reg_address1'] ?? '';
        }
        if(sc_config('customer_address2')) {
            $dataInsert['address2'] = $data['reg_address2'] ?? '';
        }
        if(sc_config('customer_phone')) {
            $dataInsert['phone'] =  $data['reg_phone'] ?? '';
        }
        if(sc_config('customer_country')) {
            $dataInsert['country'] = $data['reg_country'] ?? '';
        }
        if(sc_config('customer_postcode')) {
            $dataInsert['postcode'] = $data['reg_postcode'] ?? '';
        }
        if(sc_config('customer_company')) {
            $dataInsert['company'] = $data['reg_company'] ?? '';
        }   
        if(sc_config('customer_sex')) {
            $dataInsert['sex'] = $data['reg_sex'] ?? 0;
        }   
        if(sc_config('customer_birthday')) {
            $dataInsert['birthday'] =  $dataInsert['reg_birthday'] ?? '';
        } 
        if(sc_config('customer_group')) {
            $dataInsert['group'] = $data['reg_group'] ?? 1;
        }
        return $dataInsert;
    }
}
