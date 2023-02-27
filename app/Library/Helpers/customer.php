<?php
use App\Pmo\Front\Models\ShopCustomer;
use App\Pmo\Front\Models\ShopCustomField;
use App\Pmo\Front\Models\ShopCountry;

/**
 * Send email reset password
 */
if (!function_exists('sc_customer_sendmail_reset_notification') && !in_array('sc_customer_sendmail_reset_notification', config('helper_except', []))) {
    function sc_customer_sendmail_reset_notification(string $token, string $emailReset)
    {
        $checkContent = (new \App\Pmo\Front\Models\ShopEmailTemplate)->where('group', 'forgot_password')->where('status', 1)->first();
        if ($checkContent) {
            $content = $checkContent->text;
            $dataFind = [
                '/\{\{\$title\}\}/',
                '/\{\{\$reason_sendmail\}\}/',
                '/\{\{\$note_sendmail\}\}/',
                '/\{\{\$note_access_link\}\}/',
                '/\{\{\$reset_link\}\}/',
                '/\{\{\$reset_button\}\}/',
            ];
            $url = sc_route('password.reset', ['token' => $token]);
            $dataReplace = [
                sc_language_render('email.forgot_password.title'),
                sc_language_render('email.forgot_password.reason_sendmail'),
                sc_language_render('email.forgot_password.note_sendmail', ['count' => config('auth.passwords.'.config('auth.defaults.passwords').'.expire')]),
                sc_language_render('email.forgot_password.note_access_link', ['reset_button' => sc_language_render('email.forgot_password.reset_button'), 'url' => $url]),
                $url,
                sc_language_render('email.forgot_password.reset_button'),
            ];
            $content = preg_replace($dataFind, $dataReplace, $content);
            $dataView = [
                'content' => $content,
            ];

            $config = [
                'to' => $emailReset,
                'subject' => sc_language_render('email.forgot_password.reset_button'),
            ];

            sc_send_mail('templates.' . sc_store('template') . '.mail.forgot_password', $dataView, $config, $dataAtt = []);
        }
    }
}


/**
 * Send email verify
 */
if (!function_exists('sc_customer_sendmail_verify') && !in_array('sc_customer_sendmail_verify', config('helper_except', []))) {
    function sc_customer_sendmail_verify(string $emailVerify, string $userId)
    {
        $url = \Illuminate\Support\Facades\URL::temporarySignedRoute(
            'customer.verify_process',
            \Carbon\Carbon::now()->addMinutes(config('auth.verification', 60)),
            [
                'id' => $userId,
                'token' => sha1($emailVerify),
            ]
        );

        $checkContent = (new \App\Pmo\Front\Models\ShopEmailTemplate)->where('group', 'customer_verify')->where('status', 1)->first();
        if ($checkContent) {
            $content = $checkContent->text;
            $dataFind = [
                '/\{\{\$title\}\}/',
                '/\{\{\$reason_sendmail\}\}/',
                '/\{\{\$note_sendmail\}\}/',
                '/\{\{\$note_access_link\}\}/',
                '/\{\{\$url_verify\}\}/',
                '/\{\{\$button\}\}/',
            ];
            $dataReplace = [
                sc_language_render('email.verification_content.title'),
                sc_language_render('email.verification_content.reason_sendmail'),
                sc_language_render('email.verification_content.note_sendmail', ['count' => config('auth.verification')]),
                sc_language_render('email.verification_content.note_access_link', ['reset_button' => sc_language_render('customer.verify_email.button_verify'), 'url' => $url]),
                $url,
                sc_language_render('customer.verify_email.button_verify'),
            ];
            $content = preg_replace($dataFind, $dataReplace, $content);
            $dataView = [
                'content' => $content,
            ];

            $config = [
                'to' => $emailVerify,
                'subject' => sc_language_render('customer.verify_email.button_verify'),
            ];

            sc_send_mail('templates.' . sc_store('template') . '.mail.customer_verify', $dataView, $config, $dataAtt = []);
            return true;
        }
    }
}

/**
 * Send email welcome
 */
