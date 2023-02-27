<?php
return [
    'menu_titles' => [
        'plugin_shipping'            => 'Shipping <span class="right badge badge-warning">' . count(sc_get_all_plugin('Shipping')) . '</span>',
        'plugin_payment'             => 'Payment <span class="right badge badge-warning">' . count(sc_get_all_plugin('Payment')) . '</span>',
        'plugin_total'               => 'Order total <span class="right badge badge-warning">' . count(sc_get_all_plugin('Total')) . '</span>',
        'plugin_fee'                => 'Order fee <span class="right badge badge-warning">' . count(sc_get_all_plugin('Fee')) . '</span>',
        'plugin_other'               => 'Other plugin <span class="right badge badge-warning">' . count(sc_get_all_plugin('Other')) . '</span>',
        'plugin_cms'                 => 'Cms plugins <span class="right badge badge-warning">' . count(sc_get_all_plugin('Cms')) . '</span>',
    ]
];
