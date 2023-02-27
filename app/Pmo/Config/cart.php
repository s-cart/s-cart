<?php

return [
    'expire' => [
        'cart' => env('SC_CART_EXPIRE_CART', 7), //days
        'wishlist' => env('SC_CART_EXPIRE_WISHLIST', 30), //days
        'compare' => env('SC_CART_EXPIRE_COMPARE', 30), //days
    ],
    'process' => [
        'other_fee' => [
            'value' => env('SC_PROCESS_OTHER_FEE', 0),
            'title' => env('SC_PROCESS_OTHER_TITLE', 'Other fee'),
        ],
    ],
];