if (!function_exists('sc_customer_sendmail_welcome') && !in_array('sc_customer_sendmail_welcome', config('helper_except', []))) {
    function sc_customer_sendmail_welcome(array $data)
    {
        if (sc_config('welcome_customer')) {
            $checkContent = (new \App\Pmo\Front\Models\ShopEmailTemplate)->where('group', 'welcome_customer')->where('status', 1)->first();
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
                    '/\{\{\$address3\}\}/',
                    '/\{\{\$country\}\}/',
                ];
                $dataReplace = [
                    sc_language_render('email.welcome_customer.title'),
                    $data['first_name'] ?? '',
                    $data['last_name'] ?? '',
                    $data['email'] ?? '',
                    $data['phone'] ?? '',
                    $data['password'] ?? '',
                    $data['address1'] ?? '',
                    $data['address2'] ?? '',
                    $data['address3'] ?? '',
                    $data['country'] ?? '',
                ];
                $content = preg_replace($dataFind, $dataReplace, $content);
                $dataView = [
                    'content' => $content,
                ];

                $config = [
                    'to' => $data['email'],
                    'subject' => sc_language_render('email.welcome_customer.title'),
                ];

                sc_send_mail('templates.' . sc_store('template') . '.mail.welcome_customer', $dataView, $config, []);
            }
        }
    }
}

/**
 * Mapping data address of customer
 *
 * @param   [type]  $dataRaw  [$dataRaw description]
 *
 * @return  [array]              [return description]
 */
if (!function_exists('sc_customer_address_mapping') && !in_array('sc_customer_address_mapping', config('helper_except', []))) {
    function sc_customer_address_mapping(array $dataRaw)
    {
        $dataAddress = [
            'first_name' => $dataRaw['first_name'] ?? '',
            'address1' => $dataRaw['address1'] ?? '',
        ];
        $validate = [
            'first_name' => config('validation.customer.first_name', 'required|string|max:100'),
            'address1' => config('validation.customer.address1_required', 'required|string|max:100'),
        ];
        if (sc_config('customer_lastname')) {
            $validate['last_name'] = config('validation.customer.last_name_required', 'required|string|max:100');
            $dataAddress['last_name'] = $dataRaw['last_name']??'';
        }
        if (sc_config('customer_address2')) {
            $validate['address2'] = config('validation.customer.address2_required', 'required|string|max:100');
            $dataAddress['address2'] = $dataRaw['address2']??'';
        }
        if (sc_config('customer_address3')) {
            $validate['address3'] = config('validation.customer.address3_required', 'required|string|max:100');
            $dataAddress['address3'] = $dataRaw['address3']??'';
        }
        if (sc_config('customer_phone')) {
            $validate['phone'] = config('validation.customer.phone_required', 'required|regex:/^0[^0][0-9\-]{6,12}$/');
            $dataAddress['phone'] = $dataRaw['phone']??'';
        }
        if (sc_config('customer_country')) {
            $validate['country'] = config('validation.customer.country_required', 'required|string|min:2');
            $dataAddress['country'] = $dataRaw['country']??'';
        }
        if (sc_config('customer_postcode')) {
            $validate['postcode'] = config('validation.customer.postcode_null', 'nullable|min:5');
            $dataAddress['postcode'] = $dataRaw['postcode']??'';
        }

        $messages = [
            'last_name.required'  => sc_language_render('validation.required', ['attribute'=> sc_language_render('customer.last_name')]),
            'first_name.required' => sc_language_render('validation.required', ['attribute'=> sc_language_render('customer.first_name')]),
            'address1.required'   => sc_language_render('validation.required', ['attribute'=> sc_language_render('customer.address1')]),
            'address2.required'   => sc_language_render('validation.required', ['attribute'=> sc_language_render('customer.address2')]),
            'address3.required'   => sc_language_render('validation.required', ['attribute'=> sc_language_render('customer.address3')]),
            'phone.required'      => sc_language_render('validation.required', ['attribute'=> sc_language_render('customer.phone')]),
            'country.required'    => sc_language_render('validation.required', ['attribute'=> sc_language_render('customer.country')]),
            'postcode.required'   => sc_language_render('validation.required', ['attribute'=> sc_language_render('customer.postcode')]),
            'phone.regex'         => sc_language_render('customer.phone_regex'),
            'postcode.min'        => sc_language_render('validation.min', ['attribute'=> sc_language_render('customer.postcode')]),
            'country.min'         => sc_language_render('validation.min', ['attribute'=> sc_language_render('customer.country')]),
            'first_name.max'      => sc_language_render('validation.max', ['attribute'=> sc_language_render('customer.first_name')]),
            'address1.max'        => sc_language_render('validation.max', ['attribute'=> sc_language_render('customer.address1')]),
            'address2.max'        => sc_language_render('validation.max', ['attribute'=> sc_language_render('customer.address2')]),
            'address3.max'        => sc_language_render('validation.max', ['attribute'=> sc_language_render('customer.address3')]),
            'last_name.max'       => sc_language_render('validation.max', ['attribute'=> sc_language_render('customer.last_name')]),
        ];

        $dataMap = [
            'validate' => $validate,
            'messages' => $messages,
            'dataAddress' => $dataAddress
        ];
        return $dataMap;
    }
}


