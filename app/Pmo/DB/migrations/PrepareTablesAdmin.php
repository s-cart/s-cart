<?php
namespace App\Pmo\DB\migrations;

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class PrepareTablesAdmin extends Migration
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
        
        Schema::create(SC_DB_PREFIX . 'admin_user', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('username', 100)->unique();
            $table->string('password', 60);
            $table->string('name', 100);
            $table->string('email', 150)->unique();
            $table->string('avatar', 255)->nullable();
            $table->string('remember_token', 100)->nullable();
            $table->string('theme', 100)->nullable();
            $table->timestamps();
        });

        Schema::create(SC_DB_PREFIX . 'admin_role', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name', 100);
            $table->string('slug', 50)->unique();
            $table->timestamps();
        });

        Schema::create(SC_DB_PREFIX . 'admin_permission', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name', 100)->unique();
            $table->string('slug', 50)->unique();
            $table->text('http_uri')->nullable();
            $table->timestamps();
        });

        Schema::create(SC_DB_PREFIX . 'admin_menu', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('parent_id')->default(0);
            $table->integer('sort')->default(0);
            $table->string('title', 255);
            $table->string('icon', 50);
            $table->string('uri', 255)->nullable();
            $table->integer('type')->default(0);
            $table->integer('hidden')->default(0);
            $table->string('key', 50)->unique()->nullable();
            $table->timestamps();
        });

        Schema::create(SC_DB_PREFIX . 'admin_role_user', function (Blueprint $table) {
            $table->integer('role_id');
            $table->uuid('user_id');
            $table->index(['role_id', 'user_id']);
            $table->timestamps();
        });

        Schema::create(SC_DB_PREFIX . 'admin_role_permission', function (Blueprint $table) {
            $table->integer('role_id');
            $table->integer('permission_id');
            $table->index(['role_id', 'permission_id']);
            $table->timestamps();
            $table->primary(['role_id', 'permission_id']);
        });

        Schema::create(SC_DB_PREFIX . 'admin_user_permission', function (Blueprint $table) {
            $table->uuid('user_id');
            $table->integer('permission_id');
            $table->timestamps();
            $table->index(['user_id', 'permission_id']);
            $table->primary(['user_id', 'permission_id']);
        });

        Schema::create(SC_DB_PREFIX . 'admin_template', function (Blueprint $table) {
            $table->increments('id');
            $table->string('key', 100)->unique();
            $table->string('name', 255);
            $table->integer('status', 0)->default(0);
            $table->timestamps();
        });

        Schema::create(SC_DB_PREFIX . 'admin_log', function (Blueprint $table) {
            $table->increments('id');
            $table->uuid('user_id');
            $table->string('path');
            $table->string('method', 10);
            $table->string('ip');
            $table->string('user_agent')->nullable();
            $table->text('input');
            $table->index('user_id');
            $table->timestamps();
        });

        Schema::create(SC_DB_PREFIX . 'admin_config', function (Blueprint $table) {
            $table->increments('id');
            $table->string('group', 50)->nullable();
            $table->string('code', 50)->index();
            $table->string('key', 50);
            $table->string('value', 500)->nullable();
            $table->integer('security')->default(0)->nullable();
            $table->uuid('store_id')->default(0);
            $table->integer('sort')->default(0);
            $table->string('detail', 200)->nullable();
            $table->unique(['key', 'store_id']);
            $table->timestamps();
        });

        Schema::create(SC_DB_PREFIX . 'admin_store', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('logo', 255)->nullable();
            $table->string('icon', 255)->nullable();
            $table->string('phone', 20)->nullable();
            $table->string('long_phone', 100)->nullable();
            $table->string('email', 150)->nullable();
            $table->string('time_active', 200)->nullable();
            $table->string('address', 300)->nullable();
            $table->string('office', 300)->nullable();
            $table->string('warehouse', 300)->nullable();
            $table->string('template', 100)->nullable();
            $table->string('domain', 100)->nullable()->index()->comment('Use for multi-store, multi-vendor');
            $table->string('partner', 10)->default(0)->index()->comment('Use for multi-vendor');
            $table->string('code', 20)->nullable()->unique();
            $table->string('language', 10);
            $table->string('timezone', 50); // will remove in v7
            $table->string('currency', 10);
            $table->integer('status')->default(1)->comment('0:Lock, 1: unlock')->comment('Use for multi-store, multi-vendor');
            $table->integer('active')->default(1)->comment('0:Maintain, 1: Active');
            $table->timestamps();
        });

        Schema::create(SC_DB_PREFIX . 'admin_store_description', function (Blueprint $table) {
            $table->uuid('store_id');
            $table->string('lang', 10)->index();
            $table->string('title', 255)->nullable();
            $table->string('description', 500)->nullable();
            $table->string('keyword', 200)->nullable();
            $table->mediumText('maintain_content')->nullable();
            $table->string('maintain_note', 300)->nullable();
            $table->primary(['store_id', 'lang']);
        });

        Schema::create(
            SC_DB_PREFIX.'admin_password_resets',
            function (Blueprint $table) {
                $table->string('email', 150);
                $table->string('token', 255);
                $table->timestamp('created_at', $precision = 0);
                $table->index('email');
            }
        );
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists(SC_DB_PREFIX . 'admin_user');
        Schema::dropIfExists(SC_DB_PREFIX . 'admin_role');
        Schema::dropIfExists(SC_DB_PREFIX . 'admin_permission');
        Schema::dropIfExists(SC_DB_PREFIX . 'admin_menu');
        Schema::dropIfExists(SC_DB_PREFIX . 'admin_user_permission');
        Schema::dropIfExists(SC_DB_PREFIX . 'admin_template');
        Schema::dropIfExists(SC_DB_PREFIX . 'admin_role_user');
        Schema::dropIfExists(SC_DB_PREFIX . 'admin_role_permission');
        Schema::dropIfExists(SC_DB_PREFIX . 'admin_log');
        Schema::dropIfExists(SC_DB_PREFIX . 'admin_config');
        Schema::dropIfExists(SC_DB_PREFIX . 'admin_store');
        Schema::dropIfExists(SC_DB_PREFIX . 'admin_store_description');
        Schema::dropIfExists(SC_DB_PREFIX . 'admin_password_resets');
    }
}
