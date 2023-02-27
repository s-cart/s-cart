<?php

namespace App\Pmo\DB\Traits;
use DB;
use Illuminate\Support\Str;

trait DataStoreSeederTrait
{
    public function getTemplateDefault() {
        return  empty(session('lastStoreTemplate')) ? 's-pmo-light' : session('lastStoreTemplate');
    }
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function runProcess()
    {
        $storeId = empty(session('lastStoreId')) ? SC_ID_ROOT : session('lastStoreId');

        $db = DB::connection(SC_CONNECTION);

        $dataConfig = $this->dataConfig($storeId);
        $db->table(SC_DB_PREFIX.'admin_config')->insert($dataConfig);

        $dataEmailTemplate = $this->dataEmailTemplate($storeId);
        $db->table(SC_DB_PREFIX.'shop_email_template')->insert($dataEmailTemplate);
        
        $dataShopLink = $this->dataShopLink();
        $db->table(SC_DB_PREFIX.'shop_link')->insert($dataShopLink);

        $dataShopLinkStore = $this->dataShopLinkStore($dataShopLink, $storeId);
        $db->table(SC_DB_PREFIX.'shop_link_store')->insert($dataShopLinkStore);


        if (file_exists($fileProcess = resource_path() . '/views/templates/'.$this->getTemplateDefault().'/Provider.php')) {
            include_once $fileProcess;
            if (function_exists('sc_template_install_store')) {
                //Insert only specify store
                sc_template_install_store($storeId);
            }
        } 
    }
    
