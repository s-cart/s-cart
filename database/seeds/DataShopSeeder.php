<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DataShopSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        DB::connection(SC_CONNECTION)->table(SC_DB_PREFIX . 'shop_banner')->insert(
            [
                ['image' => '/data/banner/Main-banner-1-1903x600.jpg', 'html' => '', 'target' => '_self',  'status' => 1, 'type' => 0],
                ['image' => '/data/banner/Main-banner-3-1903x600.jpg', 'html' => '', 'target' => '_self',  'status' => 1, 'type' => 0],
                ['image' => '/data/banner/bgbr.jpg', 'html' => '', 'target' => '_self',  'status' => 1, 'type' => 2],
            ]
        );

        DB::connection(SC_CONNECTION)->table(SC_DB_PREFIX . 'shop_banner_store')->insert(
            [
                ['banner_id' => '1', 'store_id' => '0'],
                ['banner_id' => '2', 'store_id' => '0'],
                ['banner_id' => '3', 'store_id' => '0'],
            ]
        );

        DB::connection(SC_CONNECTION)->table(SC_DB_PREFIX . 'shop_email_template')->insert(
            [
                ['name' => 'Reset password', 'group' => 'forgot_password', 'text' => '<h1 style="font-family:Avenir,Helvetica,sans-serif;box-sizing:border-box;color:#2f3133;font-size:19px;font-weight:bold;margin-top:0;text-align:left">{{$title}}</h1>
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
                            <p style="font-family:Avenir,Helvetica,sans-serif;box-sizing:border-box;color:#74787e;line-height:1.5em;margin-top:0;text-align:left;font-size:12px">{{$note_access_link}}: <a href="{{$reset_link}}" style="font-family:Avenir,Helvetica,sans-serif;box-sizing:border-box;color:#3869d4" target="_blank">{{$reset_link}}</a></p>
                            </td>
                            </tr>
                        </tbody>
                        </table>', 'status' => '1'],

                ['name' => 'Welcome new customer', 'group' => 'welcome_customer', 'text' => '<h1 style="font-family:Avenir,Helvetica,sans-serif;box-sizing:border-box;color:#2f3133;font-size:19px;font-weight:bold;margin-top:0;text-align:center">{{$title}}</h1>
    <p style="text-align:center;">Welcome to my site!</p>', 'status' => '1'],
                ['name' => 'Send form contact to admin', 'group' => 'contact_to_admin', 'text' => '<table class="inner-body" align="center" width="570" cellpadding="0" cellspacing="0">
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
    <table class="inner-body" align="center" width="570" cellpadding="0" cellspacing="0" border="0">
        <tr>
            <td>{{$content}}</td>
        </tr>
    </table>', 'status' => '1'],

                ['name' => 'New order to admin', 'group' => 'order_success_to_admin', 'text' => '<table class="inner-body" align="center" width="570" cellpadding="0" cellspacing="0">
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
                        <table class="inner-body" align="center" width="570" cellpadding="0" cellspacing="0" border="1">
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
                        </table>', 'status' => '1'],

                ['name' => 'New order to customr', 'group' => 'order_success_to_customer', 'text' => '<table class="inner-body" align="center" width="570" cellpadding="0" cellspacing="0">
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
                        <table class="inner-body" align="center" width="570" cellpadding="0" cellspacing="0" border="1">
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
                        </table>', 'status' => '1'],
            ]
        );

        DB::connection(SC_CONNECTION)->table(SC_DB_PREFIX . 'shop_language')->insert(
            [
                ['id' => '1', 'name' => 'English', 'code' => 'en', 'icon' => '/data/language/flag_uk.png', 'status' => '1', 'rtl' => '0', 'sort' => '1'],
                ['id' => '2', 'name' => 'Tiếng Việt', 'code' => 'vi', 'icon' => '/data/language/flag_vn.png', 'status' => '1', 'rtl' => '0', 'sort' => '1'],
            ]
        );

        DB::connection(SC_CONNECTION)->table(SC_DB_PREFIX . 'shop_block_content')->insert(
            [
                ['name' => 'Facebook code', 'position' => 'top', 'page' => '*', 'type' => 'html', 'text' => '<div id="fb-root"></div>
    <script>(function(d, s, id) {
    var js, fjs = d.getElementsByTagName(s)[0];
    if (d.getElementById(id)) return;
    js = d.createElement(s); js.id = id;
    js.src = \'//connect.facebook.net/vi_VN/sdk.js#xfbml=1&version=v2.8&appId=934208239994473\';
    fjs.parentNode.insertBefore(js, fjs);
    }(document, \'script\', \'facebook-jssdk\'));
    </script>', 'status' => '1', 'sort' => '0'],
                ['name' => 'Google Analytics', 'position' => 'header', 'page' => '*', 'type' => 'html', 'text' => '<!-- Global site tag (gtag.js) - Google Analytics -->
    <script async src="https://www.googletagmanager.com/gtag/js?id=UA-128658138-1"></script>
    <script>
    window.dataLayer = window.dataLayer || [];
    function gtag(){dataLayer.push(arguments);}
    gtag(\'js\', new Date());
    gtag(\'config\', \'UA-128658138-1\');
    </script>', 'status' => '1', 'sort' => '0'],

                ['name' => 'Product special', 'position' => 'left', 'page' => '*', 'type' => 'view', 'text' => 'product_special', 'status' => '1', 'sort' => '1'],
                ['name' => 'Brands', 'position' => 'left', 'page' => '*', 'type' => 'view', 'text' => 'brands_left', 'status' => '1', 'sort' => '3'],
                ['name' => 'Banner home', 'position' => 'banner_top', 'page' => 'shop_home', 'type' => 'view', 'text' => 'banner_image', 'status' => '1', 'sort' => '0'],
                ['name' => 'Categories', 'position' => 'left', 'page' => '*', 'type' => 'view', 'text' => 'categories', 'status' => '1', 'sort' => '4'],
                ['name' => 'Product last view', 'position' => 'left', 'page' => '*', 'type' => 'view', 'text' => 'product_lastview', 'status' => '1', 'sort' => '0'],

            ]
        );

        DB::connection(SC_CONNECTION)->table(SC_DB_PREFIX . 'shop_layout_page')->insert(
            [
                ['key' => 'home', 'name' => 'lang::layout.page_position.home'],
                ['key' => 'shop_home', 'name' => 'lang::layout.page_position.shop_home'],
                ['key' => 'product_list', 'name' => 'lang::layout.page_position.product_list'],
                ['key' => 'product_detail', 'name' => 'lang::layout.page_position.product_detail'],
                ['key' => 'shop_cart', 'name' => 'lang::layout.page_position.shop_cart'],
                ['key' => 'item_list', 'name' => 'lang::layout.page_position.item_list'],
                ['key' => 'item_detail', 'name' => 'lang::layout.page_position.item_detail'],
                ['key' => 'news_list', 'name' => 'lang::layout.page_position.news_list'],
                ['key' => 'news_detail', 'name' => 'lang::layout.page_position.news_detail'],
                ['key' => 'shop_auth', 'name' => 'lang::layout.page_position.shop_auth'],
                ['key' => 'shop_profile', 'name' => 'lang::layout.page_position.shop_profile'],
                ['key' => 'shop_page', 'name' => 'lang::layout.page_position.shop_page'],
                ['key' => 'shop_contact', 'name' => 'lang::layout.page_position.shop_contact'],
                ['key' => 'content_list', 'name' => 'lang::layout.page_position.content_list'],
                ['key' => 'content_detail', 'name' => 'lang::layout.page_position.content_detail'],
            ]
        );
        DB::connection(SC_CONNECTION)->table(SC_DB_PREFIX . 'shop_layout_position')->insert(
            [
                ['key' => 'meta', 'name' => 'lang::layout.page_block.meta'],
                ['key' => 'header', 'name' => 'lang::layout.page_block.header'],
                ['key' => 'top', 'name' => 'lang::layout.page_block.top'],
                ['key' => 'bottom', 'name' => 'lang::layout.page_block.bottom'],
                ['key' => 'left', 'name' => 'lang::layout.page_block.left'],
                ['key' => 'right', 'name' => 'lang::layout.page_block.right'],
                ['key' => 'banner_top', 'name' => 'lang::layout.page_block.banner_top'],
            ]
        );
        DB::connection(SC_CONNECTION)->table(SC_DB_PREFIX . 'shop_link')->insert(
            [
                ['name' => 'lang::front.contact', 'url' => 'route::page.detail::contact', 'target' => '_self', 'module' => '', 'group' => 'menu', 'status' => '1', 'sort' => '3'],
                ['name' => 'lang::front.about', 'url' => 'route::page.detail::about', 'target' => '_self', 'module' => '', 'group' => 'menu', 'status' => '1', 'sort' => '4'],
                ['name' => 'lang::front.my_profile', 'url' => '/member/login.html', 'target' => '_self', 'module' => '', 'group' => 'footer', 'status' => '1', 'sort' => '5'],
                ['name' => 'lang::front.compare_page', 'url' => '/compare.html', 'target' => '_self', 'module' => '', 'group' => 'footer', 'status' => '1', 'sort' => '4'],
                ['name' => 'lang::front.wishlist_page', 'url' => 'route::wishlist', 'target' => '_self', 'module' => '', 'group' => 'footer', 'status' => '1', 'sort' => '3'],
            ]
        );
        DB::connection(SC_CONNECTION)->table(SC_DB_PREFIX . 'shop_shipping_standard')->insert(
            [
                ['fee' => 20, 'shipping_free' => 10000],
            ]
        );

        DB::connection(SC_CONNECTION)->table(SC_DB_PREFIX . 'shop_product_category')->insert(
            [
                ['product_id' => '1', 'category_id' => '13'],
                ['product_id' => '2', 'category_id' => '13'],
                ['product_id' => '1', 'category_id' => '10'],
                ['product_id' => '1', 'category_id' => '6'],
                ['product_id' => '3', 'category_id' => '11'],
                ['product_id' => '4', 'category_id' => '11'],
                ['product_id' => '5', 'category_id' => '11'],
                ['product_id' => '6', 'category_id' => '11'],
                ['product_id' => '7', 'category_id' => '12'],
                ['product_id' => '8', 'category_id' => '10'],
                ['product_id' => '9', 'category_id' => '6'],
                ['product_id' => '10', 'category_id' => '11'],
                ['product_id' => '11', 'category_id' => '10'],
                ['product_id' => '12', 'category_id' => '9'],
                ['product_id' => '13', 'category_id' => '5'],
                ['product_id' => '14', 'category_id' => '11'],
                ['product_id' => '15', 'category_id' => '6'],
                ['product_id' => '16', 'category_id' => '9'],
                ['product_id' => '17', 'category_id' => '9'],
            ]
        );

        DB::connection(SC_CONNECTION)->table(SC_DB_PREFIX . 'shop_product_store')->insert(
            [
                ['product_id' => '1', 'store_id' => '0'],
                ['product_id' => '2', 'store_id' => '0'],
                ['product_id' => '3', 'store_id' => '0'],
                ['product_id' => '4', 'store_id' => '0'],
                ['product_id' => '5', 'store_id' => '0'],
                ['product_id' => '6', 'store_id' => '0'],
                ['product_id' => '7', 'store_id' => '0'],
                ['product_id' => '8', 'store_id' => '0'],
                ['product_id' => '9', 'store_id' => '0'],
                ['product_id' => '10', 'store_id' => '0'],
                ['product_id' => '11', 'store_id' => '0'],
                ['product_id' => '12', 'store_id' => '0'],
                ['product_id' => '13', 'store_id' => '0'],
                ['product_id' => '14', 'store_id' => '0'],
                ['product_id' => '15', 'store_id' => '0'],
                ['product_id' => '16', 'store_id' => '0'],
                ['product_id' => '17', 'store_id' => '0'],
            ]
        );

        DB::connection(SC_CONNECTION)->table(SC_DB_PREFIX . 'shop_product_image')->insert(
            [
                ['image' => '/data/product/product-2.png', 'product_id' => '1'],
                ['image' => '/data/product/product-11.png', 'product_id' => '1'],
                ['image' => '/data/product/product-8.png', 'product_id' => '11'],
                ['image' => '/data/product/product-6.png', 'product_id' => '2'],
                ['image' => '/data/product/product-13.png', 'product_id' => '11'],
                ['image' => '/data/product/product-12.png', 'product_id' => '5'],
                ['image' => '/data/product/product-6.png', 'product_id' => '5'],
                ['image' => '/data/product/product-1.png', 'product_id' => '2'],
                ['image' => '/data/product/product-15.png', 'product_id' => '2'],
                ['image' => '/data/product/product-5.png', 'product_id' => '9'],
                ['image' => '/data/product/product-8.png', 'product_id' => '8'],
                ['image' => '/data/product/product-2.png', 'product_id' => '7'],
                ['image' => '/data/product/product-6.png', 'product_id' => '7'],
                ['image' => '/data/product/product-11.png', 'product_id' => '5'],
                ['image' => '/data/product/product-13.png', 'product_id' => '4'],
                ['image' => '/data/product/product-13.png', 'product_id' => '15'],
                ['image' => '/data/product/product-6.png', 'product_id' => '15'],
                ['image' => '/data/product/product-12.png', 'product_id' => '17'],
                ['image' => '/data/product/product-6.png', 'product_id' => '17'],
                ['image' => '/data/product/product-2.png', 'product_id' => '17'],
            ]
        );

        DB::connection(SC_CONNECTION)->table(SC_DB_PREFIX . 'shop_product_attribute')->insert(
            [
                ['name' => 'Blue', 'attribute_group_id' => '1', 'product_id' => '17', 'sort' => '0', 'add_price' => '50'],
                ['name' => 'White', 'attribute_group_id' => '1', 'product_id' => '17', 'sort' => '0', 'add_price' => '0'],
                ['name' => 'S', 'attribute_group_id' => '2', 'product_id' => '17', 'sort' => '0', 'add_price' => '20'],
                ['name' => 'XL', 'attribute_group_id' => '2', 'product_id' => '17', 'sort' => '0', 'add_price' => '30'],
                ['name' => 'Blue', 'attribute_group_id' => '1', 'product_id' => '10', 'sort' => '0', 'add_price' => '150'],
                ['name' => 'Red', 'attribute_group_id' => '1', 'product_id' => '10', 'sort' => '0', 'add_price' => '0'],
                ['name' => 'S', 'attribute_group_id' => '2', 'product_id' => '10', 'sort' => '0', 'add_price' => '0'],
                ['name' => 'M', 'attribute_group_id' => '2', 'product_id' => '10', 'sort' => '0', 'add_price' => '0'],
            ]
        );
        DB::connection(SC_CONNECTION)->table(SC_DB_PREFIX . 'shop_product_build')->insert(
            [
                ['build_id' => '15', 'product_id' => '6', 'quantity' => '1'],
                ['build_id' => '15', 'product_id' => '7', 'quantity' => '2'],
            ]
        );

        DB::connection(SC_CONNECTION)->table(SC_DB_PREFIX . 'shop_product_group')->insert(
            [
                ['group_id' => '16', 'product_id' => '1'],
                ['group_id' => '16', 'product_id' => '2'],
            ]
        );

        DB::connection(SC_CONNECTION)->table(SC_DB_PREFIX . 'shop_product_promotion')->insert(
            [
                ['product_id' => '1', 'price_promotion' => '5000'],
                ['product_id' => '2', 'price_promotion' => '3000'],
                ['product_id' => '13', 'price_promotion' => '4000'],
                ['product_id' => '11', 'price_promotion' => '600'],
            ]
        );
        DB::connection(SC_CONNECTION)->table(SC_DB_PREFIX . 'shop_attribute_group')->insert(
            [
                ['name' => 'Color', 'status' => '1', 'sort' => '1', 'type' => 'radio'],
                ['name' => 'Size', 'status' => '1', 'sort' => '2', 'type' => 'select'],
            ]
        );
        DB::connection(SC_CONNECTION)->table(SC_DB_PREFIX . 'shop_brand')->insert(
            [
                ['name' => 'Husq',  'alias' => 'husq', 'image' => '/data/brand/01-181x52.png', 'url' => '', 'status' => '1', 'sort' => '0'],
                ['name' => 'Ideal',  'alias' => 'ideal', 'image' => '/data/brand/02-181x52.png', 'url' => '', 'status' => '1', 'sort' => '0'],
                ['name' => 'Apex',  'alias' => 'apex', 'image' => '/data/brand/03-181x52.png', 'url' => '', 'status' => '1', 'sort' => '0'],
                ['name' => 'CST',  'alias' => 'cst', 'image' => '/data/brand/04-181x52.png', 'url' => '', 'status' => '1', 'sort' => '0'],
                ['name' => 'Klein',  'alias' => 'klein', 'image' => '/data/brand/05-181x52.png', 'url' => '', 'status' => '1', 'sort' => '0'],
                ['name' => 'Metabo',  'alias' => 'metabo', 'image' => '/data/brand/06-181x52.png', 'url' => '', 'status' => '1', 'sort' => '0'],
                ['name' => 'Avatar',  'alias' => 'avatar', 'image' => '/data/brand/07-181x52.png', 'url' => '', 'status' => '1', 'sort' => '0'],
                ['name' => 'Brand KA',  'alias' => 'brand-ka', 'image' => '/data/brand/08-181x52.png', 'url' => '', 'status' => '1', 'sort' => '0'],
            ]
        );

        DB::connection(SC_CONNECTION)->table(SC_DB_PREFIX . 'shop_currency')->insert(
            [
                ['id' => '1', 'name' => 'USD Dola', 'code' => 'USD', 'symbol' => '$', 'exchange_rate' => '1', 'precision' => '0', 'symbol_first' => '1', 'thousands' => ',', 'status' => '1', 'sort' => '0'],
                ['id' => '2', 'name' => 'VietNam Dong', 'code' => 'VND', 'symbol' => '₫', 'exchange_rate' => '20', 'precision' => '0', 'symbol_first' => '0', 'thousands' => ',', 'status' => '1', 'sort' => '1'],
            ]
        );

        DB::connection(SC_CONNECTION)->table(SC_DB_PREFIX . 'shop_order_status')->insert(
            [
                ['id' => '1', 'name' => 'New'],
                ['id' => '2', 'name' => 'Processing'],
                ['id' => '3', 'name' => 'Hold'],
                ['id' => '4', 'name' => 'Canceled'],
                ['id' => '5', 'name' => 'Done'],
                ['id' => '6', 'name' => 'Failed'],
            ]
        );
        DB::connection(SC_CONNECTION)->table(SC_DB_PREFIX . 'shop_page')->insert(
            [
                ['id' => '1', 'image' => '', 'alias' => 'about', 'status' => '1'],
            ]
        );
        DB::connection(SC_CONNECTION)->table(SC_DB_PREFIX . 'shop_page_description')->insert(
            [
                ['page_id' => '1', 'lang' => 'en', 'title' => 'About', 'keyword' => '', 'description' => '', 'content' => '<p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.<img alt="" src="/data/product/product-2.png" style="width: 262px; height: 262px; float: right; margin: 10px;" /></p>
    <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.</p>
    ',],
                ['page_id' => '1', 'lang' => 'vi', 'title' => 'Giới thiệu', 'keyword' => '', 'description' => '', 'content' => '<p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.<img alt="" src="/data/product/product-2.png" style="width: 262px; height: 262px; float: right; margin: 10px;" /></p>
    <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.</p>
    ',],
            ]
        );

        DB::connection(SC_CONNECTION)->table(SC_DB_PREFIX . 'shop_page_store')->insert(
            [
                ['page_id' => '1', 'store_id' => '0'],
            ]
        );

        DB::connection(SC_CONNECTION)->table(SC_DB_PREFIX . 'shop_payment_status')->insert(
            [
                ['id' => '1', 'name' => 'Unpaid'],
                ['id' => '2', 'name' => 'Partial payment'],
                ['id' => '3', 'name' => 'Paid'],
                ['id' => '4', 'name' => 'Refurn'],
            ]
        );

        DB::connection(SC_CONNECTION)->table(SC_DB_PREFIX . 'shop_shipping_status')->insert(
            [
                ['id' => '1', 'name' => 'Not sent'],
                ['id' => '2', 'name' => 'Sending'],
                ['id' => '3', 'name' => 'Shipping done'],
            ]
        );

        DB::connection(SC_CONNECTION)->table(SC_DB_PREFIX . 'shop_supplier')->insert(
            [
                ['id' => '1', 'alias' => 'abc-distributor',  'name' => 'ABC distributor', 'email' => 'abc@abc.com', 'phone' => '012496657567', 'image' => '/data/supplier/supplier.png', 'address' => '', 'url' => '', 'sort' => '0'],
                ['id' => '2', 'alias' => 'xyz-distributor',  'name' => 'XYZ distributor', 'email' => 'xyz@xyz.com', 'phone' => '012496657567', 'image' => '/data/supplier/supplier.png', 'address' => '', 'url' => '', 'sort' => '0'],
            ]
        );

        DB::connection(SC_CONNECTION)->table(SC_DB_PREFIX . 'shop_user')->insert(
            [
                ['id' => '1', 'first_name' => 'Naruto', 'last_name' => 'Kun', 'email' => 'test@test.com', 'password' => bcrypt(123), 'address1' => 'HCM', 'address2' => 'HCM city', 'phone' => '0667151172', 'postcode' => 70000, 'company' => 'KTC', 'country' => 'VN', 'created_at' => date('Y-m-d H:i:s')],
            ]
        );

        DB::connection(SC_CONNECTION)->table(SC_DB_PREFIX . 'shop_order')->insert(
            [
                ['id' => '1', 'user_id' => '1', 'subtotal' => '5000', 'shipping' => '2000', 'discount' => '0', 'payment_status' => '1', 'shipping_status' => '1', 'status' => '1', 'tax' => '0', 'total' => '7000', 'currency' => 'USD', 'exchange_rate' => '1', 'received' => '0', 'balance' => '7000', 'first_name' => 'Naruto', 'last_name' => 'Kun', 'address1' => 'ADDRESS 1', 'address2' => 'ADDRESS 2', 'country' => 'VN', 'phone' => '667151172', 'email' => 'test@test.com', 'comment' => 'ok', 'payment_method' => 'Cash', 'shipping_method' => 'ShippingStandard', 'created_at' => date('Y-m-d H:i:s')],
            ]
        );

        DB::connection(SC_CONNECTION)->table(SC_DB_PREFIX . 'shop_order_detail')->insert(
            [
                ['id' => '1', 'order_id' => '1', 'product_id' => '1', 'name' => 'Easy Polo Black Edition 1', 'price' => '5000', 'qty' => '1', 'total_price' => '5000', 'sku' => 'ABCZZ', 'currency' => 'USD', 'exchange_rate' => '1.00', 'attribute' => '[]'],
            ]
        );

        DB::connection(SC_CONNECTION)->table(SC_DB_PREFIX . 'shop_order_history')->insert(
            [
                ['id' => '1', 'order_id' => '1', 'content' => 'New order', 'admin_id' => '0', 'user_id' => '1', 'order_status_id' => '1', 'add_date' => date('Y-m-d H:i:s')],
            ]
        );

        DB::connection(SC_CONNECTION)->table(SC_DB_PREFIX . 'shop_order_total')->insert(
            [
                ['order_id' => '1', 'code' => 'subtotal', 'title' => 'Subtotal', 'value' => '5000', 'sort' => '1'],
                ['order_id' => '1', 'code' => 'shipping', 'title' => 'Shipping', 'value' => '2000', 'sort' => '10'],
                ['order_id' => '1', 'code' => 'discount', 'title' => 'Discount', 'value' => '0', 'sort' => '20'],
                ['order_id' => '1', 'code' => 'total', 'title' => 'Total', 'value' => '7000', 'sort' => '100'],
                ['order_id' => '1', 'code' => 'received', 'title' => 'Received', 'value' => '0', 'sort' => '200'],
            ]
        );

        DB::connection(SC_CONNECTION)->table(SC_DB_PREFIX . 'shop_country')->insert(
            [
                ['code' => 'AL', 'name' => 'Albania'],
                ['code' => 'DZ', 'name' => 'Algeria'],
                ['code' => 'DS', 'name' => 'American Samoa'],
                ['code' => 'AD', 'name' => 'Andorra'],
                ['code' => 'AO', 'name' => 'Angola'],
                ['code' => 'AI', 'name' => 'Anguilla'],
                ['code' => 'AQ', 'name' => 'Antarctica'],
                ['code' => 'AG', 'name' => 'Antigua and Barbuda'],
                ['code' => 'AR', 'name' => 'Argentina'],
                ['code' => 'AM', 'name' => 'Armenia'],
                ['code' => 'AW', 'name' => 'Aruba'],
                ['code' => 'AU', 'name' => 'Australia'],
                ['code' => 'AT', 'name' => 'Austria'],
                ['code' => 'AZ', 'name' => 'Azerbaijan'],
                ['code' => 'BS', 'name' => 'Bahamas'],
                ['code' => 'BH', 'name' => 'Bahrain'],
                ['code' => 'BD', 'name' => 'Bangladesh'],
                ['code' => 'BB', 'name' => 'Barbados'],
                ['code' => 'BY', 'name' => 'Belarus'],
                ['code' => 'BE', 'name' => 'Belgium'],
                ['code' => 'BZ', 'name' => 'Belize'],
                ['code' => 'BJ', 'name' => 'Benin'],
                ['code' => 'BM', 'name' => 'Bermuda'],
                ['code' => 'BT', 'name' => 'Bhutan'],
                ['code' => 'BO', 'name' => 'Bolivia'],
                ['code' => 'BA', 'name' => 'Bosnia and Herzegovina'],
                ['code' => 'BW', 'name' => 'Botswana'],
                ['code' => 'BV', 'name' => 'Bouvet Island'],
                ['code' => 'BR', 'name' => 'Brazil'],
                ['code' => 'IO', 'name' => 'British Indian Ocean Territory'],
                ['code' => 'BN', 'name' => 'Brunei Darussalam'],
                ['code' => 'BG', 'name' => 'Bulgaria'],
                ['code' => 'BF', 'name' => 'Burkina Faso'],
                ['code' => 'BI', 'name' => 'Burundi'],
                ['code' => 'KH', 'name' => 'Cambodia'],
                ['code' => 'CM', 'name' => 'Cameroon'],
                ['code' => 'CA', 'name' => 'Canada'],
                ['code' => 'CV', 'name' => 'Cape Verde'],
                ['code' => 'KY', 'name' => 'Cayman Islands'],
                ['code' => 'CF', 'name' => 'Central African Republic'],
                ['code' => 'TD', 'name' => 'Chad'],
                ['code' => 'CL', 'name' => 'Chile'],
                ['code' => 'CN', 'name' => 'China'],
                ['code' => 'CX', 'name' => 'Christmas Island'],
                ['code' => 'CC', 'name' => 'Cocos (Keeling) Islands'],
                ['code' => 'CO', 'name' => 'Colombia'],
                ['code' => 'KM', 'name' => 'Comoros'],
                ['code' => 'CG', 'name' => 'Congo'],
                ['code' => 'CK', 'name' => 'Cook Islands'],
                ['code' => 'CR', 'name' => 'Costa Rica'],
                ['code' => 'HR', 'name' => 'Croatia (Hrvatska)'],
                ['code' => 'CU', 'name' => 'Cuba'],
                ['code' => 'CY', 'name' => 'Cyprus'],
                ['code' => 'CZ', 'name' => 'Czech Republic'],
                ['code' => 'DK', 'name' => 'Denmark'],
                ['code' => 'DJ', 'name' => 'Djibouti'],
                ['code' => 'DM', 'name' => 'Dominica'],
                ['code' => 'DO', 'name' => 'Dominican Republic'],
                ['code' => 'TP', 'name' => 'East Timor'],
                ['code' => 'EC', 'name' => 'Ecuador'],
                ['code' => 'EG', 'name' => 'Egypt'],
                ['code' => 'SV', 'name' => 'El Salvador'],
                ['code' => 'GQ', 'name' => 'Equatorial Guinea'],
                ['code' => 'ER', 'name' => 'Eritrea'],
                ['code' => 'EE', 'name' => 'Estonia'],
                ['code' => 'ET', 'name' => 'Ethiopia'],
                ['code' => 'FK', 'name' => 'Falkland Islands (Malvinas)'],
                ['code' => 'FO', 'name' => 'Faroe Islands'],
                ['code' => 'FJ', 'name' => 'Fiji'],
                ['code' => 'FI', 'name' => 'Finland'],
                ['code' => 'FR', 'name' => 'France'],
                ['code' => 'FX', 'name' => 'France, Metropolitan'],
                ['code' => 'GF', 'name' => 'French Guiana'],
                ['code' => 'PF', 'name' => 'French Polynesia'],
                ['code' => 'TF', 'name' => 'French Southern Territories'],
                ['code' => 'GA', 'name' => 'Gabon'],
                ['code' => 'GM', 'name' => 'Gambia'],
                ['code' => 'GE', 'name' => 'Georgia'],
                ['code' => 'DE', 'name' => 'Germany'],
                ['code' => 'GH', 'name' => 'Ghana'],
                ['code' => 'GI', 'name' => 'Gibraltar'],
                ['code' => 'GK', 'name' => 'Guernsey'],
                ['code' => 'GR', 'name' => 'Greece'],
                ['code' => 'GL', 'name' => 'Greenland'],
                ['code' => 'GD', 'name' => 'Grenada'],
                ['code' => 'GP', 'name' => 'Guadeloupe'],
                ['code' => 'GU', 'name' => 'Guam'],
                ['code' => 'GT', 'name' => 'Guatemala'],
                ['code' => 'GN', 'name' => 'Guinea'],
                ['code' => 'GW', 'name' => 'Guinea-Bissau'],
                ['code' => 'GY', 'name' => 'Guyana'],
                ['code' => 'HT', 'name' => 'Haiti'],
                ['code' => 'HM', 'name' => 'Heard and Mc Donald Islands'],
                ['code' => 'HN', 'name' => 'Honduras'],
                ['code' => 'HK', 'name' => 'Hong Kong'],
                ['code' => 'HU', 'name' => 'Hungary'],
                ['code' => 'IS', 'name' => 'Iceland'],
                ['code' => 'IN', 'name' => 'India'],
                ['code' => 'IM', 'name' => 'Isle of Man'],
                ['code' => 'ID', 'name' => 'Indonesia'],
                ['code' => 'IR', 'name' => 'Iran (Islamic Republic of)'],
                ['code' => 'IQ', 'name' => 'Iraq'],
                ['code' => 'IE', 'name' => 'Ireland'],
                ['code' => 'IL', 'name' => 'Israel'],
                ['code' => 'IT', 'name' => 'Italy'],
                ['code' => 'CI', 'name' => 'Ivory Coast'],
                ['code' => 'JE', 'name' => 'Jersey'],
                ['code' => 'JM', 'name' => 'Jamaica'],
                ['code' => 'JP', 'name' => 'Japan'],
                ['code' => 'JO', 'name' => 'Jordan'],
                ['code' => 'KZ', 'name' => 'Kazakhstan'],
                ['code' => 'KE', 'name' => 'Kenya'],
                ['code' => 'KI', 'name' => 'Kiribati'],
                ['code' => 'KP', 'name' => 'Korea,Democratic People\'s Republic of'],
                ['code' => 'KR', 'name' => 'Korea, Republic of'],
                ['code' => 'XK', 'name' => 'Kosovo'],
                ['code' => 'KW', 'name' => 'Kuwait'],
                ['code' => 'KG', 'name' => 'Kyrgyzstan'],
                ['code' => 'LA', 'name' => 'Lao People\'s Democratic Republic'],
                ['code' => 'LV', 'name' => 'Latvia'],
                ['code' => 'LB', 'name' => 'Lebanon'],
                ['code' => 'LS', 'name' => 'Lesotho'],
                ['code' => 'LR', 'name' => 'Liberia'],
                ['code' => 'LY', 'name' => 'Libyan Arab Jamahiriya'],
                ['code' => 'LI', 'name' => 'Liechtenstein'],
                ['code' => 'LT', 'name' => 'Lithuania'],
                ['code' => 'LU', 'name' => 'Luxembourg'],
                ['code' => 'MO', 'name' => 'Macau'],
                ['code' => 'MK', 'name' => 'Macedonia'],
                ['code' => 'MG', 'name' => 'Madagascar'],
                ['code' => 'MW', 'name' => 'Malawi'],
                ['code' => 'MY', 'name' => 'Malaysia'],
                ['code' => 'MV', 'name' => 'Maldives'],
                ['code' => 'ML', 'name' => 'Mali'],
                ['code' => 'MT', 'name' => 'Malta'],
                ['code' => 'MH', 'name' => 'Marshall Islands'],
                ['code' => 'MQ', 'name' => 'Martinique'],
                ['code' => 'MR', 'name' => 'Mauritania'],
                ['code' => 'MU', 'name' => 'Mauritius'],
                ['code' => 'TY', 'name' => 'Mayotte'],
                ['code' => 'MX', 'name' => 'Mexico'],
                ['code' => 'FM', 'name' => 'Micronesia, Federated States of'],
                ['code' => 'MD', 'name' => 'Moldova, Republic of'],
                ['code' => 'MC', 'name' => 'Monaco'],
                ['code' => 'MN', 'name' => 'Mongolia'],
                ['code' => 'ME', 'name' => 'Montenegro'],
                ['code' => 'MS', 'name' => 'Montserrat'],
                ['code' => 'MA', 'name' => 'Morocco'],
                ['code' => 'MZ', 'name' => 'Mozambique'],
                ['code' => 'MM', 'name' => 'Myanmar'],
                ['code' => 'NA', 'name' => 'Namibia'],
                ['code' => 'NR', 'name' => 'Nauru'],
                ['code' => 'NP', 'name' => 'Nepal'],
                ['code' => 'NL', 'name' => 'Netherlands'],
                ['code' => 'AN', 'name' => 'Netherlands Antilles'],
                ['code' => 'NC', 'name' => 'New Caledonia'],
                ['code' => 'NZ', 'name' => 'New Zealand'],
                ['code' => 'NI', 'name' => 'Nicaragua'],
                ['code' => 'NE', 'name' => 'Niger'],
                ['code' => 'NG', 'name' => 'Nigeria'],
                ['code' => 'NU', 'name' => 'Niue'],
                ['code' => 'NF', 'name' => 'Norfolk Island'],
                ['code' => 'MP', 'name' => 'Northern Mariana Islands'],
                ['code' => 'NO', 'name' => 'Norway'],
                ['code' => 'OM', 'name' => 'Oman'],
                ['code' => 'PK', 'name' => 'Pakistan'],
                ['code' => 'PW', 'name' => 'Palau'],
                ['code' => 'PS', 'name' => 'Palestine'],
                ['code' => 'PA', 'name' => 'Panama'],
                ['code' => 'PG', 'name' => 'Papua New Guinea'],
                ['code' => 'PY', 'name' => 'Paraguay'],
                ['code' => 'PE', 'name' => 'Peru'],
                ['code' => 'PH', 'name' => 'Philippines'],
                ['code' => 'PN', 'name' => 'Pitcairn'],
                ['code' => 'PL', 'name' => 'Poland'],
                ['code' => 'PT', 'name' => 'Portugal'],
                ['code' => 'PR', 'name' => 'Puerto Rico'],
                ['code' => 'QA', 'name' => 'Qatar'],
                ['code' => 'RE', 'name' => 'Reunion'],
                ['code' => 'RO', 'name' => 'Romania'],
                ['code' => 'RU', 'name' => 'Russian Federation'],
                ['code' => 'RW', 'name' => 'Rwanda'],
                ['code' => 'KN', 'name' => 'Saint Kitts and Nevis'],
                ['code' => 'LC', 'name' => 'Saint Lucia'],
                ['code' => 'VC', 'name' => 'Saint Vincent and the Grenadines'],
                ['code' => 'WS', 'name' => 'Samoa'],
                ['code' => 'SM', 'name' => 'San Marino'],
                ['code' => 'ST', 'name' => 'Sao Tome and Principe'],
                ['code' => 'SA', 'name' => 'Saudi Arabia'],
                ['code' => 'SN', 'name' => 'Senegal'],
                ['code' => 'RS', 'name' => 'Serbia'],
                ['code' => 'SC', 'name' => 'Seychelles'],
                ['code' => 'SL', 'name' => 'Sierra Leone'],
                ['code' => 'SG', 'name' => 'Singapore'],
                ['code' => 'SK', 'name' => 'Slovakia'],
                ['code' => 'SI', 'name' => 'Slovenia'],
                ['code' => 'SB', 'name' => 'Solomon Islands'],
                ['code' => 'SO', 'name' => 'Somalia'],
                ['code' => 'ZA', 'name' => 'South Africa'],
                ['code' => 'GS', 'name' => 'South Georgia South Sandwich Islands'],
                ['code' => 'SS', 'name' => 'South Sudan'],
                ['code' => 'ES', 'name' => 'Spain'],
                ['code' => 'LK', 'name' => 'Sri Lanka'],
                ['code' => 'SH', 'name' => 'St. Helena'],
                ['code' => 'PM', 'name' => 'St. Pierre and Miquelon'],
                ['code' => 'SD', 'name' => 'Sudan'],
                ['code' => 'SR', 'name' => 'Suriname'],
                ['code' => 'SJ', 'name' => 'Svalbard and Jan Mayen Islands'],
                ['code' => 'SZ', 'name' => 'Swaziland'],
                ['code' => 'SE', 'name' => 'Sweden'],
                ['code' => 'CH', 'name' => 'Switzerland'],
                ['code' => 'SY', 'name' => 'Syrian Arab Republic'],
                ['code' => 'TW', 'name' => 'Taiwan'],
                ['code' => 'TJ', 'name' => 'Tajikistan'],
                ['code' => 'TZ', 'name' => 'Tanzania, United Republic of'],
                ['code' => 'TH', 'name' => 'Thailand'],
                ['code' => 'TG', 'name' => 'Togo'],
                ['code' => 'TK', 'name' => 'Tokelau'],
                ['code' => 'TO', 'name' => 'Tonga'],
                ['code' => 'TT', 'name' => 'Trinidad and Tobago'],
                ['code' => 'TN', 'name' => 'Tunisia'],
                ['code' => 'TR', 'name' => 'Turkey'],
                ['code' => 'TM', 'name' => 'Turkmenistan'],
                ['code' => 'TC', 'name' => 'Turks and Caicos Islands'],
                ['code' => 'TV', 'name' => 'Tuvalu'],
                ['code' => 'UG', 'name' => 'Uganda'],
                ['code' => 'UA', 'name' => 'Ukraine'],
                ['code' => 'AE', 'name' => 'United Arab Emirates'],
                ['code' => 'GB', 'name' => 'United Kingdom'],
                ['code' => 'US', 'name' => 'United States'],
                ['code' => 'UM', 'name' => 'United States minor outlying islands'],
                ['code' => 'UY', 'name' => 'Uruguay'],
                ['code' => 'UZ', 'name' => 'Uzbekistan'],
                ['code' => 'VU', 'name' => 'Vanuatu'],
                ['code' => 'VA', 'name' => 'Vatican City State'],
                ['code' => 'VE', 'name' => 'Venezuela'],
                ['code' => 'VN', 'name' => 'Vietnam'],
                ['code' => 'VG', 'name' => 'Virgin Islands (British)'],
                ['code' => 'VI', 'name' => 'Virgin Islands (U.S.)'],
                ['code' => 'WF', 'name' => 'Wallis and Futuna Islands'],
                ['code' => 'EH', 'name' => 'Western Sahara'],
                ['code' => 'YE', 'name' => 'Yemen'],
                ['code' => 'ZR', 'name' => 'Zaire'],
                ['code' => 'ZM', 'name' => 'Zambia'],
                ['code' => 'ZW', 'name' => 'Zimbabwe'],
            ]
        );

        DB::connection(SC_CONNECTION)->table(SC_DB_PREFIX . 'api_connection')->insert(
            [
                ['description' => 'Demo api connection', 'apiconnection' => 'appmobile', 'apikey' => uniqid(), 'status' => 1],
            ]
        );

        DB::connection(SC_CONNECTION)->table(SC_DB_PREFIX . 'shop_tax')->insert(
            [
                ['id' => '1', 'name' => 'Tax default (10%)', 'value' => 10],
            ]
        );

        DB::connection(SC_CONNECTION)->table(SC_DB_PREFIX . 'shop_weight')->insert(
            [
                ['id' => '1', 'name' => 'g', 'description' => 'Gram'],
                ['id' => '2', 'name' => 'kg', 'description' => 'Kilogram'],
                ['id' => '3', 'name' => 'lb', 'description' => 'Pound '],
                ['id' => '4', 'name' => 'oz', 'description' => 'Ounce '],
            ]
        );

        DB::connection(SC_CONNECTION)->table(SC_DB_PREFIX . 'shop_length')->insert(
            [
                ['id' => '1', 'name' => 'mm', 'description' => 'Millimeter'],
                ['id' => '2', 'name' => 'cm', 'description' => 'Centimeter'],
                ['id' => '3', 'name' => 'm', 'description' => 'Meter'],
                ['id' => '4', 'name' => 'in', 'description' => 'Inch'],
            ]
        );
    }
}
