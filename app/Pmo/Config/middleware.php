<?php
//Config middleware
return [
    'admin' => [
        1 => 'admin.auth',
        2 => 'admin.permission',
        3 => 'admin.log',
        4 => 'admin.storeId',
        5 => 'admin.theme',
        6 => 'localization',
    ],
    'front' => [
        1 => 'localization',
        2 => 'currency',
        3 => 'checkdomain',
    ],
    'api_extend' => [
        1 => 'json.response',
        2 => 'api.connection',
        3 => 'throttle:1000',
    ],
];