    public function dataConfig($storeId) {
        $dataConfig = [
            ['group' => '','code' => 'product_config_attribute','key' => 'product_brand','value' => '1','sort' => '0','detail' => 'product.config_manager.brand','store_id' => $storeId],
            ['group' => '','code' => 'product_config_attribute_required','key' => 'product_brand_required','value' => '0','sort' => '0','detail' => '','store_id' => $storeId],
            ['group' => '','code' => 'product_config_attribute','key' => 'product_supplier','value' => '1','sort' => '0','detail' => 'product.config_manager.supplier','store_id' => $storeId],
            ['group' => '','code' => 'product_config_attribute_required','key' => 'product_supplier_required','value' => '0','sort' => '0','detail' => '','store_id' => $storeId],
            ['group' => '','code' => 'product_config_attribute','key' => 'product_price','value' => '1','sort' => '0','detail' => 'product.config_manager.price','store_id' => $storeId],
            ['group' => '','code' => 'product_config_attribute_required','key' => 'product_price_required','value' => '1','sort' => '0','detail' => '','store_id' => $storeId],
            ['group' => '','code' => 'product_config_attribute','key' => 'product_cost','value' => '1','sort' => '0','detail' => 'product.config_manager.cost','store_id' => $storeId],
            ['group' => '','code' => 'product_config_attribute_required','key' => 'product_cost_required','value' => '0','sort' => '0','detail' => '','store_id' => $storeId],
            ['group' => '','code' => 'product_config_attribute','key' => 'product_promotion','value' => '1','sort' => '0','detail' => 'product.config_manager.promotion','store_id' => $storeId],
            ['group' => '','code' => 'product_config_attribute_required','key' => 'product_promotion_required','value' => '0','sort' => '0','detail' => '','store_id' => $storeId],
            ['group' => '','code' => 'product_config_attribute','key' => 'product_stock','value' => '1','sort' => '0','detail' => 'product.config_manager.stock','store_id' => $storeId],
            ['group' => '','code' => 'product_config_attribute_required','key' => 'product_stock_required','value' => '0','sort' => '0','detail' => '','store_id' => $storeId],
            ['group' => '','code' => 'product_config_attribute','key' => 'product_kind','value' => '1','sort' => '0','detail' => 'product.config_manager.kind','store_id' => $storeId],
            ['group' => '','code' => 'product_config_attribute','key' => 'product_property','value' => '1','sort' => '0','detail' => 'product.config_manager.property','store_id' => $storeId],
            ['group' => '','code' => 'product_config_attribute_required','key' => 'product_property_required','value' => '0','sort' => '0','detail' => '','store_id' => $storeId],
            ['group' => '','code' => 'product_config_attribute','key' => 'product_attribute','value' => '1','sort' => '0','detail' => 'product.config_manager.attribute','store_id' => $storeId],
            ['group' => '','code' => 'product_config_attribute_required','key' => 'product_attribute_required','value' => '0','sort' => '0','detail' => '','store_id' => $storeId],
            ['group' => '','code' => 'product_config_attribute','key' => 'product_available','value' => '1','sort' => '0','detail' => 'product.config_manager.available','store_id' => $storeId],
            ['group' => '','code' => 'product_config_attribute_required','key' => 'product_available_required','value' => '0','sort' => '0','detail' => '','store_id' => $storeId],
            ['group' => '','code' => 'product_config_attribute','key' => 'product_weight','value' => '1','sort' => '0','detail' => 'product.config_manager.weight','store_id' => $storeId],
            ['group' => '','code' => 'product_config_attribute_required','key' => 'product_weight_required','value' => '0','sort' => '0','detail' => '','store_id' => $storeId],
            ['group' => '','code' => 'product_config_attribute','key' => 'product_length','value' => '1','sort' => '0','detail' => 'product.config_manager.length','store_id' => $storeId],
            ['group' => '','code' => 'product_config_attribute_required','key' => 'product_length_required','value' => '0','sort' => '0','detail' => '','store_id' => $storeId],
            ['group' => '','code' => 'product_config','key' => 'product_display_out_of_stock','value' => '1','sort' => '19','detail' => 'product.config_manager.product_display_out_of_stock','store_id' => $storeId],
            ['group' => '','code' => 'product_config','key' => 'show_date_available','value' => '1','sort' => '21','detail' => 'product.config_manager.show_date_available','store_id' => $storeId],
            ['group' => '','code' => 'product_config','key' => 'product_cart_off','value' => '0','sort' => '22','detail' => 'product.config_manager.product_cart_off','store_id' => $storeId],
            ['group' => '','code' => 'product_config','key' => 'product_wishlist_off','value' => '0','sort' => '23','detail' => 'product.config_manager.product_wishlist_off','store_id' => $storeId],
            ['group' => '','code' => 'product_config','key' => 'product_compare_off','value' => '0','sort' => '24','detail' => 'product.config_manager.product_compare_off','store_id' => $storeId],
            ['group' => '','code' => 'product_config','key' => 'product_tax','value' => '1','sort' => '0','detail' => 'product.config_manager.tax','store_id' => $storeId],
            ['group' => '','code' => 'customer_config_attribute','key' => 'customer_lastname','value' => '1','sort' => '1','detail' => 'customer.config_manager.lastname','store_id' => $storeId],
            ['group' => '','code' => 'customer_config_attribute_required','key' => 'customer_lastname_required','value' => '1','sort' => '1','detail' => '','store_id' => $storeId],
            ['group' => '','code' => 'customer_config_attribute','key' => 'customer_address1','value' => '1','sort' => '2','detail' => 'customer.config_manager.address1','store_id' => $storeId],
            ['group' => '','code' => 'customer_config_attribute_required','key' => 'customer_address1_required','value' => '1','sort' => '2','detail' => '','store_id' => $storeId],
            ['group' => '','code' => 'customer_config_attribute','key' => 'customer_address2','value' => '1','sort' => '2','detail' => 'customer.config_manager.address2','store_id' => $storeId],
            ['group' => '','code' => 'customer_config_attribute_required','key' => 'customer_address2_required','value' => '1','sort' => '2','detail' => '','store_id' => $storeId],
            ['group' => '','code' => 'customer_config_attribute','key' => 'customer_address3','value' => '0','sort' => '2','detail' => 'customer.config_manager.address3','store_id' => $storeId],
            ['group' => '','code' => 'customer_config_attribute_required','key' => 'customer_address3_required','value' => '0','sort' => '2','detail' => '','store_id' => $storeId],
            ['group' => '','code' => 'customer_config_attribute','key' => 'customer_company','value' => '0','sort' => '0','detail' => 'customer.config_manager.company','store_id' => $storeId],
            ['group' => '','code' => 'customer_config_attribute_required','key' => 'customer_company_required','value' => '0','sort' => '0','detail' => '','store_id' => $storeId],
            ['group' => '','code' => 'customer_config_attribute','key' => 'customer_postcode','value' => '0','sort' => '0','detail' => 'customer.config_manager.postcode','store_id' => $storeId],
            ['group' => '','code' => 'customer_config_attribute_required','key' => 'customer_postcode_required','value' => '0','sort' => '0','detail' => '','store_id' => $storeId],
            ['group' => '','code' => 'customer_config_attribute','key' => 'customer_country','value' => '1','sort' => '0','detail' => 'customer.config_manager.country','store_id' => $storeId],
            ['group' => '','code' => 'customer_config_attribute_required','key' => 'customer_country_required','value' => '1','sort' => '0','detail' => '','store_id' => $storeId],
            ['group' => '','code' => 'customer_config_attribute','key' => 'customer_group','value' => '0','sort' => '0','detail' => 'customer.config_manager.group','store_id' => $storeId],
            ['group' => '','code' => 'customer_config_attribute_required','key' => 'customer_group_required','value' => '0','sort' => '0','detail' => '','store_id' => $storeId],
            ['group' => '','code' => 'customer_config_attribute','key' => 'customer_birthday','value' => '0','sort' => '0','detail' => 'customer.config_manager.birthday','store_id' => $storeId],
            ['group' => '','code' => 'customer_config_attribute_required','key' => 'customer_birthday_required','value' => '0','sort' => '0','detail' => '','store_id' => $storeId],
            ['group' => '','code' => 'customer_config_attribute','key' => 'customer_sex','value' => '0','sort' => '0','detail' => 'customer.config_manager.sex','store_id' => $storeId],
            ['group' => '','code' => 'customer_config_attribute_required','key' => 'customer_sex_required','value' => '0','sort' => '0','detail' => '','store_id' => $storeId],
            ['group' => '','code' => 'customer_config_attribute','key' => 'customer_phone','value' => '1','sort' => '0','detail' => 'customer.config_manager.phone','store_id' => $storeId],
            ['group' => '','code' => 'customer_config_attribute_required','key' => 'customer_phone_required','value' => '1','sort' => '1','detail' => '','store_id' => $storeId],
            ['group' => '','code' => 'customer_config_attribute','key' => 'customer_name_kana','value' => '0','sort' => '0','detail' => 'customer.config_manager.name_kana','store_id' => $storeId],
            ['group' => '','code' => 'customer_config_attribute_required','key' => 'customer_name_kana_required','value' => '0','sort' => '1','detail' => '','store_id' => $storeId],
            ['group' => '','code' => 'admin_config','key' => 'ADMIN_NAME','value' => 's-pmo System','sort' => '0','detail' => 'admin.env.ADMIN_NAME','store_id' => $storeId],
            ['group' => '','code' => 'admin_config','key' => 'ADMIN_TITLE','value' => 's-pmo Admin','sort' => '0','detail' => 'admin.env.ADMIN_TITLE','store_id' => $storeId],
            ['group' => '','code' => 'admin_config','key' => 'ADMIN_LOGO','value' => 's-pmo <span class="brand-text font-weight-light">Admin</span>','sort' => '0','detail' => 'admin.env.ADMIN_LOGO','store_id' => $storeId],
            ['group' => '','code' => 'admin_config','key' => 'hidden_copyright_footer','value' => '0','sort' => '0','detail' => 'admin.env.hidden_copyright_footer','store_id' => $storeId],
            ['group' => '','code' => 'admin_config','key' => 'hidden_copyright_footer_admin','value' => '0','sort' => '0','detail' => 'admin.env.hidden_copyright_footer_admin','store_id' => $storeId],
            ['group' => '','code' => 'display_config','key' => 'product_top','value' => '12','sort' => '0','detail' => 'store.display.product_top','store_id' => $storeId],
            ['group' => '','code' => 'display_config','key' => 'product_list','value' => '12','sort' => '0','detail' => 'store.display.list_product','store_id' => $storeId],
            ['group' => '','code' => 'display_config','key' => 'product_relation','value' => '4','sort' => '0','detail' => 'store.display.relation_product','store_id' => $storeId],
            ['group' => '','code' => 'display_config','key' => 'product_viewed','value' => '4','sort' => '0','detail' => 'store.display.viewed_product','store_id' => $storeId],
            ['group' => '','code' => 'display_config','key' => 'item_list','value' => '12','sort' => '0','detail' => 'store.display.item_list','store_id' => $storeId],
            ['group' => '','code' => 'display_config','key' => 'item_top','value' => '12','sort' => '0','detail' => 'store.display.item_top','store_id' => $storeId],
            ['group' => '','code' => 'order_config','key' => 'shop_allow_guest','value' => '1','sort' => '11','detail' => 'order.admin.shop_allow_guest','store_id' => $storeId],
            ['group' => '','code' => 'order_config','key' => 'product_preorder','value' => '1','sort' => '18','detail' => 'order.admin.product_preorder','store_id' => $storeId],
            ['group' => '','code' => 'order_config','key' => 'product_buy_out_of_stock','value' => '1','sort' => '20','detail' => 'order.admin.product_buy_out_of_stock','store_id' => $storeId],
            ['group' => '','code' => 'order_config','key' => 'shipping_off','value' => '0','sort' => '20','detail' => 'order.admin.shipping_off','store_id' => $storeId],
            ['group' => '','code' => 'order_config','key' => 'payment_off','value' => '0','sort' => '20','detail' => 'order.admin.payment_off','store_id' => $storeId],
            ['group' => '','code' => 'email_action','key' => 'email_action_mode','value' => '0','sort' => '0','detail' => 'email.email_action.email_action_mode','store_id' => $storeId],
            ['group' => '','code' => 'email_action','key' => 'email_action_queue','value' => '0','sort' => '1','detail' => 'email.email_action.email_action_queue','store_id' => $storeId],
            ['group' => '','code' => 'email_action','key' => 'order_success_to_admin','value' => '0','sort' => '1','detail' => 'email.email_action.order_success_to_admin','store_id' => $storeId],
            ['group' => '','code' => 'email_action','key' => 'order_success_to_customer','value' => '0','sort' => '2','detail' => 'email.email_action.order_success_to_cutomer','store_id' => $storeId],
            ['group' => '','code' => 'email_action','key' => 'order_success_to_customer_pdf','value' => '0','sort' => '3','detail' => 'email.email_action.order_success_to_cutomer_pdf','store_id' => $storeId],
            ['group' => '','code' => 'email_action','key' => 'customer_verify','value' => '0','sort' => '4','detail' => 'email.email_action.customer_verify','store_id' => $storeId],
            ['group' => '','code' => 'email_action','key' => 'welcome_customer','value' => '0','sort' => '4','detail' => 'email.email_action.welcome_customer','store_id' => $storeId],
            ['group' => '','code' => 'email_action','key' => 'contact_to_admin','value' => '1','sort' => '6','detail' => 'email.email_action.contact_to_admin','store_id' => $storeId],
            ['group' => '','code' => 'smtp_config','key' => 'smtp_host','value' => '','sort' => '1','detail' => 'email.config_smtp.smtp_host','store_id' => $storeId],
            ['group' => '','code' => 'smtp_config','key' => 'smtp_user','value' => '','sort' => '2','detail' => 'email.config_smtp.smtp_user','store_id' => $storeId],
            ['group' => '','code' => 'smtp_config','key' => 'smtp_password','value' => '','sort' => '3','detail' => 'email.config_smtp.smtp_password','store_id' => $storeId],
            ['group' => '','code' => 'smtp_config','key' => 'smtp_security','value' => '','sort' => '4','detail' => 'email.config_smtp.smtp_security','store_id' => $storeId],
            ['group' => '','code' => 'smtp_config','key' => 'smtp_port','value' => '','sort' => '5','detail' => 'email.config_smtp.smtp_port','store_id' => $storeId],
            ['group' => '','code' => 'smtp_config','key' => 'smtp_name','value' => '','sort' => '6','detail' => 'email.config_smtp.smtp_name','store_id' => $storeId],
            ['group' => '','code' => 'smtp_config','key' => 'smtp_from','value' => '','sort' => '7','detail' => 'email.config_smtp.smtp_from','store_id' => $storeId],
            ['group' => '','code' => 'url_config','key' => 'SUFFIX_URL','value' => '.html','sort' => '0','detail' => 'admin.env.SUFFIX_URL','store_id' => $storeId],
            ['group' => '','code' => 'url_config','key' => 'PREFIX_SHOP','value' => 'shop','sort' => '0','detail' => 'admin.env.PREFIX_SHOP','store_id' => $storeId],
            ['group' => '','code' => 'url_config','key' => 'PREFIX_BRAND','value' => 'brand','sort' => '0','detail' => 'admin.env.PREFIX_BRAND','store_id' => $storeId],
            ['group' => '','code' => 'url_config','key' => 'PREFIX_CATEGORY','value' => 'category','sort' => '0','detail' => 'admin.env.PREFIX_CATEGORY','store_id' => $storeId],
            ['group' => '','code' => 'url_config','key' => 'PREFIX_SUB_CATEGORY','value' => 'sub-category','sort' => '0','detail' => 'admin.env.PREFIX_SUB_CATEGORY','store_id' => $storeId],
            ['group' => '','code' => 'url_config','key' => 'PREFIX_PRODUCT','value' => 'product','sort' => '0','detail' => 'admin.env.PREFIX_PRODUCT','store_id' => $storeId],
            ['group' => '','code' => 'url_config','key' => 'PREFIX_SEARCH','value' => 'search','sort' => '0','detail' => 'admin.env.PREFIX_SEARCH','store_id' => $storeId],
            ['group' => '','code' => 'url_config','key' => 'PREFIX_CONTACT','value' => 'contact','sort' => '0','detail' => 'admin.env.PREFIX_CONTACT','store_id' => $storeId],
            ['group' => '','code' => 'url_config','key' => 'PREFIX_ABOUT','value' => 'about','sort' => '0','detail' => 'admin.env.PREFIX_ABOUT','store_id' => $storeId],
            ['group' => '','code' => 'url_config','key' => 'PREFIX_NEWS','value' => 'news','sort' => '0','detail' => 'admin.env.PREFIX_NEWS','store_id' => $storeId],
            ['group' => '','code' => 'url_config','key' => 'PREFIX_MEMBER','value' => 'customer','sort' => '0','detail' => 'admin.env.PREFIX_MEMBER','store_id' => $storeId],
            ['group' => '','code' => 'url_config','key' => 'PREFIX_MEMBER_ORDER_LIST','value' => 'order-list','sort' => '0','detail' => 'admin.env.PREFIX_MEMBER_ORDER_LIST','store_id' => $storeId],
            ['group' => '','code' => 'url_config','key' => 'PREFIX_MEMBER_CHANGE_PWD','value' => 'change-password','sort' => '0','detail' => 'admin.env.PREFIX_MEMBER_CHANGE_PWD','store_id' => $storeId],
            ['group' => '','code' => 'url_config','key' => 'PREFIX_MEMBER_CHANGE_INFO','value' => 'change-info','sort' => '0','detail' => 'admin.env.PREFIX_MEMBER_CHANGE_INFO','store_id' => $storeId],
            ['group' => '','code' => 'url_config','key' => 'PREFIX_CMS_CATEGORY','value' => 'cms-category','sort' => '0','detail' => 'admin.env.PREFIX_CMS_CATEGORY','store_id' => $storeId],
            ['group' => '','code' => 'url_config','key' => 'PREFIX_CMS_ENTRY','value' => 'entry','sort' => '0','detail' => 'admin.env.PREFIX_CMS_ENTRY','store_id' => $storeId],
            ['group' => '','code' => 'url_config','key' => 'PREFIX_CART_WISHLIST','value' => 'wishlst','sort' => '0','detail' => 'admin.env.PREFIX_CART_WISHLIST','store_id' => $storeId],
            ['group' => '','code' => 'url_config','key' => 'PREFIX_CART_COMPARE','value' => 'compare','sort' => '0','detail' => 'admin.env.PREFIX_CART_COMPARE','store_id' => $storeId],
            ['group' => '','code' => 'url_config','key' => 'PREFIX_CART_DEFAULT','value' => 'cart','sort' => '0','detail' => 'admin.env.PREFIX_CART_DEFAULT','store_id' => $storeId],
            ['group' => '','code' => 'url_config','key' => 'PREFIX_CART_CHECKOUT','value' => 'checkout','sort' => '0','detail' => 'admin.env.PREFIX_CART_CHECKOUT','store_id' => $storeId],
            ['group' => '','code' => 'url_config','key' => 'PREFIX_CART_CHECKOUT_CONFIRM','value' => 'checkout-confirm','sort' => '0','detail' => 'admin.env.PREFIX_CART_CHECKOUT_CONFIRM','store_id' => $storeId],
            ['group' => '','code' => 'url_config','key' => 'PREFIX_ORDER_SUCCESS','value' => 'order-success','sort' => '0','detail' => 'admin.env.PREFIX_ORDER_SUCCESS','store_id' => $storeId],
            ['group' => '','code' => 'captcha_config','key' => 'captcha_mode','value' => '0','sort' => '20','detail' => 'admin.captcha.captcha_mode','store_id' => $storeId],
            ['group' => '','code' => 'captcha_config','key' => 'captcha_page','value' => '[]','sort' => '10','detail' => 'captcha.captcha_page','store_id' => $storeId],
            ['group' => '','code' => 'captcha_config','key' => 'captcha_method','value' => '','sort' => '0','detail' => 'admin.captcha.captcha_method','store_id' => $storeId],
            ['group' => '','code' => 'admin_custom_config','key' => 'facebook_url','value' => 'https://www.facebook.com/SCart.Ecommerce/','sort' => '0','detail' => 'admin.admin_custom_config.facebook_url','store_id' => $storeId],
            ['group' => '','code' => 'admin_custom_config','key' => 'fanpage_url','value' => 'https://www.facebook.com/groups/scart.opensource','sort' => '0','detail' => 'admin.admin_custom_config.fanpage_url','store_id' => $storeId],
            ['group' => '','code' => 'admin_custom_config','key' => 'twitter_url','value' => 'https://twitter.com/ecommercescart','sort' => '0','detail' => 'admin.admin_custom_config.twitter_url','store_id' => $storeId],
            ['group' => '','code' => 'admin_custom_config','key' => 'instagram_url','value' => '#','sort' => '0','detail' => 'admin.admin_custom_config.instagram_url','store_id' => $storeId],
            ['group' => '','code' => 'admin_custom_config','key' => 'youtube_url','value' => 'https://www.youtube.com/channel/UCR8kitefby3N6KvvawQVqdg/videos','sort' => '0','detail' => 'admin.admin_custom_config.youtube_url','store_id' => $storeId],
            ['group' => '','code' => 'config_layout','key' => 'link_account','value' => '1','sort' => '0','detail' => 'admin.config_layout.link_account','store_id' => $storeId],
            ['group' => '','code' => 'config_layout','key' => 'link_language','value' => '1','sort' => '0','detail' => 'admin.config_layout.link_language','store_id' => $storeId],
            ['group' => '','code' => 'config_layout','key' => 'link_currency','value' => '1','sort' => '0','detail' => 'admin.config_layout.link_currency','store_id' => $storeId],
            ['group' => '','code' => 'config_layout','key' => 'link_cart','value' => '1','sort' => '0','detail' => 'admin.config_layout.link_cart','store_id' => $storeId],
        ];
        return $dataConfig;
    }

