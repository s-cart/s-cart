<?php

return [
    'theme'               => ['lightblue', 'dark', 'blue', 'white', 'pink'],
    'theme_default'       => 'lightblue',
    'theme_define'        => [
        'lightblue'       => [
            'body'        => 'accent-lightblue',
            'main-header' => 'navbar-dark navbar-lightblue',
            'sidebar'     => 'sidebar-lightblue',
        ],
        'dark'            => [
            'body'        => 'accent-navy',
            'main-header' => 'navbar-dark navbar-gray-dark',
            'sidebar'     => 'sidebar-gray-dark',
        ],
        'blue'            => [
            'body'        => 'accent-success',
            'main-header' => 'navbar-dark navbar-success',
            'sidebar'     => 'sidebar-success',
        ],
        'white'           => [
            'body'        => 'accent-lightblue',
            'main-header' => 'navbar-light navbar-white',
            'sidebar'     => 'sidebar-white',
        ],
        'pink'            => [
            'body'        => 'accent-fuchsia',
            'main-header' => 'navbar-dark navbar-pink',
            'sidebar'     => 'sidebar-pink',
        ],
    ],
    //Enable, disable page libary online
    'settings' => [
        'api_plugin'   => env('SC_ADMIN_API_PLUGIN', 1),
        'api_template' => env('SC_ADMIN_API_TEMPLATE', 1),
    ],
    //Prefix path view admin
    'path_view' => 's-cart-admin::',

    //Config global
    'admin_log' => env('SC_ADMIN_LOG', 1), //Log access admin

    'admin_dashboard' => [
        'total_order' => env('SC_ADMIN_DASHBOARD_TOTAL_ORDER', 1), // Total order
        'total_customer' => env('SC_ADMIN_DASHBOARD_TOTAL_CUSTOMER', 1), //Customer total
        'total_blog' => env('SC_ADMIN_DASHBOARD_TOTAL_BLOG', 1), //Blog total
        'total_product' => env('SC_ADMIN_DASHBOARD_TOTAL_PRODUCT', 1), //Product total
        'order_month' => env('SC_ADMIN_DASHBOARD_ORDER_MONTH', 1), //Order in month
        'order_year' => env('SC_ADMIN_DASHBOARD_ORDER_YEAR', 1), //Order in year
        'pie_chart' => env('SC_ADMIN_DASHBOARD_PIE_CHART', 0), //Display pie chart total
        'top_order_new' => env('SC_ADMIN_DASHBOARD_TOP_ORDER_NEW', 1), //New orders
        'top_customer_new' => env('SC_ADMIN_DASHBOARD_TOP_CUSTOMER_NEW', 1), //New customers
        'pie_chart_type' => env('SC_ADMIN_DASHBOARD_PIE_CHART_TYPE', 'order'), // [order|device|country]
    ],
    //List plugins can not remore
    'plugin_protected' => [
        'Cash', // Payment,
        'ShippingStandard', // Shipping,
        'Discount', // Total,
        'GoogleCaptcha', // Other,
        'MultiVendorPro', // Other,
        'MultiVendor', // Other,
        'B2B', // Other,
        'MultiStorePro', // Other,
        'MultiStore', // Other,
        'Content', // Cms,
    ],
];
