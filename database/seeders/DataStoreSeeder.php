<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DataStoreSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $storeId = empty(session('lastStoreId')) ? 1 : session('lastStoreId');
        DB::connection(SC_CONNECTION)->table(SC_DB_PREFIX.'admin_config')->insertOrIgnore(
            [
            ['group' => '', 'code' => 'product_config_attribute', 'key' => 'product_brand', 'value' => '1', 'sort' => '0', 'detail' => 'lang::product.config_manager.brand', 'store_id' => $storeId],
            ['group' => '', 'code' => 'product_config_attribute_required', 'key' => 'product_brand_required', 'value' => '0', 'sort' => '0', 'detail' => '', 'store_id' => $storeId],
            ['group' => '', 'code' => 'product_config_attribute', 'key' => 'product_supplier', 'value' => '1', 'sort' => '0', 'detail' => 'lang::product.config_manager.supplier', 'store_id' => $storeId],
            ['group' => '', 'code' => 'product_config_attribute_required', 'key' => 'product_supplier_required', 'value' => '0', 'sort' => '0', 'detail' => '', 'store_id' => $storeId],
            ['group' => '', 'code' => 'product_config_attribute', 'key' => 'product_price', 'value' => '1', 'sort' => '0', 'detail' => 'lang::product.config_manager.price', 'store_id' => $storeId],
            ['group' => '', 'code' => 'product_config_attribute_required', 'key' => 'product_price_required', 'value' => '1', 'sort' => '0', 'detail' => '', 'store_id' => $storeId],
            ['group' => '', 'code' => 'product_config_attribute', 'key' => 'product_cost', 'value' => '1', 'sort' => '0', 'detail' => 'lang::product.config_manager.cost', 'store_id' => $storeId],
            ['group' => '', 'code' => 'product_config_attribute_required', 'key' => 'product_cost_required', 'value' => '0', 'sort' => '0', 'detail' => '', 'store_id' => $storeId],
            ['group' => '', 'code' => 'product_config_attribute', 'key' => 'product_promotion', 'value' => '1', 'sort' => '0', 'detail' => 'lang::product.config_manager.promotion', 'store_id' => $storeId],
            ['group' => '', 'code' => 'product_config_attribute_required', 'key' => 'product_promotion_required', 'value' => '0', 'sort' => '0', 'detail' => '', 'store_id' => $storeId],
            ['group' => '', 'code' => 'product_config_attribute', 'key' => 'product_stock', 'value' => '1', 'sort' => '0', 'detail' => 'lang::product.config_manager.stock', 'store_id' => $storeId],
            ['group' => '', 'code' => 'product_config_attribute_required', 'key' => 'product_stock_required', 'value' => '0', 'sort' => '0', 'detail' => '', 'store_id' => $storeId],
            ['group' => '', 'code' => 'product_config_attribute', 'key' => 'product_kind', 'value' => '1', 'sort' => '0', 'detail' => 'lang::product.config_manager.kind', 'store_id' => $storeId],
            ['group' => '', 'code' => 'product_config_attribute', 'key' => 'product_property', 'value' => '1', 'sort' => '0', 'detail' => 'lang::product.config_manager.property', 'store_id' => $storeId],
            ['group' => '', 'code' => 'product_config_attribute_required', 'key' => 'product_property_required', 'value' => '0', 'sort' => '0', 'detail' => '', 'store_id' => $storeId],
            ['group' => '', 'code' => 'product_config_attribute', 'key' => 'product_attribute', 'value' => '1', 'sort' => '0', 'detail' => 'lang::product.config_manager.attribute', 'store_id' => $storeId],
            ['group' => '', 'code' => 'product_config_attribute_required', 'key' => 'product_attribute_required', 'value' => '0', 'sort' => '0', 'detail' => '', 'store_id' => $storeId],
            ['group' => '', 'code' => 'product_config_attribute', 'key' => 'product_available', 'value' => '1', 'sort' => '0', 'detail' => 'lang::product.config_manager.available', 'store_id' => $storeId],
            ['group' => '', 'code' => 'product_config_attribute_required', 'key' => 'product_available_required', 'value' => '0', 'sort' => '0', 'detail' => '', 'store_id' => $storeId],
            ['group' => '', 'code' => 'product_config_attribute', 'key' => 'product_weight', 'value' => '1', 'sort' => '0', 'detail' => 'lang::product.config_manager.weight', 'store_id' => $storeId],
            ['group' => '', 'code' => 'product_config_attribute_required', 'key' => 'product_weight_required', 'value' => '0', 'sort' => '0', 'detail' => '', 'store_id' => $storeId],
            ['group' => '', 'code' => 'product_config_attribute', 'key' => 'product_length', 'value' => '1', 'sort' => '0', 'detail' => 'lang::product.config_manager.length', 'store_id' => $storeId],
            ['group' => '', 'code' => 'product_config_attribute_required', 'key' => 'product_length_required', 'value' => '0', 'sort' => '0', 'detail' => '', 'store_id' => $storeId],

            ['group' => '', 'code' => 'product_config', 'key' => 'product_display_out_of_stock', 'value' => '1', 'sort' => '19', 'detail' => 'lang::admin.product_display_out_of_stock', 'store_id' => $storeId],
            ['group' => '', 'code' => 'product_config', 'key' => 'show_date_available', 'value' => '1', 'sort' => '21', 'detail' => 'lang::admin.show_date_available', 'store_id' => $storeId],
            ['group' => '', 'code' => 'product_config', 'key' => 'product_tax', 'value' => '1', 'sort' => '0', 'detail' => 'lang::product.config_manager.tax', 'store_id' => $storeId],

            ['group' => '', 'code' => 'customer_config_attribute', 'key' => 'customer_lastname', 'value' => '1', 'sort' => '1', 'detail' => 'lang::customer.config_manager.lastname', 'store_id' => $storeId],
            ['group' => '', 'code' => 'customer_config_attribute_required', 'key' => 'customer_lastname_required', 'value' => '1', 'sort' => '1', 'detail' => '', 'store_id' => $storeId],
            ['group' => '', 'code' => 'customer_config_attribute', 'key' => 'customer_address1', 'value' => '1', 'sort' => '2', 'detail' => 'lang::customer.config_manager.address1', 'store_id' => $storeId],
            ['group' => '', 'code' => 'customer_config_attribute_required', 'key' => 'customer_address1_required', 'value' => '1', 'sort' => '2', 'detail' => '', 'store_id' => $storeId],
            ['group' => '', 'code' => 'customer_config_attribute', 'key' => 'customer_address2', 'value' => '1', 'sort' => '2', 'detail' => 'lang::customer.config_manager.address2', 'store_id' => $storeId],
            ['group' => '', 'code' => 'customer_config_attribute_required', 'key' => 'customer_address2_required', 'value' => '1', 'sort' => '2', 'detail' => '', 'store_id' => $storeId],
            ['group' => '', 'code' => 'customer_config_attribute', 'key' => 'customer_address3', 'value' => '0', 'sort' => '2', 'detail' => 'lang::customer.config_manager.address3', 'store_id' => $storeId],
            ['group' => '', 'code' => 'customer_config_attribute_required', 'key' => 'customer_address3_required', 'value' => '0', 'sort' => '2', 'detail' => '', 'store_id' => $storeId],
            ['group' => '', 'code' => 'customer_config_attribute', 'key' => 'customer_company', 'value' => '0', 'sort' => '0', 'detail' => 'lang::customer.config_manager.company', 'store_id' => $storeId],
            ['group' => '', 'code' => 'customer_config_attribute', 'key' => 'customer_company', 'value' => '0', 'sort' => '0', 'detail' => 'lang::customer.config_manager.company', 'store_id' => $storeId],
            ['group' => '', 'code' => 'customer_config_attribute_required', 'key' => 'customer_company_required', 'value' => '0', 'sort' => '0', 'detail' => '', 'store_id' => $storeId],
            ['group' => '', 'code' => 'customer_config_attribute', 'key' => 'customer_postcode', 'value' => '0', 'sort' => '0', 'detail' => 'lang::customer.config_manager.postcode', 'store_id' => $storeId],
            ['group' => '', 'code' => 'customer_config_attribute_required', 'key' => 'customer_postcode_required', 'value' => '0', 'sort' => '0', 'detail' => '', 'store_id' => $storeId],
            ['group' => '', 'code' => 'customer_config_attribute', 'key' => 'customer_country', 'value' => '1', 'sort' => '0', 'detail' => 'lang::customer.config_manager.country', 'store_id' => $storeId],
            ['group' => '', 'code' => 'customer_config_attribute_required', 'key' => 'customer_country_required', 'value' => '1', 'sort' => '0', 'detail' => '', 'store_id' => $storeId],
            ['group' => '', 'code' => 'customer_config_attribute', 'key' => 'customer_group', 'value' => '0', 'sort' => '0', 'detail' => 'lang::customer.config_manager.group', 'store_id' => $storeId],
            ['group' => '', 'code' => 'customer_config_attribute_required', 'key' => 'customer_group_required', 'value' => '0', 'sort' => '0', 'detail' => '', 'store_id' => $storeId],
            ['group' => '', 'code' => 'customer_config_attribute', 'key' => 'customer_birthday', 'value' => '0', 'sort' => '0', 'detail' => 'lang::customer.config_manager.birthday', 'store_id' => $storeId],
            ['group' => '', 'code' => 'customer_config_attribute_required', 'key' => 'customer_birthday_required', 'value' => '0', 'sort' => '0', 'detail' => '', 'store_id' => $storeId],
            ['group' => '', 'code' => 'customer_config_attribute', 'key' => 'customer_sex', 'value' => '0', 'sort' => '0', 'detail' => 'lang::customer.config_manager.sex', 'store_id' => $storeId],
            ['group' => '', 'code' => 'customer_config_attribute_required', 'key' => 'customer_sex_required', 'value' => '0', 'sort' => '0', 'detail' => '', 'store_id' => $storeId],
            ['group' => '', 'code' => 'customer_config_attribute', 'key' => 'customer_phone', 'value' => '1', 'sort' => '0', 'detail' => 'lang::customer.config_manager.phone', 'store_id' => $storeId],
            ['group' => '', 'code' => 'customer_config_attribute_required', 'key' => 'customer_phone_required', 'value' => '1', 'sort' => '1', 'detail' => '', 'store_id' => $storeId],
            ['group' => '', 'code' => 'customer_config_attribute', 'key' => 'customer_name_kana', 'value' => '0', 'sort' => '0', 'detail' => 'lang::customer.config_manager.name_kana', 'store_id' => $storeId],
            ['group' => '', 'code' => 'customer_config_attribute_required', 'key' => 'customer_name_kana_required', 'value' => '0', 'sort' => '1', 'detail' => '', 'store_id' => $storeId],

            ['group' => '', 'code' => 'admin_config', 'key' => 'ADMIN_NAME', 'value' => 'S-Cart System', 'sort' => '0', 'detail' => 'lang::env.ADMIN_NAME', 'store_id' => $storeId],
            ['group' => '', 'code' => 'admin_config', 'key' => 'ADMIN_TITLE', 'value' => 'S-Cart Admin', 'sort' => '0', 'detail' => 'lang::env.ADMIN_TITLE', 'store_id' => $storeId],
            ['group' => '', 'code' => 'admin_config', 'key' => 'ADMIN_LOGO', 'value' => 'S-Cart Admin', 'sort' => '0', 'detail' => 'lang::env.ADMIN_LOGO', 'store_id' => $storeId],


            ['group' => '', 'code' => 'display_config', 'key' => 'product_top', 'value' => '8', 'sort' => '0', 'detail' => 'lang::admin.product_top', 'store_id' => $storeId],
            ['group' => '', 'code' => 'display_config', 'key' => 'product_list', 'value' => '12', 'sort' => '0', 'detail' => 'lang::admin.list_product', 'store_id' => $storeId],
            ['group' => '', 'code' => 'display_config', 'key' => 'product_relation', 'value' => '4', 'sort' => '0', 'detail' => 'lang::admin.relation_product', 'store_id' => $storeId],
            ['group' => '', 'code' => 'display_config', 'key' => 'product_viewed', 'value' => '4', 'sort' => '0', 'detail' => 'lang::admin.viewed_product', 'store_id' => $storeId],
            ['group' => '', 'code' => 'display_config', 'key' => 'item_list', 'value' => '12', 'sort' => '0', 'detail' => 'lang::admin.item_list', 'store_id' => $storeId],
            ['group' => '', 'code' => 'display_config', 'key' => 'item_top', 'value' => '8', 'sort' => '0', 'detail' => 'lang::admin.item_top', 'store_id' => $storeId],

            ['group' => '', 'code' => 'order_config', 'key' => 'shop_allow_guest', 'value' => '1', 'sort' => '11', 'detail' => 'lang::order.admin.shop_allow_guest', 'store_id' => $storeId],
            ['group' => '', 'code' => 'order_config', 'key' => 'product_preorder', 'value' => '1', 'sort' => '18', 'detail' => 'lang::order.admin.product_preorder', 'store_id' => $storeId],
            ['group' => '', 'code' => 'order_config', 'key' => 'product_buy_out_of_stock', 'value' => '1', 'sort' => '20', 'detail' => 'lang::order.admin.product_buy_out_of_stock', 'store_id' => $storeId],
            ['group' => '', 'code' => 'order_config', 'key' => 'shipping_off', 'value' => '0', 'sort' => '20', 'detail' => 'lang::order.admin.shipping_off', 'store_id' => $storeId],
            ['group' => '', 'code' => 'order_config', 'key' => 'payment_off', 'value' => '0', 'sort' => '20', 'detail' => 'lang::order.admin.payment_off', 'store_id' => $storeId],

            ['group' => '', 'code' => 'email_action', 'key' => 'email_action_mode', 'value' => '0', 'sort' => '0', 'detail' => 'lang::email.email_action.email_action_mode', 'store_id' => $storeId],
            ['group' => '', 'code' => 'email_action', 'key' => 'email_action_queue', 'value' => '0', 'sort' => '1', 'detail' => 'lang::email.email_action.email_action_queue', 'store_id' => $storeId],
            ['group' => '', 'code' => 'email_action', 'key' => 'order_success_to_admin', 'value' => '0', 'sort' => '1', 'detail' => 'lang::email.email_action.order_success_to_admin', 'store_id' => $storeId],
            ['group' => '', 'code' => 'email_action', 'key' => 'order_success_to_customer', 'value' => '0', 'sort' => '2', 'detail' => 'lang::email.email_action.order_success_to_cutomer', 'store_id' => $storeId],
            ['group' => '', 'code' => 'email_action', 'key' => 'order_success_to_customer_pdf', 'value' => '0', 'sort' => '3', 'detail' => 'lang::email.email_action.order_success_to_cutomer_pdf', 'store_id' => $storeId],
            ['group' => '', 'code' => 'email_action', 'key' => 'customer_verify', 'value' => '0', 'sort' => '4', 'detail' => 'lang::email.email_action.customer_verify', 'store_id' => $storeId],
            ['group' => '', 'code' => 'email_action', 'key' => 'welcome_customer', 'value' => '0', 'sort' => '4', 'detail' => 'lang::email.email_action.welcome_customer', 'store_id' => $storeId],
            ['group' => '', 'code' => 'email_action', 'key' => 'contact_to_admin', 'value' => '1', 'sort' => '6', 'detail' => 'lang::email.email_action.contact_to_admin', 'store_id' => $storeId],

            ['group' => '', 'code' => 'smtp_config', 'key' => 'smtp_host', 'value' => '', 'sort' => '1', 'detail' => 'lang::email.smtp_host', 'store_id' => $storeId],
            ['group' => '', 'code' => 'smtp_config', 'key' => 'smtp_user', 'value' => '', 'sort' => '2', 'detail' => 'lang::email.smtp_user', 'store_id' => $storeId],
            ['group' => '', 'code' => 'smtp_config', 'key' => 'smtp_password', 'value' => '', 'sort' => '3', 'detail' => 'lang::email.smtp_password', 'store_id' => $storeId],
            ['group' => '', 'code' => 'smtp_config', 'key' => 'smtp_security', 'value' => '', 'sort' => '4', 'detail' => 'lang::email.smtp_security', 'store_id' => $storeId],
            ['group' => '', 'code' => 'smtp_config', 'key' => 'smtp_port', 'value' => '', 'sort' => '5', 'detail' => 'lang::email.smtp_port', 'store_id' => $storeId],

            ['group' => '', 'code' => 'url_config', 'key' => 'SUFFIX_URL', 'value' => '.html', 'sort' => '0', 'detail' => 'lang::url.SUFFIX_URL', 'store_id' => $storeId],
            ['group' => '', 'code' => 'url_config', 'key' => 'PREFIX_SHOP', 'value' => 'shop', 'sort' => '0', 'detail' => 'lang::env.PREFIX_SHOP', 'store_id' => $storeId],
            ['group' => '', 'code' => 'url_config', 'key' => 'PREFIX_BRAND', 'value' => 'brand', 'sort' => '0', 'detail' => 'lang::env.PREFIX_BRAND', 'store_id' => $storeId],
            ['group' => '', 'code' => 'url_config', 'key' => 'PREFIX_CATEGORY', 'value' => 'category', 'sort' => '0', 'detail' => 'lang::env.PREFIX_CATEGORY', 'store_id' => $storeId],
            ['group' => '', 'code' => 'url_config', 'key' => 'PREFIX_SUB_CATEGORY', 'value' => 'sub-category', 'sort' => '0', 'detail' => 'lang::env.PREFIX_SUB_CATEGORY', 'store_id' => $storeId],
            ['group' => '', 'code' => 'url_config', 'key' => 'PREFIX_PRODUCT', 'value' => 'product', 'sort' => '0', 'detail' => 'lang::env.PREFIX_PRODUCT', 'store_id' => $storeId],
            ['group' => '', 'code' => 'url_config', 'key' => 'PREFIX_SEARCH', 'value' => 'search', 'sort' => '0', 'detail' => 'lang::env.PREFIX_SEARCH', 'store_id' => $storeId],
            ['group' => '', 'code' => 'url_config', 'key' => 'PREFIX_CONTACT', 'value' => 'contact', 'sort' => '0', 'detail' => 'lang::env.PREFIX_CONTACT', 'store_id' => $storeId],
            ['group' => '', 'code' => 'url_config', 'key' => 'PREFIX_NEWS', 'value' => 'news', 'sort' => '0', 'detail' => 'lang::env.PREFIX_NEWS', 'store_id' => $storeId],
            ['group' => '', 'code' => 'url_config', 'key' => 'PREFIX_MEMBER', 'value' => 'customer', 'sort' => '0', 'detail' => 'lang::env.PREFIX_MEMBER', 'store_id' => $storeId],
            ['group' => '', 'code' => 'url_config', 'key' => 'PREFIX_MEMBER_ORDER_LIST', 'value' => 'order-list', 'sort' => '0', 'detail' => 'lang::env.PREFIX_MEMBER_ORDER_LIST', 'store_id' => $storeId],
            ['group' => '', 'code' => 'url_config', 'key' => 'PREFIX_MEMBER_CHANGE_PWD', 'value' => 'change-password', 'sort' => '0', 'detail' => 'lang::env.PREFIX_MEMBER_CHANGE_PWD', 'store_id' => $storeId],
            ['group' => '', 'code' => 'url_config', 'key' => 'PREFIX_MEMBER_CHANGE_INFO', 'value' => 'change-info', 'sort' => '0', 'detail' => 'lang::env.PREFIX_MEMBER_CHANGE_INFO', 'store_id' => $storeId],
            ['group' => '', 'code' => 'url_config', 'key' => 'PREFIX_CMS_CATEGORY', 'value' => 'cms-category', 'sort' => '0', 'detail' => 'lang::env.PREFIX_CMS_CATEGORY', 'store_id' => $storeId],
            ['group' => '', 'code' => 'url_config', 'key' => 'PREFIX_CMS_ENTRY', 'value' => 'entry', 'sort' => '0', 'detail' => 'lang::env.PREFIX_CMS_ENTRY', 'store_id' => $storeId],
            ['group' => '', 'code' => 'url_config', 'key' => 'PREFIX_CART_WISHLIST', 'value' => 'wishlst', 'sort' => '0', 'detail' => 'lang::env.PREFIX_CART_WISHLIST', 'store_id' => $storeId],
            ['group' => '', 'code' => 'url_config', 'key' => 'PREFIX_CART_COMPARE', 'value' => 'compare', 'sort' => '0', 'detail' => 'lang::env.PREFIX_CART_COMPARE', 'store_id' => $storeId],
            ['group' => '', 'code' => 'url_config', 'key' => 'PREFIX_CART_DEFAULT', 'value' => 'cart', 'sort' => '0', 'detail' => 'lang::env.PREFIX_CART_DEFAULT', 'store_id' => $storeId],
            ['group' => '', 'code' => 'url_config', 'key' => 'PREFIX_CART_CHECKOUT', 'value' => 'checkout', 'sort' => '0', 'detail' => 'lang::env.PREFIX_CART_CHECKOUT', 'store_id' => $storeId],
            ['group' => '', 'code' => 'url_config', 'key' => 'PREFIX_ORDER_SUCCESS', 'value' => 'order-success', 'sort' => '0', 'detail' => 'lang::env.PREFIX_ORDER_SUCCESS', 'store_id' => $storeId],
            
            ['group' => '', 'code' => 'captcha_config', 'key' => 'captcha_mode', 'value' => '0', 'sort' => '20', 'detail' => 'lang::captcha.captcha_mode', 'store_id' => $storeId],
            ['group' => '', 'code' => 'captcha_config', 'key' => 'captcha_page', 'value' => '[]', 'sort' => '10', 'detail' => 'lang::captcha.captcha_page', 'store_id' => $storeId],
            ['group' => '', 'code' => 'captcha_config', 'key' => 'captcha_method', 'value' => '', 'sort' => '0', 'detail' => 'lang::captcha.captcha_method', 'store_id' => $storeId],
            
            ]
        );

        DB::connection(SC_CONNECTION)->table(SC_DB_PREFIX . 'shop_email_template')->insert(
          [
              ['name' => 'Reset password', 'group' => 'forgot_password', 'text' => '
<h1 style="font-family:Avenir,Helvetica,sans-serif;box-sizing:border-box;color:#2f3133;font-size:19px;font-weight:bold;margin-top:0;text-align:left">{{$title}}</h1>
<p style="font-family:Avenir,Helvetica,sans-serif;box-sizing:border-box;color:#74787e;font-size:16px;line-height:1.5em;margin-top:0;text-align:left">{{$reason_sendmail}}</p>
<table class="action" align="center" width="100%" cellpadding="0" cellspacing="0" style="font-family:Avenir,Helvetica,sans-serif;box-sizing:border-box;margin:30px auto;padding:0;text-align:center;width:100%">
<tbody><tr>
  <td align="center" style="font-family:Avenir,Helvetica,sans-serif;box-sizing:border-box">
  <table width="100%" border="0" cellpadding="0" cellspacing="0" style="font-family:Avenir,Helvetica,sans-serif;box-sizing:border-box">
      <tbody><tr>
      <td align="center" style="font-family:Avenir,Helvetica,sans-serif;box-sizing:border-box">
          <table border="0" cellpadding="0" cellspacing="0" style="font-family:Avenir,Helvetica,sans-serif;box-sizing:border-box">
          <tbody><tr>
              <td style="font-family:Avenir,Helvetica,sans-serif;box-sizing:border-box">
              <a href="{{$reset_link}}" class="button button-primary" style="font-family:Avenir,Helvetica,sans-serif;box-sizing:border-box;border-radius:3px;color:#fff;display:inline-block;text-decoration:none;background-color:#3097d1;border-top:10px solid #3097d1;border-right:18px solid #3097d1;border-bottom:10px solid #3097d1;border-left:18px solid #3097d1" target="_blank">{{$reset_button}}</a>
              </td>
          </tr>
          </tbody>
      </table>
      </td>
      </tr>
  </tbody>
  </table>
  </td>
</tr>
</tbody>
</table>
<p style="font-family:Avenir,Helvetica,sans-serif;box-sizing:border-box;color:#74787e;font-size:16px;line-height:1.5em;margin-top:0;text-align:left">
{{$note_sendmail}}
</p>
<table class="subcopy" width="100%" cellpadding="0" cellspacing="0" style="font-family:Avenir,Helvetica,sans-serif;box-sizing:border-box;border-top:1px solid #edeff2;margin-top:25px;padding-top:25px">
<tbody><tr>
<td style="font-family:Avenir,Helvetica,sans-serif;box-sizing:border-box">
  <p style="font-family:Avenir,Helvetica,sans-serif;box-sizing:border-box;color:#74787e;line-height:1.5em;margin-top:0;text-align:left;font-size:12px">{{$note_access_link}}</p>
  </td>
  </tr>
</tbody>
</table>', 'status' => '1', 'store_id' => $storeId],

['name' => 'Customer verification', 'group' => 'customer_verify', 'text' => '
<h1 style="font-family:Avenir,Helvetica,sans-serif;box-sizing:border-box;color:#2f3133;font-size:19px;font-weight:bold;margin-top:0;text-align:left">{{$title}}</h1>
<p style="font-family:Avenir,Helvetica,sans-serif;box-sizing:border-box;color:#74787e;font-size:16px;line-height:1.5em;margin-top:0;text-align:left">{{$reason_sendmail}}</p>
<table class="action" align="center" width="100%" cellpadding="0" cellspacing="0" style="font-family:Avenir,Helvetica,sans-serif;box-sizing:border-box;margin:30px auto;padding:0;text-align:center;width:100%">
<tbody><tr>
  <td align="center" style="font-family:Avenir,Helvetica,sans-serif;box-sizing:border-box">
  <table width="100%" border="0" cellpadding="0" cellspacing="0" style="font-family:Avenir,Helvetica,sans-serif;box-sizing:border-box">
      <tbody><tr>
      <td align="center" style="font-family:Avenir,Helvetica,sans-serif;box-sizing:border-box">
          <table border="0" cellpadding="0" cellspacing="0" style="font-family:Avenir,Helvetica,sans-serif;box-sizing:border-box">
          <tbody><tr>
              <td style="font-family:Avenir,Helvetica,sans-serif;box-sizing:border-box">
              <a href="{{$url_verify}}" class="button button-primary" style="font-family:Avenir,Helvetica,sans-serif;box-sizing:border-box;border-radius:3px;color:#fff;display:inline-block;text-decoration:none;background-color:#3097d1;border-top:10px solid #3097d1;border-right:18px solid #3097d1;border-bottom:10px solid #3097d1;border-left:18px solid #3097d1" target="_blank">{{$button}}</a>
              </td>
          </tr>
          </tbody>
      </table>
      </td>
      </tr>
  </tbody>
  </table>
  </td>
</tr>
</tbody>
</table>
<p style="font-family:Avenir,Helvetica,sans-serif;box-sizing:border-box;color:#74787e;font-size:16px;line-height:1.5em;margin-top:0;text-align:left">
{{$note_sendmail}}
</p>
<table class="subcopy" width="100%" cellpadding="0" cellspacing="0" style="font-family:Avenir,Helvetica,sans-serif;box-sizing:border-box;border-top:1px solid #edeff2;margin-top:25px;padding-top:25px">
<tbody><tr>
<td style="font-family:Avenir,Helvetica,sans-serif;box-sizing:border-box">
  <p style="font-family:Avenir,Helvetica,sans-serif;box-sizing:border-box;color:#74787e;line-height:1.5em;margin-top:0;text-align:left;font-size:12px">{{$note_access_link}}</p>
  </td>
  </tr>
</tbody>
</table>', 'status' => '1', 'store_id' => $storeId],

              ['name' => 'Welcome new customer', 'group' => 'welcome_customer', 'text' => '
<h1 style="font-family:Avenir,Helvetica,sans-serif;box-sizing:border-box;color:#2f3133;font-size:19px;font-weight:bold;margin-top:0;text-align:center">{{$title}}</h1>
<p style="text-align:center;">Welcome to my site!</p>', 'status' => '1', 'store_id' => $storeId],
              ['name' => 'Send form contact to admin', 'group' => 'contact_to_admin', 'text' => '
<table class="inner-body" align="center" cellpadding="0" cellspacing="0">
<tr>
<td>
<b>Name</b>: {{$name}}<br>
<b>Email</b>: {{$email}}<br>
<b>Phone</b>: {{$phone}}<br>
</td>
</tr>
</table>
<hr>
<p style="text-align: center;">Content:<br>
<table class="inner-body" align="center" cellpadding="0" cellspacing="0" border="0">
<tr>
<td>{{$content}}</td>
</tr>
</table>', 'status' => '1', 'store_id' => $storeId],

              ['name' => 'New order to admin', 'group' => 'order_success_to_admin', 'text' => '
<table class="inner-body" align="center" cellpadding="0" cellspacing="0">
  <tr>
      <td>
          <b>Order ID</b>: {{$orderID}}<br>
          <b>Customer name</b>: {{$toname}}<br>
          <b>Email</b>: {{$email}}<br>
          <b>Address</b>: {{$address}}<br>
          <b>Phone</b>: {{$phone}}<br>
          <b>Order note</b>: {{$comment}}
      </td>
  </tr>
</table>
<hr>
<p style="text-align: center;">Order detail:<br>
===================================<br></p>
<table class="inner-body" align="center" cellpadding="0" cellspacing="0" border="1">
  {{$orderDetail}}
  <tr>
      <td colspan="2"></td>
      <td colspan="2" style="font-weight: bold;">Sub total</td>
      <td colspan="2" align="right">{{$subtotal}}</td>
  </tr>
  <tr>
      <td colspan="2"></td>
      <td colspan="2" style="font-weight: bold;">Shipping fee</td>
      <td colspan="2" align="right">{{$shipping}}</td>
  </tr>
  <tr>
      <td colspan="2"></td>
      <td colspan="2" style="font-weight: bold;">Discount</td>
      <td colspan="2" align="right">{{$discount}}</td>
  </tr>
  <tr>
      <td colspan="2"></td>
      <td colspan="2" style="font-weight: bold;">Total</td>
      <td colspan="2" align="right">{{$total}}</td>
  </tr>
</table>', 'status' => '1', 'store_id' => $storeId],

              ['name' => 'New order to customr', 'group' => 'order_success_to_customer', 'text' => '
<table class="inner-body" align="center" cellpadding="0" cellspacing="0">
<tr>
  <td>
      <b>Order ID</b>: {{$orderID}}<br>
      <b>Customer name</b>: {{$toname}}<br>
      <b>Address</b>: {{$address}}<br>
      <b>Phone</b>: {{$phone}}<br>
      <b>Order note</b>: {{$comment}}
  </td>
</tr>
</table>
<hr>
<p style="text-align: center;">Order detail:<br>
===================================<br></p>
<table class="inner-body" align="center" cellpadding="0" cellspacing="0" border="1">
{{$orderDetail}}
<tr>
  <td colspan="2"></td>
  <td colspan="2" style="font-weight: bold;">Sub total</td>
  <td colspan="2" align="right">{{$subtotal}}</td>
</tr>
<tr>
  <td colspan="2"></td>
  <td colspan="2" style="font-weight: bold;">Shipping fee</td>
  <td colspan="2" align="right">{{$shipping}}</td>
</tr>
<tr>
  <td colspan="2"></td>
  <td colspan="2" style="font-weight: bold;">Discount</td>
  <td colspan="2" align="right">{{$discount}}</td>
</tr>
<tr>
  <td colspan="2"></td>
  <td colspan="2" style="font-weight: bold;">Total</td>
  <td colspan="2" align="right">{{$total}}</td>
</tr>
</table>', 'status' => '1', 'store_id' => $storeId],
          ]
      );


        DB::connection(SC_CONNECTION)->table(SC_DB_PREFIX.'shop_store_css')->insertOrIgnore(
            [
                [
                    'css' => '
.sc-overlay {
  position: fixed;
  top: 50%;
  left: 50%;
  transform: translate(-50%, -50%);
  transform: -webkit-translate(-50%, -50%);
  transform: -moz-translate(-50%, -50%);
  transform: -ms-translate(-50%, -50%);
  color:#1f222b;
  z-index: 9999;
  background: rgba(255,255,255,0.7);
}
  
#sc-loading{
  display: none;
  position: absolute;
  top: 0;
  left: 0;
  width: 100%;
  height: 100%;
  z-index: 50;
  background: rgba(255,255,255,0.7);
}
/*end loading */
  
/*price*/
.sc-new-price{
  color:#FE980F;
  font-size: 14px;
  padding: 10px 5px;
  font-weight:bold;
  }
  .sc-old-price {
  text-decoration: line-through;
  color: #a95d5d;
  font-size: 13px;
  padding: 10px;
  }
  /*end price*/
.sc-product-build{
  font-size: 20px;
  font-weight: bold;
}
.sc-product-build img{
  width: 50px;
}
.sc-product-group  img{
  width: 100px;
  cursor: pointer;
  }
.sc-product-group:hover{
  box-shadow: 0px 0px 2px #999;
}
.sc-product-group:active{
  box-shadow: 0px 0px 2px #ff00ff;
}
.sc-product-group.active{
  box-shadow: 0px 0px 2px #ff00ff;
}

.sc-shipping-address td{
  padding: 3px !important;
}
.sc-shipping-address textarea,
.sc-shipping-address input[type="text"],
.sc-shipping-address option{
  width: 100%;
  padding: 7px !important;
}
.row_cart>td{
  vertical-align: middle !important;
}
input[type="number"]{
  text-align: center;
  padding:2px;
}
.sc-notice{
  clear: both;
  clear: both;
  font-size: 20px;
  background: #f3f3f3;
  width: 100%;
}
img.new {
  position: absolute;
  right: 0px;
  top: 0px;
  padding: 0px !important;
}
.pointer {
  cursor: pointer: 
}
.add-to-cart-list {
  padding: 5px 10px !important;
  margin: 2px !important;
  letter-spacing: 0px !important;
  font-size: 12px !important;
  border-radius: 5px;
}
.help-block {
  font-size: 12px;
  color: red;
  font-style: italic;
}
                  ',
                    'store_id' => $storeId,
                ]
            ]);

            DB::connection(SC_CONNECTION)->table(SC_DB_PREFIX . 'shop_store_block')->insert(
              [
                  ['name' => 'Facebook code', 'position' => 'top', 'page' => '*', 'type' => 'html', 'text' => '
  <div id="fb-root"></div>
  <script>(function(d, s, id) {
  var js, fjs = d.getElementsByTagName(s)[0];
  if (d.getElementById(id)) return;
  js = d.createElement(s); js.id = id;
  js.src = \'//connect.facebook.net/vi_VN/sdk.js#xfbml=1&version=v2.8&appId=934208239994473\';
  fjs.parentNode.insertBefore(js, fjs);
  }(document, \'script\', \'facebook-jssdk\'));
  </script>', 'status' => '1', 'sort' => '0', 'store_id' => $storeId],
                  ['name' => 'Google Analytics', 'position' => 'header', 'page' => '*', 'type' => 'html', 'text' => '
  <!-- Global site tag (gtag.js) - Google Analytics -->
  <script async src="https://www.googletagmanager.com/gtag/js?id=UA-128658138-1"></script>
  <script>
  window.dataLayer = window.dataLayer || [];
  function gtag(){dataLayer.push(arguments);}
  gtag(\'js\', new Date());
  gtag(\'config\', \'UA-128658138-1\');
  </script>', 'status' => '1', 'sort' => '0', 'store_id' => $storeId],
  
                  ['name' => 'Product special', 'position' => 'left', 'page' => '*', 'type' => 'view', 'text' => 'product_special', 'status' => '1', 'sort' => '1', 'store_id' => $storeId],
                  ['name' => 'Brands', 'position' => 'left', 'page' => '*', 'type' => 'view', 'text' => 'brands_left', 'status' => '1', 'sort' => '3', 'store_id' => $storeId],
                  ['name' => 'Banner home', 'position' => 'banner_top', 'page' => 'home', 'type' => 'view', 'text' => 'banner_image', 'status' => '1', 'sort' => '0', 'store_id' => $storeId],
                  ['name' => 'Categories', 'position' => 'left', 'page' => 'home,shop_home', 'type' => 'view', 'text' => 'categories', 'status' => '1', 'sort' => '4', 'store_id' => $storeId],
                  ['name' => 'Product last view', 'position' => 'left', 'page' => '*', 'type' => 'view', 'text' => 'product_lastview', 'status' => '1', 'sort' => '0', 'store_id' => $storeId],
  
              ]
          );


    }
}