/**
 * Mapping data customer before insert
 *
 * @param   [array]  $dataRaw  [$dataRaw description]
 *
 * @return  [array]              [return description]
 */
if (!function_exists('sc_customer_data_insert_mapping') && !in_array('sc_customer_data_insert_mapping', config('helper_except', []))) {
    function sc_customer_data_insert_mapping(array $dataRaw)
    {
        $dataInsert = [
            'first_name' => $dataRaw['first_name'] ?? '',
            'email' => $dataRaw['email'],
            'password' => bcrypt($dataRaw['password']),
        ];

        $validate = [
            'first_name' => config('validation.customer.first_name', 'required|string|max:100'),
            'email' => config('validation.customer.email', 'required|string|email|max:255').'|unique:"'.ShopCustomer::class.'",email',
            'password' => config('validation.customer.password_confirm', 'required|confirmed|string|min:6'),
        ];

        if (isset($dataRaw['status'])) {
            $dataInsert['status']  = $dataRaw['status'];
        }

        //Custom fields
        $customFields = (new ShopCustomField)->getCustomField($type = 'shop_customer');
        if ($customFields) {
            foreach ($customFields as $field) {
                if ($field->required) {
                    $validate['fields.'.$field->code] = 'required';
                }
            }
        }

        if (sc_config('customer_lastname')) {
            if (sc_config('customer_lastname_required')) {
                $validate['last_name'] = config('validation.customer.last_name_required', 'required|string|max:100');
            } else {
                $validate['last_name'] = config('validation.customer.last_name_null', 'nullable|string|max:100');
            }
            if (!empty($dataRaw['last_name'])) {
                $dataInsert['last_name'] = $dataRaw['last_name'];
            }
        }

        if (sc_config('customer_address1')) {
            if (sc_config('customer_address1_required')) {
                $validate['address1'] = config('validation.customer.address1_required', 'required|string|max:100');
            } else {
                $validate['address1'] = config('validation.customer.address1_null', 'nullable|string|max:100');
            }
            if (!empty($dataRaw['address1'])) {
                $dataInsert['address1'] = $dataRaw['address1'];
            }
        }

        if (sc_config('customer_address2')) {
            if (sc_config('customer_address2_required')) {
                $validate['address2'] = config('validation.customer.address2_required', 'required|string|max:100');
            } else {
                $validate['address2'] = config('validation.customer.address2_null', 'nullable|string|max:100');
            }
            if (!empty($dataRaw['address2'])) {
                $dataInsert['address2'] = $dataRaw['address2'];
            }
        }

        if (sc_config('customer_address3')) {
            if (sc_config('customer_address3_required')) {
                $validate['address3'] = config('validation.customer.address3_required', 'required|string|max:100');
            } else {
                $validate['address3'] = config('validation.customer.address3_null', 'nullable|string|max:100');
            }
            if (!empty($dataRaw['address3'])) {
                $dataInsert['address3'] = $dataRaw['address3'];
            }
        }


        if (sc_config('customer_phone')) {
            if (sc_config('customer_phone_required')) {
                $validate['phone'] = config('validation.customer.phone_required', 'regex:/^0[^0][0-9\-]{6,12}$/');
            } else {
                $validate['phone'] = config('validation.customer.phone_null', 'nullable|regex:/^0[^0][0-9\-]{6,12}$/');
            }
            if (!empty($dataRaw['phone'])) {
                $dataInsert['phone'] = $dataRaw['phone'];
            }
        }

        if (sc_config('customer_country')) {
            $arraycountry = (new ShopCountry)->pluck('code')->toArray();
            if (sc_config('customer_country_required')) {
                $validate['country'] = config('validation.customer.country_required', 'required|string|min:2').'|in:'. implode(',', $arraycountry);
            } else {
                $validate['country'] = config('validation.customer.country_null', 'nullable|string|min:2').'|in:'. implode(',', $arraycountry);
            }
            if (!empty($dataRaw['country'])) {
                $dataInsert['country'] = $dataRaw['country'];
            }
        }

        if (sc_config('customer_postcode')) {
            if (sc_config('customer_postcode_required')) {
                $validate['postcode'] = config('validation.customer.postcode_required', 'required|min:5');
            } else {
                $validate['postcode'] = config('validation.customer.postcode_null', 'nullable|min:5');
            }
            if (!empty($dataRaw['postcode'])) {
                $dataInsert['postcode'] = $dataRaw['postcode'];
            }
        }

        if (sc_config('customer_company')) {
            if (sc_config('customer_company_required')) {
                $validate['company'] = config('validation.customer.company_required', 'required|string|max:100');
            } else {
                $validate['company'] = config('validation.customer.company_null', 'nullable|string|max:100');
            }
            if (!empty($dataRaw['company'])) {
                $dataInsert['company'] = $dataRaw['company'];
            }
        }

        if (sc_config('customer_sex')) {
            if (sc_config('customer_sex_required')) {
                $validate['sex'] = config('validation.customer.sex_required', 'required|integer|max:10');
            } else {
                $validate['sex'] = config('validation.customer.sex_null', 'nullable|integer|max:10');
            }
            if (!empty($dataRaw['sex'])) {
                $dataInsert['sex'] = $dataRaw['sex'];
            }
        }

        if (sc_config('customer_birthday')) {
            if (sc_config('customer_birthday_required')) {
                $validate['birthday'] = config('validation.customer.birthday_required', 'required|date|date_format:Y-m-d');
            } else {
                $validate['birthday'] = config('validation.customer.birthday_null', 'nullable|date|date_format:Y-m-d');
            }
            if (!empty($dataRaw['birthday'])) {
                $dataInsert['birthday'] = $dataRaw['birthday'];
            }
        }

        if (sc_config('customer_group')) {
            if (sc_config('customer_group_required')) {
                $validate['group'] = config('validation.customer.group_required', 'required|integer|max:10');
            } else {
                $validate['group'] = config('validation.customer.group_null', 'nullable|integer|max:10');
            }
            if (!empty($dataRaw['group'])) {
                $dataInsert['group'] = $dataRaw['group'];
            }
        }

        if (sc_config('customer_name_kana')) {
            if (sc_config('customer_name_kana_required')) {
                $validate['first_name_kana'] = config('validation.customer.name_kana_required', 'required|string|max:100');
                $validate['last_name_kana'] = config('validation.customer.name_kana_required', 'required|string|max:100');
            } else {
                $validate['first_name_kana'] = config('validation.customer.name_kana_null', 'nullable|string|max:100');
                $validate['last_name_kana'] = config('validation.customer.name_kana_null', 'nullable|string|max:100');
            }
            if (!empty($dataRaw['first_name_kana'])) {
                $dataInsert['first_name_kana'] = $dataRaw['first_name_kana'];
            }
            if (!empty($dataRaw['last_name_kana'])) {
                $dataInsert['last_name_kana'] = $dataRaw['last_name_kana'];
            }
        }

        if (!empty($dataRaw['fields'])) {
            $dataInsert['fields'] = $dataRaw['fields'];
        }

        $messages = [
            'last_name.required'   => sc_language_render('validation.required', ['attribute'=> sc_language_render('customer.last_name')]),
            'first_name.required'  => sc_language_render('validation.required', ['attribute'=> sc_language_render('customer.first_name')]),
            'email.required'       => sc_language_render('validation.required', ['attribute'=> sc_language_render('customer.email')]),
            'password.required'    => sc_language_render('validation.required', ['attribute'=> sc_language_render('customer.password')]),
            'address1.required'    => sc_language_render('validation.required', ['attribute'=> sc_language_render('customer.address1')]),
            'address2.required'    => sc_language_render('validation.required', ['attribute'=> sc_language_render('customer.address2')]),
            'address3.required'    => sc_language_render('validation.required', ['attribute'=> sc_language_render('customer.address3')]),
            'phone.required'       => sc_language_render('validation.required', ['attribute'=> sc_language_render('customer.phone')]),
            'country.required'     => sc_language_render('validation.required', ['attribute'=> sc_language_render('customer.country')]),
            'postcode.required'    => sc_language_render('validation.required', ['attribute'=> sc_language_render('customer.postcode')]),
            'company.required'     => sc_language_render('validation.required', ['attribute'=> sc_language_render('customer.company')]),
            'sex.required'         => sc_language_render('validation.required', ['attribute'=> sc_language_render('customer.sex')]),
            'birthday.required'    => sc_language_render('validation.required', ['attribute'=> sc_language_render('customer.birthday')]),
            'email.email'          => sc_language_render('validation.email', ['attribute'=> sc_language_render('customer.email')]),
            'phone.regex'          => sc_language_render('customer.phone_regex'),
            'password.confirmed'   => sc_language_render('validation.confirmed', ['attribute'=> sc_language_render('customer.password')]),
            'postcode.min'         => sc_language_render('validation.min', ['attribute'=> sc_language_render('customer.postcode')]),
            'password.min'         => sc_language_render('validation.min', ['attribute'=> sc_language_render('customer.password')]),
            'country.min'          => sc_language_render('validation.min', ['attribute'=> sc_language_render('customer.country')]),
            'first_name.max'       => sc_language_render('validation.max', ['attribute'=> sc_language_render('customer.first_name')]),
            'email.max'            => sc_language_render('validation.max', ['attribute'=> sc_language_render('customer.email')]),
            'address1.max'         => sc_language_render('validation.max', ['attribute'=> sc_language_render('customer.address1')]),
            'address2.max'         => sc_language_render('validation.max', ['attribute'=> sc_language_render('customer.address2')]),
            'address3.max'         => sc_language_render('validation.max', ['attribute'=> sc_language_render('customer.address3')]),
            'last_name.max'        => sc_language_render('validation.max', ['attribute'=> sc_language_render('customer.last_name')]),
            'birthday.date'        => sc_language_render('validation.date', ['attribute'=> sc_language_render('customer.birthday')]),
            'birthday.date_format' => sc_language_render('validation.date_format', ['attribute'=> sc_language_render('customer.birthday')]),
        ];
        $dataMap = [
            'validate' => $validate,
            'messages' => $messages,
            'dataInsert' => $dataInsert
        ];
        return $dataMap;
    }
}

