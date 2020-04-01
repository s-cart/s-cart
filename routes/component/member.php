<?php
$prefixMember = sc_config('PREFIX_MEMBER')??'member';

Route::group(['prefix' => $prefixMember, 'middleware' => 'auth'], function ($router) use($suffix){
    $prefixMemberOrderList = sc_config('PREFIX_MEMBER_ORDER_LIST')??'order-list';
    $prefixMemberChangePwd = sc_config('PREFIX_MEMBER_CHANGE_PWD')??'change-password';
    $prefixMemberChangeInfo = sc_config('PREFIX_MEMBER_CHANGE_INFO')??'change-infomation';

    $router->get('/', 'ShopAccount@index')->name('member.index');
    $router->get('/'.$prefixMemberOrderList.$suffix, 'ShopAccount@orderList')
        ->name('member.order_list');
    $router->get('/'.$prefixMemberChangePwd.$suffix, 'ShopAccount@changePassword')
        ->name('member.change_password');
    $router->post('/change_password', 'ShopAccount@postChangePassword')
        ->name('member.post_change_password');
    $router->get('/'.$prefixMemberChangeInfo.$suffix, 'ShopAccount@changeInfomation')
        ->name('member.change_infomation');
    $router->post('/change_infomation', 'ShopAccount@postChangeInfomation')
        ->name('member.post_change_infomation');
});