<?php
return [
    'version'     => '4.1',
    'sub-version' => '4.1.0',
    'homepage'    => 'https://s-cart.org',
    'name'        => 'S-Cart',
    'title'       => 'Free Open Source eCommerce for Business',
    'github'      => 'https://github.com/s-cart/s-cart',
    'facebook'    => 'https://www.facebook.com/SCart.Ecommerce',
    'auth'        => 'Lanh Le',
    'email'       => 'lanhktc@gmail.com',
    'api_link'    => env('SC_API_LINK', 'https://api.s-cart.org/v2'),
    //Enable, disable page libary online
    'settings' => [
        'api_plugin'   => 1,
        'api_template' => 1,
    ],
];
