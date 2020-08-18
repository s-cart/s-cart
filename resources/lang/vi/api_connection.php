<?php
return [
    'id' => 'ID',
    'description' => 'Mô tả',
    'apikey' => 'Key kết nối',
    'apiconnection' => 'Tài khoản kết nối',
    'expire' => 'Hết hạn',
    'api_connection_required' => 'Yêu cầu tài khoản connection',
    'api_connection_required_help' => '<i class="fa fa-warning text-red" aria-hidden="true"></i> Phải có tài khoản connection để kết nối API.<br>
    <a href="https://s-cart.org/docs/master/api-shop-info.html" target="_new"><i class="fa fa-info-circle" aria-hidden="true">Xem chi tiết ở đây</i></a>
    <hr>
    <b>Danh sách API hỗ trợ:</b><br>
    <i>
    '.url('api/auth/login').'<br>
    '.url('api/auth/create').'<br>
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
    </i>
    ',
    'status' => 'Trạng thái',
    'last_active' => 'Truy cập cuối',
    'validate_regex' => 'Chỉ sử dụng các kí tự : a-z0-9',
    'admin' => [
        'title' => 'Quản lý API',
        'create_success' => 'Tạo mới thành công!',
        'edit_success' => 'Cập nhật thành công!',
        'list' => 'Danh sách API connection',
        'id' => 'ID',
        'status' => 'Status',
        'action' => 'Hành động',
        'delete' => 'Xóa',
        'edit' => 'Chỉnh sửa',
        'add_new' => 'Thêm mới',
        'export' => 'Xuất',
        'refresh' => 'Làm mới',
        'result_item' => 'Hiển thị <b>:item_from</b> tới <b>:item_to</b> trong số <b>:item_total</b> kết quả</b>',
        'sort' => 'Sắp xếp',
        'search' => 'Tìm kiếm',
        'add_new_title' => 'Tạo api connection',
        'add_new_des' => 'Tạo mới api connection',
        'select_group' => 'Chọn nhóm',
        'select_target' => 'Chọn target',
        'sort_order' => [
        ],

    ],

    'config_manager' => [
        'title' => 'Cấu hình API connection',
    ],
];
