<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Validation Language Lines
    |--------------------------------------------------------------------------
    |
    | The following language lines contain the default error messages used by
    | the validator class. Some of these rules have multiple versions such
    | as the size rules. Feel free to tweak each of these messages here.
    |
     */

    'accepted'             => 'Giá trị :attribute phải được chấp nhận.',
    'active_url'           => 'Giá trị :attribute không phải là URL hợp lệ.',
    'after'                => 'Giá trị :attribute phải sau ngày :date.',
    'after_or_equal'       => 'Giá trị :attribute phải sau hoặc bằng ngày :date.',
    'alpha'                => 'Giá trị :attribute chỉ có thể chứa chữ cái.',
    'alpha_dash'           => 'Giá trị :attribute chỉ có thể chứa chữ cái, số, và dấu gạch ngang.',
    'alpha_num'            => 'Giá trị :attribute chỉ có thể chứa chữ cái và số.',
    'array'                => 'Giá trị :attribute phải là một mảng.',
    'before'               => 'Giá trị :attribute phải là một ngày trước :date.',
    'before_or_equal'      => 'Giá trị :attribute phải là ngày trước hoặc bằng :date.',
    'between'              => [
        'numeric' => 'Giá trị :attribute và nằm giữa :min và :max.',
        'file'    => 'Giá trị :attribute phải nằm giữa :min và :max kilobytes.',
        'string'  => 'Giá trị :attribute phải nằm giữa :min và :max characters.',
        'array'   => 'Giá trị :attribute phải nằm giữa :min và :max phần tử.',
    ],
    'boolean'              => 'Giá trị :attribute phải là true hoặc false.',
    'confirmed'            => 'Giá trị :attribute xác nhận không đúng.',
    'date'                 => 'Giá trị :attribute không phải ngày hợp lệ.',
    'date_format'          => 'Giá trị :attribute không đúng định dạng :format.',
    'different'            => 'Giá trị :attribute và :other phải khác nhau.',
    'digits'               => 'Giá trị :attribute phải là :digits chữ số.',
    'digits_between'       => 'Giá trị :attribute phải nằm giữa :min and :max chữ số.',
    'dimensions'           => 'Giá trị :attribute có kích thước hình ảnh không hợp lệ.',
    'distinct'             => 'Giá trị :attribute có giá trị trùng lặp.',
    'email'                => 'Định dạng email chưa đúng.',
    'phone'                => 'Định dạng số điện thoại chưa đúng',
    'exists'               => 'Giá trị được chọn :attribute không hợp lệ.',
    'file'                 => ':attribute phải là 1 file.',
    'filled'               => ':attribute phải có một giá trị.',
    'gt'                   => [
        'numeric' => 'Giá trị :attribute phải lớn hơn :value.',
        'file'    => 'Giá trị :attribute phải lớn hơn :value kilobytes.',
        'string'  => 'Giá trị :attribute phải lớn hơn :value kí tự.',
        'array'   => 'Giá trị :attribute phải có nhiều hơn :value phần tử.',
    ],
    'gte'                  => [
        'numeric' => 'Giá trị :attribute phải lớn hơn hoặc bằng :value.',
        'file'    => 'Giá trị :attribute phải lớn hơn hoặc bằng :value kilobytes.',
        'string'  => 'Giá trị :attribute phải lớn hơn hoặc bằng :value characters.',
        'array'   => 'Giá trị :attribute phải có :value phần tử hoặc hơn.',
    ],
    'image'                => 'Giá trị :attribute phải là một hình ảnh.',
    'in'                   => 'Thuộc tính đã chọn không hợp lệ.',
    'in_array'             => 'Giá trị :attribute không tồn tại trong :other.',
    'integer'              => 'Giá trị :attribute phải là số.',
    'ip'                   => 'Giá trị :attribute phải là địa chỉ IP.',
    'ipv4'                 => 'Giá trị :attribute phải là IPv4.',
    'ipv6'                 => 'Giá trị :attribute phải là một IPv6.',
    'json'                 => 'Giá trị :attribute phải là một JSON.',
    'lt'                   => [
        'numeric' => 'Giá trị :attribute phải nhỏ hơn :value.',
        'file'    => 'Giá trị :attribute phải nhỏ hơn :value kilobytes.',
        'string'  => 'Giá trị :attribute phải nhỏ hơn :value kí tử.',
        'array'   => 'Giá trị :attribute phải có ít hơn :value phần tử.',
    ],
    'lte'                  => [
        'numeric' => 'Giá trị :attribute phải nhỏ hơn hoặc bằng :value.',
        'file'    => 'Giá trị :attribute phải nhỏ hơn hoặc bằng :value kilobytes.',
        'string'  => 'Giá trị :attribute phải nhỏ hơn hoặc bằng :value characters.',
        'array'   => 'Giá trị :attribute must not have more than :value items.',
    ],
    'max'                  => [
        'numeric' => 'Giá trị :attribute không được lớn hơn :max.',
        'file'    => 'File :attribute không thể lớn hơn :max kilobytes.',
        'string'  => 'Giá trị :attribute không thẻ lớn hơn :max kí tự.',
        'array'   => 'Mảng :attribute không thể nhiều hơn :max phần tử.',
    ],
    'mimes'                => 'Giá trị :attribute phải là một file của: :values.',
    'mimetypes'            => 'Giá trị :attribute phải là một file của: :values.',
    'min'                  => [
        'numeric' => 'Giá trị :attribute nhỏ nhất là :min.',
        'file'    => 'Giá trị :attribute nhỏ nhất là :min kilobytes.',
        'string'  => 'Giá trị :attribute nhỏ nhất là :min characters.',
        'array'   => 'Giá trị :attribute nhỏ nhất là :min phần tử.',
    ],
    'not_in'               => 'Thuộc tính được lựa chọn :attribute là không hợp lệ.',
    'not_regex'            => 'Giá trị :attribute có định dạng không hợp lệ.',
    'numeric'              => 'Giá trị :attribute phải là số.',
    'present'              => 'Giá trị :attribute field must be present.',
    'regex'                => 'Giá trị :attribute chưa đúng định dạng.',
    'required'             => 'Giá trị :attribute là bắt buộc.',
    'required_if'          => 'Giá trị :attribute là bắt buộc khi :other là :value.',
    'required_unless'      => 'Giá trị :attribute là bắt buộc trừ khi :other là trong :values.',
    'required_with'        => 'Giá trị :attribute là bắt buộc khi :values có mặt.',
    'required_with_all'    => 'Giá trị :attribute là bắt buộc khi :values có mặt.',
    'required_without'     => 'Giá trị :attribute là bắt buộc khi :values không có mặt.',
    'required_without_all' => 'Giá trị :attribute là bắt buộc khi không giá trị nào trong :values có mặt.',
    'same'                 => 'Giá trị :attribute và :other phải trùng nhau.',
    'size'                 => [
        'numeric' => 'Giá trị :attribute phải là :size.',
        'file'    => 'Giá trị :attribute phải là :size kilobytes.',
        'string'  => 'Giá trị :attribute phải là :size characters.',
        'array'   => 'Giá trị :attribute phải chứa :size phần tử.',
    ],
    'string'               => 'Giá trị :attribute phải là một chuỗi.',
    'timezone'             => 'Giá trị :attribute phải là một vùng hợp lệ.',
    'unique'               => 'Giá trị :attribute đã được sử dụng.',
    'uploaded'             => 'Upload :attribute thất bại.',
    'url'                  => 'Định dạng :attribute không hợp lệ.',
    'validate_nickname'    => 'Giá trị này phải là duy nhất. Viết liền, không dấu, không được trùng nhau.',

    /*
    |--------------------------------------------------------------------------
    | Custom Validation Language Lines
    |--------------------------------------------------------------------------
    |
    | Here you may specify custom validation messages for attributes using the
    | convention "attribute.rule" to name the lines. This makes it quick to
    | specify a specific custom language line for a given attribute rule.
    |
     */

    'custom'               => [
        'attribute-name' => [
            'rule-name' => 'custom-message',
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Custom Validation Attributes
    |--------------------------------------------------------------------------
    |
    | The following language lines are used to swap attribute place-holders
    | with something more reader friendly such as E-Mail Address instead
    | of "email". This simply helps us make messages a little cleaner.
    |
     */

    'attributes'           => [],

];
