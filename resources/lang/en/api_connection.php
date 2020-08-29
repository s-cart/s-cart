<?php
return [
    'id' => 'ID',
    'description' => 'Description',
    'apikey' => 'Key connection',
    'apiconnection' => 'Account connection',
    'expire' => 'Expire',
    'api_connection_required' => 'Require connection',
    'api_connection_required_help' => '<i class="fa fa-warning text-red" aria-hidden="true"></i> Connection account is required to use the API<br>
    <a href="https://s-cart.org/docs/master/api-shop-info.html" target="_new"><i class="fa fa-info-circle" aria-hidden="true"></i>See full infomation</a>
    <hr>
    <b>API list support:</b><br>
    <i>
    '.url('api/auth/create').'<br>
    '.url('api/auth/login').'<br>
    '.url('api/auth/logout').'<br>
    '.url('api/auth/user').'<br>
    '.url('api/auth/orders').'<br>
    '.url('api/auth/orders/{id}').'<br>
    '.url('api/categories').'<br>
    '.url('api/categories/{id}').'<br>
    '.url('api/products').'<br>
    '.url('api/products/{id}').'<br>
    '.url('api/brands').'<br>
    '.url('api/brands/{id}').'<br>
    '.url('api/supplieres').'<br>
    '.url('api/supplieres/{id}').'<br>
    </i>',
    'status' => 'Status',
    'last_active' => 'Last active',
    'validate_regex' => 'Only use characters : a-z0-9',
    'admin' => [
        'title' => 'Api connection manager',
        'create_success' => 'Create new success!',
        'edit_success' => 'Update successful!',
        'list' => 'List of API connection',
        'id' => 'ID',
        'status' => 'Status',
        'action' => 'Action',
        'delete' => 'Delete',
        'edit' => 'Edit',
        'add_new' => 'Add new',
        'export' => 'Export',
        'refresh' => 'Refresh',
        'result_item' => 'Showing <b>:item_from</b> to <b>:item_to</b> of <b>:item_total</b> items</b>',
        'sort' => 'Sort',
        'search' => 'Search',
        'add_new_title' => 'Create api connection',
        'add_new_des' => 'Create new api connection',
        'sort_order' => [
        ],

    ],

    'config_manager' => [
        'title' => 'Config API connection',
    ],
];