/**
 * Mapping data customer before edit
 *
 * @param   [array]  $dataRaw  [$dataRaw description]
 *
 * @return  [array]              [return description]
 */
if (!function_exists('sc_customer_data_edit_mapping') && !in_array('sc_customer_data_edit_mapping', config('helper_except', []))) {
    function sc_customer_data_edit_mapping(array $dataRaw)
    {
        $dataUpdate = [
            'first_name' => $dataRaw['first_name'],
        ];
        if (isset($dataRaw['status'])) {
            $dataUpdate['status']  = $dataRaw['status'];
        }
        $validate = [
            'first_name' => config('validation.customer.first_name', 'required|string|max:100'),
            'password' => config('validation.customer.password_null', 'nullable|string|min:6'),
        ];

        //Custom fields
        $customFields = (new ShopCustomField)->getCustomField($type = 'shop_customer');
        if ($customFields) {
            foreach ($customFields as $field) {
                if ($field->required) {
                    $validate['fields.'.$field->code] = 'required';
                }
            }
            $dataUpdate['fields'] = $dataRaw['fields'] ?? [];
        }

        if (!empty($dataRaw['password'])) {
            $dataUpdate['password'] = bcrypt($dataRaw['password']);
        }
        if (!empty($dataRaw['email'])) {
            $dataUpdate['email'] = $dataRaw['email'];
            $validate['email'] = config('validation.customer.email', 'required|string|email|max:255').'|unique:"'.ShopCustomer::class.'",email,'.$dataRaw['id'].',id';
        }
        //Dont update id
        unset($dataRaw['id']);

        if (sc_config('customer_lastname')) {
            if (sc_config('customer_lastname_required')) {
                $validate['last_name'] = config('validation.customer.last_name_required', 'required|string|max:100');
            } else {
                $validate['last_name'] = config('validation.customer.last_name_null', 'nullable|string|max:100');
            }
            if (!empty($dataRaw['last_name'])) {
                $dataUpdate['last_name'] = $dataRaw['last_name'];
            }
        }
        if (sc_config('customer_address1')) {
            if (sc_config('customer_address1_required')) {
                $validate['address1'] = config('validation.customer.address1_required', 'required|string|max:100');
            } else {
                $validate['address1'] = config('validation.customer.address1_null', 'nullable|string|max:100');
            }
            if (!empty($dataRaw['address1'])) {
                $dataUpdate['address1'] = $dataRaw['address1'];
            }
        }

        if (sc_config('customer_address2')) {
            if (sc_config('customer_address2_required')) {
                $validate['address2'] = config('validation.customer.address2_required', 'required|string|max:100');
            } else {
                $validate['address2'] = config('validation.customer.address2_null', 'nullable|string|max:100');
            }
            if (!empty($dataRaw['address2'])) {
                $dataUpdate['address2'] = $dataRaw['address2'];
            }
        }

        if (sc_config('customer_address3')) {
            if (sc_config('customer_address3_required')) {
                $validate['address3'] = config('validation.customer.address3_required', 'required|string|max:100');
            } else {
                $validate['address3'] = config('validation.customer.address3_null', 'nullable|string|max:100');
            }
            if (!empty($dataRaw['address3'])) {
                $dataUpdate['address3'] = $dataRaw['address3'];
            }
        }


        if (sc_config('customer_phone')) {
            if (sc_config('customer_phone_required')) {
                $validate['phone'] = config('validation.customer.phone_required', 'regex:/^0[^0][0-9\-]{6,12}$/');
            } else {
                $validate['phone'] = config('validation.customer.phone_null', 'nullable|regex:/^0[^0][0-9\-]{6,12}$/');
            }
            if (!empty($dataRaw['phone'])) {
                $dataUpdate['phone'] = $dataRaw['phone'];
            }
        }

        if (sc_config('customer_country')) {
            $arraycountry = (new ShopCountry)->pluck('code')->toArray();
            if (sc_config('customer_country_required')) {
                $validate['country'] = config('validation.customer.country_required', 'required|string|min:2').'|in:'. implode(',', $arraycountry);
            } else {
                $validate['country'] = config('validation.customer.country_null', 'nullable|string|min:2').'|in:'. implode(',', $arraycountry);
            }
            if (!empty($dataRaw['country'])) {
                $dataUpdate['country'] = $dataRaw['country'];
            }
        }

        if (sc_config('customer_postcode')) {
            if (sc_config('customer_postcode_required')) {
                $validate['postcode'] = config('validation.customer.postcode_required', 'required|min:5');
            } else {
                $validate['postcode'] = config('validation.customer.postcode_null', 'nullable|min:5');
            }
            if (!empty($dataRaw['postcode'])) {
                $dataUpdate['postcode'] = $dataRaw['postcode'];
            }
        }

        if (sc_config('customer_company')) {
            if (sc_config('customer_company_required')) {
                $validate['company'] = config('validation.customer.company_required', 'required|string|max:100');
            } else {
                $validate['company'] = config('validation.customer.company_null', 'nullable|string|max:100');
            }
            if (!empty($dataRaw['company'])) {
                $dataUpdate['company'] = $dataRaw['company'];
            }
        }

        if (sc_config('customer_sex')) {
            if (sc_config('customer_sex_required')) {
                $validate['sex'] = config('validation.customer.sex_required', 'required|integer|max:10');
            } else {
                $validate['sex'] = config('validation.customer.sex_null', 'nullable|integer|max:10');
            }
            if (!empty($dataRaw['sex'])) {
                $dataUpdate['sex'] = $dataRaw['sex'];
            }
        }

        if (sc_config('customer_birthday')) {
            if (sc_config('customer_birthday_required')) {
                $validate['birthday'] = config('validation.customer.birthday_required', 'required|date|date_format:Y-m-d');
            } else {
                $validate['birthday'] = config('validation.customer.birthday_null', 'nullable|date|date_format:Y-m-d');
            }
            if (!empty($dataRaw['birthday'])) {
                $dataUpdate['birthday'] = $dataRaw['birthday'];
            }
        }

        if (sc_config('customer_group')) {
            if (sc_config('customer_group_required')) {
                $validate['group'] = config('validation.customer.group_required', 'required|integer|max:10');
            } else {
                $validate['group'] = config('validation.customer.group_null', 'nullable|integer|max:10');
            }
            if (!empty($dataRaw['group'])) {
                $dataUpdate['group'] = $dataRaw['group'];
            }
        }

        if (sc_config('customer_name_kana')) {
            if (sc_config('customer_name_kana_required')) {
                $validate['first_name_kana'] = config('validation.customer.name_kana_required', 'required|string|max:100');
                $validate['last_name_kana'] = config('validation.customer.name_kana_required', 'required|string|max:100');
            } else {
                $validate['first_name_kana'] = config('validation.customer.name_kana_null', 'nullable|string|max:100');
                $validate['last_name_kana'] = config('validation.customer.name_kana_null', 'nullable|string|max:100');
            }
            $dataUpdate['first_name_kana'] = $dataRaw['first_name_kana']?? '';
            $dataUpdate['last_name_kana'] = $dataRaw['last_name_kana']?? '';
        }

        $messages = [
            'last_name.required'   => sc_language_render('validation.required', ['attribute'=> sc_language_render('customer.last_name')]),
            'first_name.required'  => sc_language_render('validation.required', ['attribute'=> sc_language_render('customer.first_name')]),
            'email.required'       => sc_language_render('validation.required', ['attribute'=> sc_language_render('customer.email')]),
            'password.required'    => sc_language_render('validation.required', ['attribute'=> sc_language_render('customer.password')]),
            'address1.required'    => sc_language_render('validation.required', ['attribute'=> sc_language_render('customer.address1')]),
            'address2.required'    => sc_language_render('validation.required', ['attribute'=> sc_language_render('customer.address2')]),
            'address3.required'    => sc_language_render('validation.required', ['attribute'=> sc_language_render('customer.address3')]),
            'phone.required'       => sc_language_render('validation.required', ['attribute'=> sc_language_render('customer.phone')]),
            'country.required'     => sc_language_render('validation.required', ['attribute'=> sc_language_render('customer.country')]),
            'postcode.required'    => sc_language_render('validation.required', ['attribute'=> sc_language_render('customer.postcode')]),
            'company.required'     => sc_language_render('validation.required', ['attribute'=> sc_language_render('customer.company')]),
            'sex.required'         => sc_language_render('validation.required', ['attribute'=> sc_language_render('customer.sex')]),
            'birthday.required'    => sc_language_render('validation.required', ['attribute'=> sc_language_render('customer.birthday')]),
            'email.email'          => sc_language_render('validation.email', ['attribute'=> sc_language_render('customer.email')]),
            'phone.regex'          => sc_language_render('customer.phone_regex'),
            'password.confirmed'   => sc_language_render('validation.confirmed', ['attribute'=> sc_language_render('customer.password')]),
            'postcode.min'         => sc_language_render('validation.min', ['attribute'=> sc_language_render('customer.postcode')]),
            'password.min'         => sc_language_render('validation.min', ['attribute'=> sc_language_render('customer.password')]),
            'country.min'          => sc_language_render('validation.min', ['attribute'=> sc_language_render('customer.country')]),
            'first_name.max'       => sc_language_render('validation.max', ['attribute'=> sc_language_render('customer.first_name')]),
            'email.max'            => sc_language_render('validation.max', ['attribute'=> sc_language_render('customer.email')]),
            'address1.max'         => sc_language_render('validation.max', ['attribute'=> sc_language_render('customer.address1')]),
            'address2.max'         => sc_language_render('validation.max', ['attribute'=> sc_language_render('customer.address2')]),
            'address3.max'         => sc_language_render('validation.max', ['attribute'=> sc_language_render('customer.address3')]),
            'last_name.max'        => sc_language_render('validation.max', ['attribute'=> sc_language_render('customer.last_name')]),
            'birthday.date'        => sc_language_render('validation.date', ['attribute'=> sc_language_render('customer.birthday')]),
            'birthday.date_format' => sc_language_render('validation.date_format', ['attribute'=> sc_language_render('customer.birthday')]),
        ];
        $dataMap = [
            'validate' => $validate,
            'messages' => $messages,
            'dataUpdate' => $dataUpdate
        ];
        return $dataMap;
    }
}

/**
 * Process after customer created by client
 */
if (!function_exists('sc_customer_created_by_client') && !in_array('sc_customer_created_by_client', config('helper_except', []))) {
    function sc_customer_created_by_client(ShopCustomer $user, array $dataMap)
    {
        //Send email welcome
        sc_customer_sendmail_welcome($dataMap);

        //Send email verify
        $user->sendEmailVerify();
    }
}

/**
 * Process after customer created by admin
 */
if (!function_exists('sc_customer_created_by_admin') && !in_array('sc_customer_created_by_admin', config('helper_except', []))) {
    function sc_customer_created_by_admin(ShopCustomer $user, array $dataMap)
    {
        //
    }
}