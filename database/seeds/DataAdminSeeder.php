<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
class DataAdminSeeder extends Seeder
{
    public $adminUser = 'admin';
    //admin
    public $adminPassword = '$2y$10$JcmAHe5eUZ2rS0jU1GWr/.xhwCnh2RU13qwjTPcqfmtZXjZxcryPO';
    public $adminEmail = 'your-email@your-domain.com';
    public $timezone_default = 'Asia/Ho_Chi_Minh';
    public $language_default = 'en';

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::connection(SC_CONNECTION)->table(SC_DB_PREFIX.'admin_menu')->insert(
            [
            ['id' => 1, 'parent_id' => 6, 'sort' => 1, 'title' => 'lang::admin.menu_titles.order_manager', 'icon' => 'fas fa-cart-arrow-down', 'uri' => '', 'key' => 'ORDER_MANAGER', 'type' => 0],
            ['id' => 2, 'parent_id' => 6, 'sort' => 2, 'title' => 'lang::admin.menu_titles.catalog_mamager', 'icon' => 'fas fa-folder-open', 'uri' => '', 'key' => 'CATALOG_MANAGER', 'type' => 0],
            ['id' => 3, 'parent_id' => 6, 'sort' => 3, 'title' => 'lang::admin.menu_titles.customer_manager', 'icon' => 'fas fa-users', 'uri' => '', 'key' => 'CUSTOMER_MANAGER', 'type' => 0],
            ['id' => 4, 'parent_id' => 8, 'sort' => 201, 'title' => 'lang::admin.menu_titles.template_layout', 'icon' => 'fas fa-object-ungroup', 'uri' => '', 'key' => 'TEMPLATE', 'type' => 0],
            ['id' => 5, 'parent_id' => 9, 'sort' => 2, 'title' => 'lang::admin.menu_titles.config_system', 'icon' => 'fas fa-cogs', 'uri' => '', 'key' => 'CONFIG_SYSTEM', 'type' => 0],
            ['id' => 6, 'parent_id' => 0, 'sort' => 10, 'title' => 'lang::admin.ADMIN_SHOP', 'icon' => 'fas fa-cog', 'uri' => '', 'key' => 'ADMIN_SHOP', 'type' => 0],
            ['id' => 7, 'parent_id' => 0, 'sort' => 100, 'title' => 'lang::admin.ADMIN_CONTENT', 'icon' => 'fas fa-cog', 'uri' => '', 'key' => 'ADMIN_CONTENT', 'type' => 0],
            ['id' => 8, 'parent_id' => 0, 'sort' => 200, 'title' => 'lang::admin.ADMIN_EXTENSION', 'icon' => 'fas fa-cog', 'uri' => '', 'key' => 'ADMIN_EXTENSION', 'type' => 0],
            ['id' => 9, 'parent_id' => 0, 'sort' => 300, 'title' => 'lang::admin.ADMIN_SYSTEM', 'icon' => 'fas fa-cog', 'uri' => '', 'key' => 'ADMIN_SYSTEM', 'type' => 0],
            ['id' => 10, 'parent_id' => 7, 'sort' => 102, 'title' => 'lang::page.admin.title', 'icon' => 'fas fa-clone', 'uri' => 'admin::page', 'key' => null, 'type' => 0],
            ['id' => 11, 'parent_id' => 1, 'sort' => 6, 'title' => 'lang::shipping_status.admin.title', 'icon' => 'fas fa-truck', 'uri' => 'admin::shipping_status', 'key' => null, 'type' => 0],
            ['id' => 12, 'parent_id' => 1, 'sort' => 3, 'title' => 'lang::order.admin.title', 'icon' => 'fas fa-shopping-cart', 'uri' => 'admin::order', 'key' => null, 'type' => 0],
            ['id' => 13, 'parent_id' => 1, 'sort' => 4, 'title' => 'lang::order_status.admin.title', 'icon' => 'fas fa-asterisk', 'uri' => 'admin::order_status', 'key' => null, 'type' => 0],
            ['id' => 14, 'parent_id' => 1, 'sort' => 5, 'title' => 'lang::payment_status.admin.title', 'icon' => 'fas fa-recycle', 'uri' => 'admin::payment_status', 'key' => null, 'type' => 0],
            ['id' => 15, 'parent_id' => 2, 'sort' => 0, 'title' => 'lang::product.admin.title', 'icon' => 'far fa-file-image', 'uri' => 'admin::product', 'key' => null, 'type' => 0],
            ['id' => 16, 'parent_id' => 2, 'sort' => 0, 'title' => 'lang::category.admin.title', 'icon' => 'far fa-folder-open', 'uri' => 'admin::category', 'key' => null, 'type' => 0],
            ['id' => 17, 'parent_id' => 2, 'sort' => 0, 'title' => 'lang::supplier.admin.title', 'icon' => 'fas fa-user-secret', 'uri' => 'admin::supplier', 'key' => null, 'type' => 0],
            ['id' => 18, 'parent_id' => 2, 'sort' => 0, 'title' => 'lang::brand.admin.title', 'icon' => 'fas fa-university', 'uri' => 'admin::brand', 'key' => null, 'type' => 0],
            ['id' => 19, 'parent_id' => 2, 'sort' => 0, 'title' => 'lang::attribute_group.admin.title', 'icon' => 'fas fa-bars', 'uri' => 'admin::attribute_group', 'key' => null, 'type' => 0],
            ['id' => 20, 'parent_id' => 3, 'sort' => 0, 'title' => 'lang::customer.admin.title', 'icon' => 'fas fa-user', 'uri' => 'admin::customer', 'key' => null, 'type' => 0],
            ['id' => 21, 'parent_id' => 3, 'sort' => 0, 'title' => 'lang::subscribe.admin.title', 'icon' => 'fas fa-user-circle', 'uri' => 'admin::subscribe', 'key' => null, 'type' => 0],
            ['id' => 22, 'parent_id' => 4, 'sort' => 0, 'title' => 'lang::block_content.admin.title', 'icon' => 'far fa-newspaper', 'uri' => 'admin::block_content', 'key' => null, 'type' => 0],
            ['id' => 23, 'parent_id' => 4, 'sort' => 0, 'title' => 'lang::admin.menu_titles.block_link', 'icon' => 'fab fa-chrome', 'uri' => 'admin::link', 'key' => null, 'type' => 0],
            ['id' => 24, 'parent_id' => 4, 'sort' => 0, 'title' => 'lang::admin.menu_titles.template_manager', 'icon' => 'fas fa-columns', 'uri' => 'admin::template', 'key' => null, 'type' => 0],
            ['id' => 26, 'parent_id' => 65, 'sort' => 1, 'title' => 'lang::store.admin.title', 'icon' => 'fas fa-h-square', 'uri' => 'admin::store', 'key' => null, 'type' => 0],
            ['id' => 27, 'parent_id' => 9, 'sort' => 4, 'title' => 'lang::admin.menu_titles.email_setting', 'icon' => 'fas fa-envelope', 'uri' => '', 'key' => null, 'type' => 0],
            ['id' => 28, 'parent_id' => 27, 'sort' => 0, 'title' => 'lang::email.admin.title', 'icon' => 'fas fa-cog', 'uri' => 'admin::email', 'key' => null, 'type' => 0],
            ['id' => 29, 'parent_id' => 27, 'sort' => 0, 'title' => 'lang::email_template.admin.title', 'icon' => 'fas fa-bars', 'uri' => 'admin::email_template', 'key' => null, 'type' => 0],
            ['id' => 30, 'parent_id' => 9, 'sort' => 5, 'title' => 'lang::admin.menu_titles.localisation', 'icon' => 'fab fa-shirtsinbulk', 'uri' => '', 'key' => null, 'type' => 0],
            ['id' => 31, 'parent_id' => 30, 'sort' => 0, 'title' => 'lang::language.admin.title', 'icon' => 'fas fa-language', 'uri' => 'admin::language', 'key' => null, 'type' => 0],
            ['id' => 32, 'parent_id' => 30, 'sort' => 0, 'title' => 'lang::currency.admin.title', 'icon' => 'far fa-money-bill-alt', 'uri' => 'admin::currency', 'key' => null, 'type' => 0],
            ['id' => 33, 'parent_id' => 7, 'sort' => 101, 'title' => 'lang::banner.admin.title', 'icon' => 'fas fa-image', 'uri' => 'admin::banner', 'key' => null, 'type' => 0],
            ['id' => 34, 'parent_id' => 5, 'sort' => 5, 'title' => 'lang::backup.admin.title', 'icon' => 'fas fa-save', 'uri' => 'admin::backup', 'key' => null, 'type' => 0],
            ['id' => 35, 'parent_id' => 8, 'sort' => 202, 'title' => 'lang::admin.menu_titles.plugins', 'icon' => 'fas fa-puzzle-piece', 'uri' => '', 'key' => 'PLUGIN', 'type' => 0],
            ['id' => 37, 'parent_id' => 6, 'sort' => 4, 'title' => 'lang::admin.menu_titles.report_manager', 'icon' => 'fas fa-chart-pie', 'uri' => '', 'key' => 'REPORT_MANAGER', 'type' => 0],
            ['id' => 38, 'parent_id' => 9, 'sort' => 1, 'title' => 'lang::admin.menu_titles.admin', 'icon' => 'fas fa-users-cog', 'uri' => '', 'key' => 'ADMIN', 'type' => 0],
            ['id' => 39, 'parent_id' => 35, 'sort' => 0, 'title' => 'plugin.Payment', 'icon' => 'far fa-money-bill-alt', 'uri' => 'admin::plugin/payment', 'key' => null, 'type' => 0],
            ['id' => 40, 'parent_id' => 35, 'sort' => 0, 'title' => 'plugin.Shipping', 'icon' => 'fas fa-ambulance', 'uri' => 'admin::plugin/shipping', 'key' => null, 'type' => 0],
            ['id' => 41, 'parent_id' => 35, 'sort' => 0, 'title' => 'plugin.Total', 'icon' => 'fas fa-cog', 'uri' => 'admin::plugin/total', 'key' => null, 'type' => 0],
            ['id' => 42, 'parent_id' => 35, 'sort' => 100, 'title' => 'plugin.Other', 'icon' => 'far fa-circle', 'uri' => 'admin::plugin/other', 'key' => null, 'type' => 0],
            ['id' => 43, 'parent_id' => 35, 'sort' => 0, 'title' => 'plugin.Cms', 'icon' => 'fab fa-modx', 'uri' => 'admin::plugin/cms', 'key' => null, 'type' => 0],
            ['id' => 46, 'parent_id' => 38, 'sort' => 0, 'title' => 'lang::admin.menu_titles.users', 'icon' => 'fas fa-users', 'uri' => 'admin::user', 'key' => null, 'type' => 0],
            ['id' => 47, 'parent_id' => 38, 'sort' => 0, 'title' => 'lang::admin.menu_titles.roles', 'icon' => 'fas fa-user', 'uri' => 'admin::role', 'key' => null, 'type' => 0],
            ['id' => 48, 'parent_id' => 38, 'sort' => 0, 'title' => 'lang::admin.menu_titles.permission', 'icon' => 'fas fa-ban', 'uri' => 'admin::permission', 'key' => null, 'type' => 0],
            ['id' => 49, 'parent_id' => 38, 'sort' => 0, 'title' => 'lang::admin.menu_titles.menu', 'icon' => 'fas fa-bars', 'uri' => 'admin::menu', 'key' => null, 'type' => 0],
            ['id' => 50, 'parent_id' => 38, 'sort' => 0, 'title' => 'lang::admin.menu_titles.operation_log', 'icon' => 'fas fa-history', 'uri' => 'admin::log', 'key' => null, 'type' => 0],
            ['id' => 52, 'parent_id' => 7, 'sort' => 103, 'title' => 'lang::news.admin.title', 'icon' => 'far fa-file-powerpoint', 'uri' => 'admin::news', 'key' => null, 'type' => 0],
            ['id' => 53, 'parent_id' => 5, 'sort' => 3, 'title' => 'lang::config.title', 'icon' => 'fas fa-tools', 'uri' => 'admin::config', 'key' => null, 'type' => 0],
            ['id' => 54, 'parent_id' => 37, 'sort' => 0, 'title' => 'lang::admin.menu_titles.report_product', 'icon' => 'fas fa-bars', 'uri' => 'admin::report/product', 'key' => null, 'type' => 0],
            ['id' => 55, 'parent_id' => 2, 'sort' => 100, 'title' => 'lang::product.config_manager.title', 'icon' => 'fas fa fa-cog', 'uri' => 'admin::product_config', 'key' => null, 'type' => 0],
            ['id' => 56, 'parent_id' => 3, 'sort' => 100, 'title' => 'lang::customer.config_manager.title', 'icon' => 'fas fa fa-cog', 'uri' => 'admin::customer_config', 'key' => null, 'type' => 0],
            ['id' => 57, 'parent_id' => 5, 'sort' => 2, 'title' => 'lang::link.config_manager.title', 'icon' => 'fab fa-gg', 'uri' => 'admin::url_config', 'key' => null, 'type' => 0],
            ['id' => 58, 'parent_id' => 5, 'sort' => 5, 'title' => 'lang::admin.menu_titles.cache_manager', 'icon' => 'fab fa-tripadvisor', 'uri' => 'admin::cache_config', 'key' => null, 'type' => 0],
            ['id' => 59, 'parent_id' => 9, 'sort' => 7, 'title' => 'lang::admin.menu_titles.api_manager', 'icon' => 'fas fa-plug', 'uri' => '', 'key' => 'API_MANAGER', 'type' => 0],
            ['id' => 60, 'parent_id' => 65, 'sort' => 3, 'title' => 'lang::store_maintain.config_manager.title', 'icon' => 'fas fa-wrench', 'uri' => 'admin::store_maintain', 'key' => null, 'type' => 0],
            ['id' => 61, 'parent_id' => 2, 'sort' => 4, 'title' => 'lang::tax.admin.admin_title', 'icon' => 'far fa-calendar-minus', 'uri' => 'admin::tax', 'key' => null, 'type' => 0],
            ['id' => 62, 'parent_id' => 2, 'sort' => 5, 'title' => 'lang::weight.admin.title', 'icon' => 'fas fa-balance-scale', 'uri' => 'admin::weight_unit', 'key' => null, 'type' => 0],
            ['id' => 63, 'parent_id' => 2, 'sort' => 6, 'title' => 'lang::length.admin.title', 'icon' => 'fas fa-minus', 'uri' => 'admin::length_unit', 'key' => null, 'type' => 0],
            ['id' => 64, 'parent_id' => 1, 'sort' => 100, 'title' => 'lang::order.admin.config_title', 'icon' => 'fas fa fa-cog', 'uri' => 'admin::order_config', 'key' => null, 'type' => 0],
            ['id' => 65, 'parent_id' => 9, 'sort' => 3, 'title' => 'lang::admin.menu_titles.store_manager', 'icon' => 'fas fa-store-alt', 'uri' => '', 'key' => 'STORE_MANAGER', 'type' => 0],
            ['id' => 66, 'parent_id' => 59, 'sort' => 1, 'title' => 'lang::admin.menu_titles.api_config', 'icon' => 'fas fa fa-cog', 'uri' => 'admin::api_connection', 'key' => null, 'type' => 0],
            ]
        );