    public function dataEmailTemplate($storeId) {
        $dataEmailTemplate = [
            ['id' => (string)Str::orderedUuid(),'name' => 'Reset password','group' => 'forgot_password','text' => '
<h1 style="font-family:Avenir,Helvetica,sans-serif;box-sizing:border-box;color:#2f3133;font-size:19px;font-weight:bold;margin-top:0;text-align:left">{{$title}}</h1>
<p style="font-family:Avenir,Helvetica,sans-serif;box-sizing:border-box;color:#74787e;font-size:16px;line-height:1.5em;margin-top:0;text-align:left">{{$reason_sendmail}}</p>
<table class="action" align="center" width="100%" cellpadding="0" cellspacing="0" style="font-family:Avenir,Helvetica,sans-serif;box-sizing:border-box;margin:30px auto;padding:0;text-align:center;width:100%">
<tbody>
    <tr>
    <td align="center" style="font-family:Avenir,Helvetica,sans-serif;box-sizing:border-box">
        <table width="100%" border="0" cellpadding="0" cellspacing="0" style="font-family:Avenir,Helvetica,sans-serif;box-sizing:border-box">
            <tbody>
                <tr>
                <td align="center" style="font-family:Avenir,Helvetica,sans-serif;box-sizing:border-box">
                    <table border="0" cellpadding="0" cellspacing="0" style="font-family:Avenir,Helvetica,sans-serif;box-sizing:border-box">
                        <tbody>
                            <tr>
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
    <tbody>
    <tr>
        <td style="font-family:Avenir,Helvetica,sans-serif;box-sizing:border-box">
            <p style="font-family:Avenir,Helvetica,sans-serif;box-sizing:border-box;color:#74787e;line-height:1.5em;margin-top:0;text-align:left;font-size:12px">{{$note_access_link}}</p>
        </td>
    </tr>
    </tbody>
</table>','status' => '1','store_id' => $storeId],
            ['id' => (string)Str::orderedUuid(),'name' => 'Customer verification','group' => 'customer_verify','text' => '
<h1 style="font-family:Avenir,Helvetica,sans-serif;box-sizing:border-box;color:#2f3133;font-size:19px;font-weight:bold;margin-top:0;text-align:left">{{$title}}</h1>
<p style="font-family:Avenir,Helvetica,sans-serif;box-sizing:border-box;color:#74787e;font-size:16px;line-height:1.5em;margin-top:0;text-align:left">{{$reason_sendmail}}</p>
<table class="action" align="center" width="100%" cellpadding="0" cellspacing="0" style="font-family:Avenir,Helvetica,sans-serif;box-sizing:border-box;margin:30px auto;padding:0;text-align:center;width:100%">
    <tbody>
    <tr>
        <td align="center" style="font-family:Avenir,Helvetica,sans-serif;box-sizing:border-box">
            <table width="100%" border="0" cellpadding="0" cellspacing="0" style="font-family:Avenir,Helvetica,sans-serif;box-sizing:border-box">
                <tbody>
                <tr>
                    <td align="center" style="font-family:Avenir,Helvetica,sans-serif;box-sizing:border-box">
                        <table border="0" cellpadding="0" cellspacing="0" style="font-family:Avenir,Helvetica,sans-serif;box-sizing:border-box">
                            <tbody>
                            <tr>
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
    <tbody>
    <tr>
        <td style="font-family:Avenir,Helvetica,sans-serif;box-sizing:border-box">
            <p style="font-family:Avenir,Helvetica,sans-serif;box-sizing:border-box;color:#74787e;line-height:1.5em;margin-top:0;text-align:left;font-size:12px">{{$note_access_link}}</p>
        </td>
    </tr>
    </tbody>
</table>','status' => '1','store_id' => $storeId],
            ['id' => (string)Str::orderedUuid(),'name' => 'Welcome new customer','group' => 'welcome_customer','text' => '
<h1 style="font-family:Avenir,Helvetica,sans-serif;box-sizing:border-box;color:#2f3133;font-size:19px;font-weight:bold;margin-top:0;text-align:center">{{$title}}</h1>
<p style="text-align:center;">Welcome to my site!</p>','status' => '1','store_id' => $storeId],
            ['id' => (string)Str::orderedUuid(),'name' => 'Send form contact to admin','group' => 'contact_to_admin','text' => '
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
</table>','status' => '1','store_id' => $storeId],
            
            ['id' => (string)Str::orderedUuid(),'name' => 'New order to admin','group' => 'order_success_to_admin','text' => '
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
   ===================================<br>
</p>
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
   <td colspan="2" style="font-weight: bold;">Other Fee</td>
   <td colspan="2" align="right">{{$otherFee}}</td>
</tr>
<tr>
   <td colspan="2"></td>
   <td colspan="2" style="font-weight: bold;">Total</td>
   <td colspan="2" align="right">{{$total}}</td>
</tr>
</table>','status' => '1','store_id' => $storeId],
            ['id' => (string)Str::orderedUuid(),'name' => 'New order to customr','group' => 'order_success_to_customer','text' => '
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
   ===================================<br>
</p>
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
</table>','status' => '1','store_id' => $storeId],
        ];
        return $dataEmailTemplate;
    }

    public function dataShopLink() {
        $dataShopLink = [
            ['id' => (string)Str::orderedUuid(),'name' => 'front.home','url' => 'route::home','target' => '_self','module' => '','group' => 'menu','status' => '1','sort' => '10'],
            ['id' => (string)Str::orderedUuid(),'name' => 'front.shop','url' => 'route::shop','target' => '_self','module' => '','group' => 'menu','status' => '1','sort' => '20'],
            ['id' => (string)Str::orderedUuid(),'name' => 'front.blog','url' => 'route::news','target' => '_self','module' => '','group' => 'menu','status' => '1','sort' => '30'],
            ['id' => (string)Str::orderedUuid(),'name' => 'front.contact','url' => 'route::contact','target' => '_self','module' => '','group' => 'menu','status' => '1','sort' => '40'],
            ['id' => (string)Str::orderedUuid(),'name' => 'front.my_profile','url' => 'route::login','target' => '_self','module' => '','group' => 'footer','status' => '1','sort' => '60'],
            ['id' => (string)Str::orderedUuid(),'name' => 'front.compare_page','url' => 'route::compare','target' => '_self','module' => '','group' => 'footer','status' => '1','sort' => '70'],
            ['id' => (string)Str::orderedUuid(),'name' => 'front.wishlist_page','url' => 'route::wishlist','target' => '_self','module' => '','group' => 'footer','status' => '1','sort' => '80'],
        ];
        return $dataShopLink;
    }

    public function dataShopLinkStore($dataShopLink, $storeId) {
        foreach ($dataShopLink as $key => $row) {
            $dataShopLinkStore[] = ['link_id' => $row['id'],'store_id' => $storeId];
        }
        return $dataShopLinkStore;
    }
}
