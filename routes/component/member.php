<?php
$prefixMember = sc_config('PREFIX_MEMBER')??'member';

Route::group(['prefix' => $prefixMember, 'middleware' => 'auth'], function ($router) use($suffix){
    $prefixMemberOrderList = sc_config('PREFIX_MEMBER_ORDER_LIST')??'order-list';
    $prefixMemberOrderDetail = sc_config('PREFIX_MEMBER_ORDER_DETAIL')??'order-detail';
    $prefixMemberAddresList = sc_config('PREFIX_MEMBER_ADDRESS_LIST')??'address-list';
    $prefixMemberUpdateAddres = sc_config('PREFIX_MEMBER_UPDATE_ADDRESS')??'update-address';
    $prefixMemberDeleteAddres = sc_config('PREFIX_MEMBER_DELETE_ADDRESS')??'delete-address';
    $prefixMemberChangePwd = sc_config('PREFIX_MEMBER_CHANGE_PWD')??'change-password';
    $prefixMemberChangeInfo = sc_config('PREFIX_MEMBER_CHANGE_INFO')??'change-infomation';


    $router->get('/', 'ShopAccount@index')->name('member.index');
    $router->get('/'.$prefixMemberOrderList.$suffix, 'ShopAccount@orderList')
        ->name('member.order_list');
    $router->get('/'.$prefixMemberOrderDetail.'/{id}', 'ShopAccount@orderDetail')
        ->name('member.order_detail');
    $router->get('/'.$prefixMemberAddresList.$suffix, 'ShopAccount@addressList')
        ->name('member.address_list');
    $router->get('/'.$prefixMemberUpdateAddres.'/{id}', 'ShopAccount@updateAddress')
        ->name('member.update_address');
    $router->post('/'.$prefixMemberUpdateAddres.'/{id}', 'ShopAccount@postUpdateAddress')
        ->name('member.post_update_address');
    $router->post('/'.$prefixMemberDeleteAddres, 'ShopAccount@deleteAddress')
        ->name('member.delete_address');
    $router->get('/'.$prefixMemberChangePwd.$suffix, 'ShopAccount@changePassword')
        ->name('member.change_password');
    $router->post('/change_password', 'ShopAccount@postChangePassword')
        ->name('member.post_change_password');
    $router->get('/'.$prefixMemberChangeInfo.$suffix, 'ShopAccount@changeInfomation')
        ->name('member.change_infomation');
    $router->post('/change_infomation', 'ShopAccount@postChangeInfomation')
        ->name('member.post_change_infomation');
    $router->post('/address-detail', 'ShopAccount@getAddress')
        ->name('member.address_detail');   
});