        DB::connection(SC_CONNECTION)->table(SC_DB_PREFIX.'admin_permission')->insert(
            [
            ['id' => '1', 'name' => 'Admin manager', 'slug' => 'admin.manager', 'http_uri' => 'GET::'.SC_ADMIN_PREFIX.'/user,GET::'.SC_ADMIN_PREFIX.'/role,GET::'.SC_ADMIN_PREFIX.'/permission,ANY::'.SC_ADMIN_PREFIX.'/log/*,ANY::'.SC_ADMIN_PREFIX.'/menu/*', 'created_at' => date('Y-m-d H:i:s')],
            ['id' => '2', 'name' => 'Dashboard', 'slug' => 'dashboard', 'http_uri' => 'GET::'.SC_ADMIN_PREFIX.'', 'created_at' => date('Y-m-d H:i:s')],
            ['id' => '3', 'name' => 'Auth manager', 'slug' => 'auth.full', 'http_uri' => 'ANY::'.SC_ADMIN_PREFIX.'/auth/*', 'created_at' => date('Y-m-d H:i:s')],
            ['id' => '4', 'name' => 'Setting manager', 'slug' => 'config.full', 'http_uri' => 'ANY::'.SC_ADMIN_PREFIX.'/store/*,ANY::'.SC_ADMIN_PREFIX.'/config/*,ANY::'.SC_ADMIN_PREFIX.'/url_config/*,ANY::'.SC_ADMIN_PREFIX.'/product_config/*,ANY::'.SC_ADMIN_PREFIX.'/order_config/*,ANY::'.SC_ADMIN_PREFIX.'/customer_config/*,ANY::'.SC_ADMIN_PREFIX.'/cache_config/*,ANY::'.SC_ADMIN_PREFIX.'/email/*,ANY::'.SC_ADMIN_PREFIX.'/email_template/*,ANY::'.SC_ADMIN_PREFIX.'/language/*,ANY::'.SC_ADMIN_PREFIX.'/currency/*,ANY::'.SC_ADMIN_PREFIX.'/backup/*,ANY::'.SC_ADMIN_PREFIX.'/api_connection/*,ANY::'.SC_ADMIN_PREFIX.'/maintain/*,ANY::'.SC_ADMIN_PREFIX.'/tax/*','created_at' => date('Y-m-d H:i:s')],
            ['id' => '5', 'name' => 'Upload management', 'slug' => 'upload.full', 'http_uri' => 'ANY::'.SC_ADMIN_PREFIX.'/uploads/*', 'created_at' => date('Y-m-d H:i:s')],
            ['id' => '6', 'name' => 'Plugin manager', 'slug' => 'plugin.full', 'http_uri' => 'ANY::'.SC_ADMIN_PREFIX.'/plugin/*', 'created_at' => date('Y-m-d H:i:s')],
            ['id' => '8', 'name' => 'CMS manager', 'slug' => 'cms.full', 'http_uri' => 'ANY::'.SC_ADMIN_PREFIX.'/page/*,ANY::'.SC_ADMIN_PREFIX.'/banner/*,ANY::'.SC_ADMIN_PREFIX.'/cms_category/*,ANY::'.SC_ADMIN_PREFIX.'/cms_content/*,ANY::'.SC_ADMIN_PREFIX.'/news/*', 'created_at' => date('Y-m-d H:i:s')],
            ['id' => '11', 'name' => 'Discount manager', 'slug' => 'discount.full', 'http_uri' => 'ANY::'.SC_ADMIN_PREFIX.'/shop_discount/*', 'created_at' => date('Y-m-d H:i:s')],
            ['id' => '14', 'name' => 'Shipping status', 'slug' => 'shipping_status.full', 'http_uri' => 'ANY::'.SC_ADMIN_PREFIX.'/shipping_status/*', 'created_at' => date('Y-m-d H:i:s')],
            ['id' => '15', 'name' => 'Payment  status', 'slug' => 'payment_status.full', 'http_uri' => 'ANY::'.SC_ADMIN_PREFIX.'/payment_status/*', 'created_at' => date('Y-m-d H:i:s')],
            ['id' => '17', 'name' => 'Customer manager', 'slug' => 'customer.full', 'http_uri' => 'ANY::'.SC_ADMIN_PREFIX.'/customer/*,ANY::'.SC_ADMIN_PREFIX.'/subscribe/*', 'created_at' => date('Y-m-d H:i:s')],
            ['id' => '18', 'name' => 'Order status', 'slug' => 'order_status.full', 'http_uri' => 'ANY::'.SC_ADMIN_PREFIX.'/order_status/*', 'created_at' => date('Y-m-d H:i:s')],
            ['id' => '19', 'name' => 'Product manager', 'slug' => 'product.full','http_uri' => 'ANY::'.SC_ADMIN_PREFIX.'/category/*,ANY::'.SC_ADMIN_PREFIX.'/supplier/*,ANY::'.SC_ADMIN_PREFIX.'/brand/*,ANY::'.SC_ADMIN_PREFIX.'/attribute_group/*,ANY::'.SC_ADMIN_PREFIX.'/product/,ANY::'.SC_ADMIN_PREFIX.'/weight_unit/*,ANY::'.SC_ADMIN_PREFIX.'/length_unit/*','created_at' => date('Y-m-d H:i:s')],
            ['id' => '20', 'name' => 'Order Manager', 'slug' => 'order.full', 'http_uri' => 'ANY::'.SC_ADMIN_PREFIX.'/order/*', 'created_at' => date('Y-m-d H:i:s')],
            ['id' => '21', 'name' => 'Report manager', 'slug' => 'report.full', 'http_uri' => 'ANY::'.SC_ADMIN_PREFIX.'/report/*', 'created_at' => date('Y-m-d H:i:s')],
            ['id' => '22', 'name' => 'Template manager', 'slug' => 'template.full', 'http_uri' => 'ANY::'.SC_ADMIN_PREFIX.'/block_content/*,ANY::'.SC_ADMIN_PREFIX.'/link/*,ANY::'.SC_ADMIN_PREFIX.'/template/*', 'created_at' => date('Y-m-d H:i:s')],
             ]
        );

