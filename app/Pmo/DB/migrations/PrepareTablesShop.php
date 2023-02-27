<?php
namespace App\Pmo\DB\migrations;

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class PrepareTablesShop extends Migration
{

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //Drop table if exist
        $this->down();

        Schema::create(
            SC_DB_PREFIX.'shop_banner',
            function (Blueprint $table) {
                $table->uuid('id')->primary();
                $table->string('title', 255)->nullable();
                $table->string('image', 255)->nullable();
                $table->string('url', 100)->nullable();
                $table->string('target', 50)->nullable();
                $table->text('html')->nullable();
                $table->tinyInteger('status')->default(0);
                $table->integer('sort')->default(0);
                $table->integer('click')->default(0);
                $table->string('type', 20)->index();
                $table->timestamps();
            }
        );

        Schema::create(
            SC_DB_PREFIX.'shop_banner_type',
            function (Blueprint $table) {
                $table->increments('id');
                $table->string('code', 100)->unique();
                $table->string('name', 255);
                $table->timestamps();
                
            }
        );
        

        Schema::create(
            SC_DB_PREFIX.'shop_email_template',
            function (Blueprint $table) {
                $table->uuid('id')->primary();
                $table->string('name', 255);
                $table->string('group', 50);
                $table->mediumText('text');
                $table->uuid('store_id')->default(1)->index();
                $table->tinyInteger('status')->default(0);
                $table->timestamps();
            }
        );

        Schema::create(
            SC_DB_PREFIX.'shop_language',
            function (Blueprint $table) {
                $table->increments('id');
                $table->string('name', 255);
                $table->string('code', 50)->unique();
                $table->string('icon', 100)->nullable();
                $table->tinyInteger('status')->default(0);
                $table->tinyInteger('rtl')->nullable()->default(0)->comment('Layout RTL');
                $table->integer('sort')->default(0);
                $table->timestamps();
            }
        );

        Schema::create(
            SC_DB_PREFIX.'shop_store_block',
            function (Blueprint $table) {
                $table->uuid('id')->primary();
                $table->string('name', 255);
                $table->string('position', 100);
                $table->string('page', 200)->nullable();
                $table->string('type', 200);
                $table->text('text')->nullable();
                $table->tinyInteger('status')->default(0);
                $table->integer('sort')->default(0);
                $table->uuid('store_id')->default(1)->index();
                $table->string('template', '50')->index();
                $table->timestamps();
            }
        );

        Schema::create(
            SC_DB_PREFIX.'shop_layout_page',
            function (Blueprint $table) {
                $table->increments('id');
                $table->string('key', 100)->unique();
                $table->string('name', 255);
                $table->timestamps();
            }
        );

        Schema::create(
            SC_DB_PREFIX.'shop_layout_position',
            function (Blueprint $table) {
                $table->increments('id');
                $table->string('key', 100)->unique();
                $table->string('name', 255);
                $table->timestamps();
            }
        );

        Schema::create(
            SC_DB_PREFIX.'shop_link',
            function (Blueprint $table) {
                $table->uuid('id')->primary();
                $table->string('name', 255);
                $table->string('url', 100)->nullable();
                $table->string('target', 100);
                $table->string('group', 100)->comment("Location of the link: footer, menu,...");
                $table->string('module', 100)->nullable()->comment("Related components (plugins, templates).\n Used to track, remove when the relevant component is removed.");
                $table->string('type', 100)->nullable()->comment("Distinguish between Link and Collection. \nValue collection|null");
                $table->string('collection_id', 100)->nullable()->comment("Collection\'s ID");
                $table->tinyInteger('status')->default(0);
                $table->integer('sort')->default(0);
                $table->timestamps();
            }
        );

        Schema::create(
            SC_DB_PREFIX.'shop_link_group',
            function (Blueprint $table) {
                $table->increments('id');
                $table->string('code', 100)->unique();
                $table->string('name', 255);
                $table->timestamps();
                
            }
        );

        Schema::create(
            SC_DB_PREFIX.'shop_password_resets',
            function (Blueprint $table) {
                $table->string('email', 150);
                $table->string('token', 255);
                $table->timestamp('created_at', $precision = 0);
                $table->index('email');
            }
        );

        Schema::create(
            SC_DB_PREFIX.'shop_shipping_standard',
            function (Blueprint $table) {
                $table->increments('id');
                $table->decimal('fee',15,2);
                $table->decimal('shipping_free',15,2);
                $table->timestamps();
            }
        );

        Schema::create(
            SC_DB_PREFIX.'shop_brand',
            function (Blueprint $table) {
                $table->uuid('id')->primary();
                $table->string('name', 255);
                $table->string('alias', 120)->index();
                $table->string('image', 255)->nullable();
                $table->string('url', 100)->nullable();
                $table->tinyInteger('status')->default(0);
                $table->integer('sort')->default(0);
                $table->timestamps();
            }
        );

        Schema::create(
            SC_DB_PREFIX.'shop_category',
            function (Blueprint $table) {
                $table->uuid('id')->primary();
                $table->string('image', 255)->nullable();
                $table->string('alias', 120)->index();
                $table->uuid('parent')->default(0);
                $table->integer('top')->nullable()->default(0);
                $table->tinyInteger('status')->default(0);
                $table->integer('sort')->default(0);
                $table->timestamps();
            }
        );

        Schema::create(
            SC_DB_PREFIX.'shop_category_description',
            function (Blueprint $table) {
                $table->uuid('category_id');
                $table->string('lang', 10)->index();
                $table->string('title', 255)->nullable();
                $table->string('keyword', 200)->nullable();
                $table->string('description', 500)->nullable();
                $table->unique(['category_id', 'lang']);
            }
        );

        Schema::create(
            SC_DB_PREFIX.'shop_currency',
            function (Blueprint $table) {
                $table->increments('id');
                $table->string('name', 255);
                $table->string('code', 10)->unique();
                $table->string('symbol', 10);
                $table->float('exchange_rate');
                $table->tinyInteger('precision')->default(2);
                $table->tinyInteger('symbol_first')->default(0);
                $table->string('thousands')->default(',');
                $table->tinyInteger('status')->default(0);
                $table->integer('sort')->default(0);
                $table->timestamps();
            }
        );

        Schema::create(
            SC_DB_PREFIX.'shop_order',
            function (Blueprint $table) {
                $table->uuid('id')->primary();
                $table->uuid('customer_id')->index();
                $table->string('domain')->nullable();
                $table->decimal('subtotal',15,2)->nullable()->default(0);
                $table->decimal('shipping',15,2)->nullable()->default(0);
                $table->decimal('discount',15,2)->nullable()->default(0);
                $table->integer('payment_status')->default(1);
                $table->integer('shipping_status')->default(1);
                $table->integer('status')->default(0);
                $table->decimal('tax',15,2)->nullable()->default(0);
                $table->decimal('other_fee',15,2)->nullable()->default(0);
                $table->decimal('total',15,2)->nullable()->default(0);
                $table->string('currency', 10);
                $table->decimal('exchange_rate',15,2)->nullable();
                $table->decimal('received',15,2)->nullable()->default(0);
                $table->decimal('balance',15,2)->nullable()->default(0);
                $table->string('first_name', 100);
                $table->string('last_name', 100)->nullable();
                $table->string('first_name_kana', 100)->nullable();
                $table->string('last_name_kana', 100)->nullable();
                $table->string('address1', 100)->nullable();
                $table->string('address2', 100)->nullable();
                $table->string('address3', 100)->nullable();
                $table->string('country', 10)->nullable()->default('VN');
                $table->string('company', 100)->nullable();
                $table->string('postcode', 10)->nullable();
                $table->string('phone', 20)->nullable();
                $table->string('email', 150);
                $table->string('comment', 300)->nullable();
                $table->string('payment_method', 100)->nullable();
                $table->string('shipping_method', 100)->nullable();
                $table->string('user_agent', 255)->nullable();
                $table->string('device_type', 20)->nullable()->default('other')->index();
                $table->string('ip', 100)->nullable();
                $table->string('transaction', 100)->nullable();
                $table->uuid('store_id')->nullable()->default(1)->index();
                $table->timestamps();
            }
        );

        Schema::create(
            SC_DB_PREFIX.'shop_order_detail',
            function (Blueprint $table) {
                $table->uuid('id')->primary();
                $table->uuid('order_id');
                $table->uuid('product_id');
                $table->string('name', 255);
                $table->decimal('price',15,2)->default(0);
                $table->integer('qty')->default(0);
                $table->uuid('store_id')->default(1);
                $table->decimal('total_price',15,2)->default(0);
                $table->decimal('tax',15,2)->default(0);
                $table->string('sku', 50);
                $table->string('currency', 10);
                $table->float('exchange_rate')->nullable();
                $table->string('attribute', 100)->nullable();
                $table->timestamps();
            }
        );

        Schema::create(
            SC_DB_PREFIX.'shop_order_history',
            function (Blueprint $table) {
                $table->uuid('id')->primary();
                $table->uuid('order_id');
                $table->string('content', 300);
                $table->uuid('admin_id')->default(0);
                $table->uuid('customer_id')->default(0);
                $table->integer('order_status_id')->default(0);
                $table->timestamp('add_date', $precision = 0);
            }
        );

        Schema::create(
            SC_DB_PREFIX.'shop_order_status',
            function (Blueprint $table) {
                $table->increments('id');
                $table->string('name', 255);
                $table->timestamps();
            }
        );

        Schema::create(
            SC_DB_PREFIX.'shop_order_total',
            function (Blueprint $table) {
                $table->uuid('id')->primary();
                $table->uuid('order_id')->index();
                $table->string('title', 255);
                $table->string('code', 100);
                $table->decimal('value',15,2)->default(0);
                $table->string('text', 200)->nullable();
                $table->integer('sort')->default(1);
                $table->timestamps();
            }
        );

        Schema::create(
            SC_DB_PREFIX.'shop_page',
            function (Blueprint $table) {
                $table->uuid('id')->primary();
                $table->string('image', 255)->nullable();
                $table->string('alias', 120)->index();
                $table->integer('status')->default(0);
                $table->timestamps();
            }
        );

        Schema::create(
            SC_DB_PREFIX.'shop_page_description',
            function (Blueprint $table) {
                $table->uuid('page_id');
                $table->string('lang', 10)->index();
                $table->string('title', 255)->nullable();
                $table->string('keyword', 200)->nullable();
                $table->string('description', 500)->nullable();
                $table->mediumText('content')->nullable();
                $table->unique(['page_id', 'lang']);
            }
        );

        Schema::create(
            SC_DB_PREFIX.'shop_payment_status',
            function (Blueprint $table) {
                $table->increments('id');
                $table->string('name', 255);
                $table->timestamps();
            }
        );

        Schema::create(
            SC_DB_PREFIX.'shop_product',
            function (Blueprint $table) {
                $table->uuid('id')->primary();
                $table->string('sku', 50)->index();
                $table->string('upc', 20)->nullable()->comment('upc code');
                $table->string('ean', 20)->nullable()->comment('ean code');
                $table->string('jan', 20)->nullable()->comment('jan code');
                $table->string('isbn', 20)->nullable()->comment('isbn code');
                $table->string('mpn', 64)->nullable()->comment('mpn code');
                $table->string('image', 255)->nullable();
                $table->uuid('brand_id')->nullable()->default(0)->index();
                $table->uuid('supplier_id')->nullable()->default(0)->index();
                $table->decimal('price',15,2)->nullable()->default(0);
                $table->decimal('cost',15,2)->nullable()->nullable()->default(0);
                $table->integer('stock')->nullable()->default(0);
                $table->integer('sold')->nullable()->default(0);
                $table->integer('minimum')->nullable()->default(0);
                $table->string('weight_class')->nullable();
                $table->decimal('weight',15,2)->nullable()->default(0);
                $table->string('length_class')->nullable();
                $table->decimal('length',15,2)->nullable()->default(0);
                $table->decimal('width',15,2)->nullable()->default(0);
                $table->decimal('height',15,2)->nullable()->default(0);
                $table->tinyInteger('kind')->nullable()->default(0)->comment('0:single, 1:bundle, 2:group')->index();
                $table->string('property', 50)->nullable()->default('physical')->index();
                $table->string('tax_id', 50)->nullable()->default(0)->comment('0:No-tax, auto: Use tax default')->index();
                $table->tinyInteger('status')->default(0)->index();
                $table->tinyInteger('approve')->default(1)->index();
                $table->integer('sort')->default(0);
                $table->integer('view')->default(0);
                $table->string('alias', 120)->index();
                $table->timestamp('date_lastview', $precision = 0)->nullable();
                $table->date('date_available')->nullable();
                $table->timestamps();
            }
        );

        Schema::create(
            SC_DB_PREFIX.'shop_product_description',
            function (Blueprint $table) {
                $table->uuid('product_id');
                $table->string('lang', 10)->index();
                $table->string('name', 255)->nullable();
                $table->string('keyword', 200)->nullable();
                $table->string('description', 500)->nullable();
                $table->mediumText('content')->nullable();
                $table->unique(['product_id', 'lang']);
            }
        );

        Schema::create(
            SC_DB_PREFIX.'shop_product_image',
            function (Blueprint $table) {
                $table->uuid('id')->primary();
                $table->string('image', 255);
                $table->uuid('product_id')->default(0)->index();
            }
        );

        Schema::create(
            SC_DB_PREFIX.'shop_product_build',
            function (Blueprint $table) {
                $table->uuid('build_id');
                $table->uuid('product_id');
                $table->integer('quantity');
                $table->primary(['build_id', 'product_id']);
            }
        );

        Schema::create(
            SC_DB_PREFIX.'shop_product_group',
            function (Blueprint $table) {
                $table->uuid('group_id');
                $table->uuid('product_id');
                $table->primary(['group_id', 'product_id']);
            }
        );

        Schema::create(
            SC_DB_PREFIX.'shop_product_category',
            function (Blueprint $table) {
                $table->uuid('product_id');
                $table->uuid('category_id');
                $table->primary(['product_id', 'category_id']);
            }
        );

        Schema::create(
            SC_DB_PREFIX.'shop_attribute_group',
            function (Blueprint $table) {
                $table->increments('id');
                $table->string('name', 255);
                $table->tinyInteger('status')->default(0);
                $table->integer('sort')->default(0);
                $table->string('type', 50)->comment('radio,select,checkbox');
                $table->timestamps();
            }
        );

        Schema::create(
            SC_DB_PREFIX.'shop_product_attribute',
            function (Blueprint $table) {
                $table->bigIncrements('id');
                $table->string('name', 255);
                $table->integer('attribute_group_id');
                $table->uuid('product_id');
                $table->decimal('add_price',15,2)->default(0);
                $table->integer('sort')->default(0);
                $table->tinyInteger('status')->default(1);
                $table->index(['product_id', 'attribute_group_id']);
            }
        );

        Schema::create(
            SC_DB_PREFIX.'shop_product_property',
            function (Blueprint $table) {
                $table->increments('id');
                $table->string('code', 100)->unique();
                $table->string('name', 255);
                $table->timestamps();
            }
        );

        Schema::create(
            SC_DB_PREFIX.'shop_shipping_status',
            function (Blueprint $table) {
                $table->increments('id');
                $table->string('name', 255);
                $table->timestamps();
            }
        );

        Schema::create(
            SC_DB_PREFIX.'shop_shoppingcart',
            function (Blueprint $table) {
                $table->string('identifier', 100);
                $table->string('instance', 100);
                $table->text('content');
                $table->timestamps();
                $table->index(['identifier', 'instance']);
                $table->uuid('store_id')->default(1)->index();
            }
        );

        Schema::create(
            SC_DB_PREFIX.'shop_customer',
            function (Blueprint $table) {
                $table->uuid('id')->primary();
                $table->string('first_name', 100);
                $table->string('last_name', 100)->nullable();
                $table->string('first_name_kana', 100)->nullable();
                $table->string('last_name_kana', 100)->nullable();
                $table->string('email', 150)->nullable();
                $table->tinyInteger('sex')->nullable()->comment('0:women, 1:men');
                $table->date('birthday')->nullable();
                $table->string('password', 100)->nullable();
                $table->uuid('address_id')->default(0)->index();
                $table->string('postcode', 10)->nullable();
                $table->string('address1', 100)->nullable();
                $table->string('address2', 100)->nullable();
                $table->string('address3', 100)->nullable();
                $table->string('company', 100)->nullable();
                $table->string('country', 10)->nullable()->default('VN');
                $table->string('phone', 20)->nullable();
                $table->uuid('store_id')->default(1)->index();
                $table->string('remember_token', 100)->nullable();
                $table->tinyInteger('status')->default(1);
                $table->tinyInteger('group')->default(1);
                $table->timestamp('email_verified_at', $precision = 0)->nullable();
                $table->timestamps();
                //Login social
                $table->string('provider', 50)->nullable();
                $table->string('provider_id', 50)->nullable();
                $table->unique(['email', 'provider', 'provider_id']);
            }
        );

        Schema::create(
            SC_DB_PREFIX.'shop_customer_address',
            function (Blueprint $table) {
                $table->uuid('id')->primary();
                $table->uuid('customer_id')->index();
                $table->string('first_name', 100);
                $table->string('last_name', 100)->nullable();
                $table->string('first_name_kana', 100)->nullable();
                $table->string('last_name_kana', 100)->nullable();
                $table->string('postcode', 10)->nullable();
                $table->string('address1', 100)->nullable();
                $table->string('address2', 100)->nullable();
                $table->string('address3', 100)->nullable();
                $table->string('country', 10)->nullable()->default('VN');
                $table->string('phone', 20)->nullable();
                $table->timestamps();
            }
        );


        Schema::create(
            SC_DB_PREFIX.'shop_supplier',
            function (Blueprint $table) {
                $table->uuid('id')->primary();
                $table->string('name', 255);
                $table->string('alias', 120)->index();
                $table->string('email', 150)->nullable();
                $table->string('phone', 20)->nullable();
                $table->string('image', 255)->nullable();
                $table->string('address', 100)->nullable();
                $table->string('url', 100)->nullable();
                $table->tinyInteger('status')->default(1);
                $table->uuid('store_id')->default(1)->index();
                $table->integer('sort')->default(0);
                $table->timestamps();
            }
        );

        Schema::create(
            SC_DB_PREFIX.'shop_subscribe',
            function (Blueprint $table) {
                $table->uuid('id')->primary();
                $table->string('email', 150)->index();
                $table->string('phone', 20)->nullable();
                $table->string('content', 300)->nullable();
                $table->tinyInteger('status')->default(1);
                $table->uuid('store_id')->default(1)->index();
                $table->timestamps();
            }
        );

        Schema::create(
            SC_DB_PREFIX.'shop_country',
            function (Blueprint $table) {
                $table->increments('id');
                $table->string('code', 10)->unique();
                $table->string('name', 255);
            }
        );
        
        Schema::create(
            SC_DB_PREFIX.'shop_news',
            function (Blueprint $table) {
                $table->uuid('id')->primary();
                $table->string('image', 200)->nullable();
                $table->string('alias', 120)->index();
                $table->integer('sort')->default(0);
                $table->tinyInteger('status')->default(0);
                $table->timestamps();
            }
        );

        Schema::create(
            SC_DB_PREFIX.'shop_news_description',
            function (Blueprint $table) {
                $table->uuid('news_id');
                $table->string('lang', 10);
                $table->string('title', 255)->nullable();
                $table->string('keyword', 200)->nullable();
                $table->string('description', 500)->nullable();
                $table->mediumText('content')->nullable();
                $table->unique(['news_id', 'lang']);
            }
        );

        Schema::create(
            SC_DB_PREFIX.'shop_sessions',
            function ($table) {
                $table->string('id', 100)->unique();
                $table->uuid('customer_id')->nullable();
                $table->string('ip_address', 45)->nullable();
                $table->text('user_agent')->nullable();
                $table->text('payload');
                $table->integer('last_activity');
                $table->timestamps();
            }
        );

        Schema::create(
            SC_DB_PREFIX.'api_connection',
            function (Blueprint $table) {
                $table->increments('id');
                $table->string('description', 500);
                $table->string('apiconnection', 50)->unique();
                $table->string('apikey', 128);
                $table->date('expire')->nullable();
                $table->timestamp('last_active', $precision = 0)->nullable();
                $table->timestamps();
                $table->tinyInteger('status')->default(0);
            }
        );

        Schema::create(
            SC_DB_PREFIX.'shop_tax',
            function (Blueprint $table) {
                $table->increments('id');
                $table->string('name', 255);
                $table->integer('value')->default(0);
                $table->timestamps();
            }
        );

        Schema::create(
            SC_DB_PREFIX.'shop_weight',
            function (Blueprint $table) {
                $table->increments('id');
                $table->string('name', 150)->unique();
                $table->string('description', 500);
                $table->timestamps();
            }
        );

        Schema::create(
            SC_DB_PREFIX.'shop_length',
            function (Blueprint $table) {
                $table->increments('id');
                $table->string('name', 150)->unique();
                $table->string('description', 500);
                $table->timestamps();
            }
        );

        Schema::create(
            'jobs',
            function (Blueprint $table) {
                $table->bigIncrements('id');
                $table->string('queue', 150)->index();
                $table->longText('payload');
                $table->unsignedTinyInteger('attempts');
                $table->unsignedInteger('reserved_at')->nullable();
                $table->unsignedInteger('available_at');
                $table->unsignedInteger('created_at');
            }
        );

        Schema::create(
            'failed_jobs',
            function (Blueprint $table) {
                $table->bigIncrements('id');
                $table->string('uuid', 150)->nullable()->unique();
                $table->text('connection');
                $table->text('queue');
                $table->longText('payload');
                $table->longText('exception');
                $table->timestamp('failed_at')->useCurrent();
            }
        );

        Schema::create(
            SC_DB_PREFIX.'shop_store_css',
            function (Blueprint $table) {
                $table->mediumText('css');
                $table->uuid('store_id');
                $table->string('template', 50);
                $table->unique(['store_id', 'template']);
                $table->timestamps();
            }
        );

        Schema::create(
            SC_DB_PREFIX.'shop_product_promotion',
            function (Blueprint $table) {
                $table->uuid('product_id')->primary();
                $table->decimal('price_promotion',15,2);
                $table->timestamp('date_start', $precision = 0)->nullable();
                $table->timestamp('date_end', $precision = 0)->nullable();
                $table->integer('status_promotion')->default(1);
                $table->timestamps();
            }
        );

        Schema::create(
            SC_DB_PREFIX.'shop_product_download',
            function (Blueprint $table) {
                $table->uuid('id')->primary();
                $table->uuid('product_id');
                $table->string('path', 255);
            }
        );

        Schema::create(
            SC_DB_PREFIX.'shop_custom_field',
            function (Blueprint $table) {
                $table->uuid('id')->primary();
                $table->string('type', 50)->index()->comment('shop_product, shop_customer,...');
                $table->string('code', 100)->index();
                $table->string('name', 255);
                $table->integer('required')->default(0);
                $table->integer('status')->default(1);
                $table->string('option', 50)->nullable()->comment('radio, select, input');
                $table->string('default', 250)->nullable()->comment('{"value1":"name1", "value2":"name2"}');
                $table->timestamps();
            }
        );

        Schema::create(
            SC_DB_PREFIX.'shop_custom_field_detail',
            function (Blueprint $table) {
                $table->uuid('id')->primary();
                $table->uuid('custom_field_id')->index();
                $table->uuid('rel_id')->index()->comment('ID of product, customer,...');
                $table->text('text')->nullable();
                $table->timestamps();
            }
        );

        Schema::create(
            SC_DB_PREFIX.'languages',
            function (Blueprint $table) {
                $table->increments('id');
                $table->string('code', 100)->index();
                $table->text('text')->nullable();
                $table->string('position', 100)->index();
                $table->string('location', 10)->index();
                $table->unique(['code', 'location']);
                $table->timestamps();
            }
        );

        //Multi store
        Schema::create(
            SC_DB_PREFIX.'shop_product_store',
            function (Blueprint $table) {
                $table->uuid('product_id');
                $table->uuid('store_id');
                $table->primary(['product_id', 'store_id']);
            }
        );

        Schema::create(
            SC_DB_PREFIX.'shop_category_store',
            function (Blueprint $table) {
                $table->uuid('category_id');
                $table->uuid('store_id');
                $table->primary(['category_id', 'store_id']);
            }
        );

        Schema::create(
            SC_DB_PREFIX.'shop_brand_store',
            function (Blueprint $table) {
                $table->uuid('brand_id');
                $table->uuid('store_id');
                $table->primary(['brand_id', 'store_id']);
            }
        );

        Schema::create(
            SC_DB_PREFIX.'shop_banner_store',
            function (Blueprint $table) {
                $table->uuid('banner_id');
                $table->uuid('store_id');
                $table->primary(['banner_id', 'store_id']);
            }
        );

        Schema::create(
            SC_DB_PREFIX.'shop_news_store',
            function (Blueprint $table) {
                $table->uuid('news_id');
                $table->uuid('store_id');
                $table->primary(['news_id', 'store_id']);
            }
        );

        Schema::create(
            SC_DB_PREFIX.'shop_page_store',
            function (Blueprint $table) {
                $table->uuid('page_id');
                $table->uuid('store_id');
                $table->primary(['page_id', 'store_id']);
            }
        );

        Schema::create(
            SC_DB_PREFIX.'shop_link_store',
            function (Blueprint $table) {
                $table->uuid('link_id');
                $table->uuid('store_id');
                $table->primary(['link_id', 'store_id']);
            }
        );
        
        //Sanctum
        Schema::create('personal_access_tokens', function (Blueprint $table) {
            $table->id();
            $table->uuidMorphs('tokenable');
            $table->string('name');
            $table->string('token', 64)->unique();
            $table->text('abilities')->nullable();
            $table->timestamp('last_used_at')->nullable();
            $table->timestamp('expires_at')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists(SC_DB_PREFIX.'shop_banner');
        Schema::dropIfExists(SC_DB_PREFIX.'shop_banner_type');
        Schema::dropIfExists(SC_DB_PREFIX.'shop_email_template');
        Schema::dropIfExists(SC_DB_PREFIX.'shop_language');
        Schema::dropIfExists(SC_DB_PREFIX.'shop_store_block');
        Schema::dropIfExists(SC_DB_PREFIX.'shop_layout_page');
        Schema::dropIfExists(SC_DB_PREFIX.'shop_layout_position');
        Schema::dropIfExists(SC_DB_PREFIX.'shop_link');
        Schema::dropIfExists(SC_DB_PREFIX.'shop_link_group');
        Schema::dropIfExists(SC_DB_PREFIX.'shop_password_resets');
        Schema::dropIfExists(SC_DB_PREFIX.'shop_shipping_standard');
        Schema::dropIfExists(SC_DB_PREFIX.'shop_api');
        Schema::dropIfExists(SC_DB_PREFIX.'shop_api_process');
        Schema::dropIfExists(SC_DB_PREFIX.'shop_brand');
        Schema::dropIfExists(SC_DB_PREFIX.'shop_category');
        Schema::dropIfExists(SC_DB_PREFIX.'shop_category_description');
        Schema::dropIfExists(SC_DB_PREFIX.'shop_currency');
        Schema::dropIfExists(SC_DB_PREFIX.'shop_order');
        Schema::dropIfExists(SC_DB_PREFIX.'shop_order_detail');
        Schema::dropIfExists(SC_DB_PREFIX.'shop_order_history');
        Schema::dropIfExists(SC_DB_PREFIX.'shop_order_status');
        Schema::dropIfExists(SC_DB_PREFIX.'shop_order_total');
        Schema::dropIfExists(SC_DB_PREFIX.'shop_page');
        Schema::dropIfExists(SC_DB_PREFIX.'shop_page_description');
        Schema::dropIfExists(SC_DB_PREFIX.'shop_payment_status');
        Schema::dropIfExists(SC_DB_PREFIX.'shop_product');
        Schema::dropIfExists(SC_DB_PREFIX.'shop_product_description');
        Schema::dropIfExists(SC_DB_PREFIX.'shop_product_image');
        Schema::dropIfExists(SC_DB_PREFIX.'shop_product_build');
        Schema::dropIfExists(SC_DB_PREFIX.'shop_product_attribute');
        Schema::dropIfExists(SC_DB_PREFIX.'shop_product_property');
        Schema::dropIfExists(SC_DB_PREFIX.'shop_attribute_group');
        Schema::dropIfExists(SC_DB_PREFIX.'shop_product_group');
        Schema::dropIfExists(SC_DB_PREFIX.'shop_product_category');
        Schema::dropIfExists(SC_DB_PREFIX.'shop_shipping_status');
        Schema::dropIfExists(SC_DB_PREFIX.'shop_shoppingcart');
        Schema::dropIfExists(SC_DB_PREFIX.'shop_product_promotion');
        Schema::dropIfExists(SC_DB_PREFIX.'shop_customer');
        Schema::dropIfExists(SC_DB_PREFIX.'shop_supplier');
        Schema::dropIfExists(SC_DB_PREFIX.'shop_customer_address');
        Schema::dropIfExists(SC_DB_PREFIX.'shop_subscribe');
        Schema::dropIfExists(SC_DB_PREFIX.'shop_country');
        Schema::dropIfExists(SC_DB_PREFIX.'shop_news');
        Schema::dropIfExists(SC_DB_PREFIX.'shop_news_description');
        Schema::dropIfExists(SC_DB_PREFIX.'shop_sessions');
        Schema::dropIfExists(SC_DB_PREFIX.'shop_tax');
        Schema::dropIfExists(SC_DB_PREFIX.'shop_weight');
        Schema::dropIfExists(SC_DB_PREFIX.'shop_length');
        Schema::dropIfExists(SC_DB_PREFIX.'shop_product_download');
        //Api connection
        Schema::dropIfExists(SC_DB_PREFIX.'api_connection');
        //Job
        Schema::dropIfExists('jobs');
        Schema::dropIfExists('failed_jobs');
        Schema::dropIfExists(SC_DB_PREFIX.'shop_store_css');
        //Custom field
        Schema::dropIfExists(SC_DB_PREFIX.'shop_custom_field');
        Schema::dropIfExists(SC_DB_PREFIX.'shop_custom_field_detail');
        //Languages
        Schema::dropIfExists(SC_DB_PREFIX.'languages');
        //Multi store
        Schema::dropIfExists(SC_DB_PREFIX.'shop_product_store');
        Schema::dropIfExists(SC_DB_PREFIX.'shop_category_store');
        Schema::dropIfExists(SC_DB_PREFIX.'shop_brand_store');
        Schema::dropIfExists(SC_DB_PREFIX.'shop_banner_store');
        Schema::dropIfExists(SC_DB_PREFIX.'shop_news_store');
        Schema::dropIfExists(SC_DB_PREFIX.'shop_page_store');
        Schema::dropIfExists(SC_DB_PREFIX.'shop_link_store');

        //Sanctum
        Schema::dropIfExists('personal_access_tokens');
    }
}
