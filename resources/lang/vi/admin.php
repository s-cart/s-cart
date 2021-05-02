<?php
return [
    'menu_titles' => [
        'plugin_shipping'            => 'Vận chuyển <span class="right badge badge-warning">' . count(sc_get_all_plugin('Shipping')) . '</span>',
        'plugin_payment'             => 'Thanh toán <span class="right badge badge-warning">' . count(sc_get_all_plugin('Payment')) . '</span>',
        'plugin_total'               => 'Giá trị đơn hàng <span class="right badge badge-warning">' . count(sc_get_all_plugin('Total')) . '</span>',
        'plugin_other'               => 'Chức năng khác <span class="right badge badge-warning">' . count(sc_get_all_plugin('Other')) . '</span>',
        'plugin_cms'                 => 'Module CMS <span class="right badge badge-warning">' . count(sc_get_all_plugin('Cms')) . '</span>',
    ]
];