        DB::connection(SC_CONNECTION)->table(SC_DB_PREFIX.'admin_role')->insert(
            [
            ['id' => '1', 'name' => 'Administrator', 'slug' => 'administrator', 'created_at' => date('Y-m-d H:i:s')],
            ['id' => '2', 'name' => 'Group only View', 'slug' => 'view.all', 'created_at' => date('Y-m-d H:i:s')],
            ['id' => '3', 'name' => 'Manager', 'slug' => 'manager', 'created_at' => date('Y-m-d H:i:s')],
            ['id' => '4', 'name' => 'Cms manager', 'slug' => 'cms', 'created_at' => date('Y-m-d H:i:s')],
            ['id' => '5', 'name' => 'Accountant', 'slug' => 'accountant', 'created_at' => date('Y-m-d H:i:s')],
            ['id' => '6', 'name' => 'Marketing', 'slug' => 'maketing', 'created_at' => date('Y-m-d H:i:s')]]
        );

        DB::connection(SC_CONNECTION)->table(SC_DB_PREFIX.'admin_role_permission')->insert(
            [
            ['role_id' => 3, 'permission_id' => 5, 'created_at' => date('Y-m-d H:i:s')],
            ['role_id' => 3, 'permission_id' => 1, 'created_at' => date('Y-m-d H:i:s')],
            ['role_id' => 3, 'permission_id' => 3, 'created_at' => date('Y-m-d H:i:s')],
            ['role_id' => 3, 'permission_id' => 8, 'created_at' => date('Y-m-d H:i:s')],
            ['role_id' => 3, 'permission_id' => 17, 'created_at' => date('Y-m-d H:i:s')],
            ['role_id' => 3, 'permission_id' => 2, 'created_at' => date('Y-m-d H:i:s')],
            ['role_id' => 3, 'permission_id' => 11, 'created_at' => date('Y-m-d H:i:s')],
            ['role_id' => 3, 'permission_id' => 20, 'created_at' => date('Y-m-d H:i:s')],
            ['role_id' => 3, 'permission_id' => 18, 'created_at' => date('Y-m-d H:i:s')],
            ['role_id' => 3, 'permission_id' => 15, 'created_at' => date('Y-m-d H:i:s')],
            ['role_id' => 3, 'permission_id' => 19, 'created_at' => date('Y-m-d H:i:s')],
            ['role_id' => 3, 'permission_id' => 21, 'created_at' => date('Y-m-d H:i:s')],
            ['role_id' => 3, 'permission_id' => 4, 'created_at' => date('Y-m-d H:i:s')],
            ['role_id' => 3, 'permission_id' => 22, 'created_at' => date('Y-m-d H:i:s')],
            ['role_id' => 3, 'permission_id' => 14, 'created_at' => date('Y-m-d H:i:s')],
            ['role_id' => 4, 'permission_id' => 3, 'created_at' => date('Y-m-d H:i:s')],
            ['role_id' => 4, 'permission_id' => 8, 'created_at' => date('Y-m-d H:i:s')],
            ['role_id' => 5, 'permission_id' => 2, 'created_at' => date('Y-m-d H:i:s')],
            ['role_id' => 5, 'permission_id' => 20, 'created_at' => date('Y-m-d H:i:s')],
            ['role_id' => 5, 'permission_id' => 3, 'created_at' => date('Y-m-d H:i:s')],
            ['role_id' => 5, 'permission_id' => 21, 'created_at' => date('Y-m-d H:i:s')],
            ['role_id' => 6, 'permission_id' => 5, 'created_at' => date('Y-m-d H:i:s')],
            ['role_id' => 6, 'permission_id' => 3, 'created_at' => date('Y-m-d H:i:s')],
            ['role_id' => 6, 'permission_id' => 8, 'created_at' => date('Y-m-d H:i:s')],
            ['role_id' => 6, 'permission_id' => 17, 'created_at' => date('Y-m-d H:i:s')],
            ['role_id' => 6, 'permission_id' => 2, 'created_at' => date('Y-m-d H:i:s')],
            ['role_id' => 6, 'permission_id' => 11, 'created_at' => date('Y-m-d H:i:s')],
            ['role_id' => 6, 'permission_id' => 20, 'created_at' => date('Y-m-d H:i:s')],
            ['role_id' => 6, 'permission_id' => 15, 'created_at' => date('Y-m-d H:i:s')],
            ['role_id' => 6, 'permission_id' => 19, 'created_at' => date('Y-m-d H:i:s')],
            ['role_id' => 6, 'permission_id' => 21, 'created_at' => date('Y-m-d H:i:s')],
            ['role_id' => 6, 'permission_id' => 14, 'created_at' => date('Y-m-d H:i:s')],
            ['role_id' => 6, 'permission_id' => 18, 'created_at' => date('Y-m-d H:i:s')],
            ['role_id' => 4, 'permission_id' => 5, 'created_at' => date('Y-m-d H:i:s')],
            ]
        );
        
