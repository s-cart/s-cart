<?php

return [
    'auth' => [
        'api_remmember' => env('SC_API_RECOMMEMBER', 30), //days - expires_at
        'api_token_expire_default' => env('SC_API_TOKEN_EXPIRE_DEFAULT', 7), //days - expires_at default
        'api_remmember_admin' => env('SC_API_RECOMMEMBER_ADMIN', 30), //days - expires_at
        'api_token_expire_admin_default' => env('SC_API_TOKEN_EXPIRE_ADMIN_DEFAULT', 7), //days - expires_at default
        'api_scope_type' => env('SC_API_SCOPE_TYPE', 'ability'), //ability|abilities
        'api_scope_type_admin' => env('SC_API_SCOPE_TYPE_ADMIN', 'ability'), //ability|abilities
        'api_scope_user' => env('SC_API_SCOPE_USER', 'user'), //string, separated by commas
        'api_scope_user_guest' => env('SC_API_SCOPE_USER_GUEST', 'user-guest'), //string, separated by commas
        'api_scope_admin' => env('SC_API_SCOPE_ADMIN', 'admin-supper'),//string, separated by commas
    ],
];
