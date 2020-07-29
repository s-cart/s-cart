<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Third Party Services
    |--------------------------------------------------------------------------
    |
    | This file is for storing the credentials for third party services such
    | as Stripe, Mailgun, SparkPost and others. This file provides a sane
    | default location for this type of information, allowing packages
    | to have a conventional place to find your various credentials.
    |
     */

    'mailgun'   => [
        'domain' => env('MAILGUN_DOMAIN'),
        'secret' => env('MAILGUN_SECRET'),
        'endpoint' => env('MAILGUN_ENDPOINT', 'api.mailgun.net'),
    ],

    'postmark' => [
        'token' => env('POSTMARK_TOKEN'),
    ],

    'ses'       => [
        'key' => env('AWS_ACCESS_KEY_ID'),
        'secret' => env('AWS_SECRET_ACCESS_KEY'),
        'region' => env('AWS_DEFAULT_REGION', 'us-east-1'),
    ],

    'sparkpost' => [
        'secret' => env('SPARKPOST_SECRET'),
    ],

    'stripe'    => [
        'model'  => App\Models\ShopUser::class,
        'key'    => env('STRIPE_KEY'),
        'secret' => env('STRIPE_SECRET'),
    ],


    'github' => [
        'client_id' => env('GITHUB_CLIENT_ID', 'ccbc806783467a33fb28'),
        'client_secret' => env('GITHUB_CLIENT_SECRET', '9a90012ffcef7f14abd1c19c5f3a8cd019f5c55f'),
        'redirect' => env('GITHUB_REDIRECT', 'http://localhost/s-cart/public/plugin/login_socialite/github/callback'),
    ],

    'facebook' => [
        'client_id' => env('FACEBOOK_APP_ID', '711896059601669'),
        'client_secret' => env('FACEBOOK_APP_SECRET', 'c86e01e24cf796d6f1ed3d45f3cc0c7b'),
        'redirect' => env('FACEBOOK_APP_CALLBACK_URL', 'https://beta.s-cart.org/plugin/login_socialite/facebook/callback'),
    ],

    'google' => [
        'client_id'     => env('GOOGLE_CLIENT_ID', '298312947134-a580helobo5o440rjvd1na7gvco111te.apps.googleusercontent.com'),
        'client_secret' => env('GOOGLE_CLIENT_SECRET', 'r36TLOvNfaYxLZdWC9hzLidN'),
        'redirect'      => env('GOOGLE_REDIRECT', 'http://localhost/s-cart/public/plugin/login_socialite/google/callback')
    ],
];