        DB::connection(SC_CONNECTION)->table(SC_DB_PREFIX.'admin_role_user')->insert(
            ['role_id' => '1', 'user_id' => '1']
        );

        if (!empty(session('infoInstall')['admin_user'])) {
            $this->adminUser = session('infoInstall')['admin_user'];
        }
        if (!empty(session('infoInstall')['admin_password'])) {
            $this->adminPassword = session('infoInstall')['admin_password'];
        }
        if (!empty(session('infoInstall')['admin_email'])) {
            $this->adminEmail = session('infoInstall')['admin_email'];
        }
        DB::connection(SC_CONNECTION)->table(SC_DB_PREFIX.'admin_user')->insert(
            ['id' => '1', 'username' => $this->adminUser, 'password' => $this->adminPassword, 'email' => $this->adminEmail, 'name' => 'Administrator', 'avatar' => '/admin/avatar/user.jpg', 'created_at' => date('Y-m-d H:i:s')]
        );
        
        
        if (!empty(session('infoInstall')['timezone_default'])) {
            $this->timezone_default = session('infoInstall')['timezone_default'];
        }
        if (!empty(session('infoInstall')['language_default'])) {
            $this->language_default = session('infoInstall')['language_default'];
        }
        DB::connection(SC_CONNECTION)->table(SC_DB_PREFIX.'admin_config')->insert(
            [
            ['group' => 'Plugins', 'code' => 'Payment', 'key' => 'Cash', 'value' => '1', 'sort' => '0', 'detail' => 'Plugins/Payment/Cash::lang.title', 'store_id' => 0],
            ['group' => 'Plugins', 'code' => 'Shipping', 'key' => 'ShippingStandard', 'value' => '1', 'sort' => '0', 'detail' => 'lang::Shipping Standard', 'store_id' => 0],

            ['group' => 'global', 'code' => 'env_global', 'key' => 'ADMIN_LOG', 'value' => 'on', 'sort' => '0', 'detail' => 'lang::env.ADMIN_LOG', 'store_id' => 0],
            ['group' => 'global', 'code' => 'env_global', 'key' => 'ADMIN_LOG_EXP', 'value' => '', 'sort' => '0', 'detail' => 'lang::env.ADMIN_LOG_EXP', 'store_id' => 0],
            ['group' => 'global', 'code' => 'config_other', 'key' => 'domain_strict', 'value' => '0', 'sort' => '1', 'detail' => 'lang::config.domain_strict', 'store_id' => 0],
            
            ['group' => 'global', 'code' => 'cache', 'key' => 'cache_status', 'value' => '0', 'sort' => '0', 'detail' => 'lang::cache.config_manager.cache_status', 'store_id' => 0],
            ['group' => 'global', 'code' => 'cache', 'key' => 'cache_time', 'value' => '600', 'sort' => '0', 'detail' => 'lang::cache.config_manager.cache_time', 'store_id' => 0],
            ['group' => 'global', 'code' => 'cache', 'key' => 'cache_category', 'value' => '0', 'sort' => '3', 'detail' => 'lang::cache.config_manager.cache_category', 'store_id' => 0],
            ['group' => 'global', 'code' => 'cache', 'key' => 'cache_product', 'value' => '0', 'sort' => '4', 'detail' => 'lang::cache.config_manager.cache_product', 'store_id' => 0],
            ['group' => 'global', 'code' => 'cache', 'key' => 'cache_news', 'value' => '0', 'sort' => '5', 'detail' => 'lang::cache.config_manager.cache_news', 'store_id' => 0],
            ['group' => 'global', 'code' => 'cache', 'key' => 'cache_category_cms', 'value' => '0', 'sort' => '6', 'detail' => 'lang::cache.config_manager.cache_category_cms', 'store_id' => 0],
            ['group' => 'global', 'code' => 'cache', 'key' => 'cache_content_cms', 'value' => '0', 'sort' => '7', 'detail' => 'lang::cache.config_manager.cache_content_cms', 'store_id' => 0],
            ['group' => 'global', 'code' => 'cache', 'key' => 'cache_page', 'value' => '0', 'sort' => '8', 'detail' => 'lang::cache.config_manager.cache_page', 'store_id' => 0],
            ['group' => 'global', 'code' => 'cache', 'key' => 'cache_country', 'value' => '0', 'sort' => '10', 'detail' => 'lang::cache.config_manager.cache_country', 'store_id' => 0],
            
            ]
        );
        DB::connection(SC_CONNECTION)->table(SC_DB_PREFIX.'admin_store')->insert(
            [
                'logo' => 'data/logo/scart-mid.png', 
                'template' => 's-cart-3x', 
                'phone' => '0123456789', 
                'long_phone' => 'Support: 0987654321', 
                'email' => $this->adminEmail, 
                'time_active' => '', 
                'address' => '123st - abc - xyz', 
                'timezone' => $this->timezone_default, 
                'language' => $this->language_default, 
                'currency' => 'USD', 
                'domain' => Str::finish(str_replace(['http://','https://', '/install.php'], '', url('/')), '/')
            ]
        );
        
        DB::connection(SC_CONNECTION)->table(SC_DB_PREFIX.'admin_store_description')->insert(
            [
                ['store_id' => '1', 'lang' => 'en', 'title' => 'Demo SCart : Free Laravel eCommerce', 'description' => 'Free website shopping cart for business', 'keyword' => '', 'maintain_content' => '<center><img src="/images/maintenance.png" />
    <h3><span style="color:#e74c3c;"><strong>Sorry! We are currently doing site maintenance!</strong></span></h3>
    </center>'],
                ['store_id' => '1', 'lang' => 'vi', 'title' => 'Demo SCart: Mã nguồn website thương mại điện tử miễn phí', 'description' => 'Laravel shopping cart for business', 'keyword' => '', 'maintain_content' => '<center><img src="/images/maintenance.png" />
    <h3><span style="color:#e74c3c;"><strong>Xin lỗi! Hiện tại website đang bảo trì!</strong></span></h3>
    </center>'],
            ]
        );
    }
}
