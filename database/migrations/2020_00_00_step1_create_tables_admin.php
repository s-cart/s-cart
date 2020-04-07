<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Http\Request;
class CreateTablesAdmin extends Migration
{

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //Drop table if exist
        if(!empty(session('infoInstall')['dropdb'])) {
            $this->down();
        }
        Schema::create(SC_DB_PREFIX.'admin_user', function (Blueprint $table) {
            $table->increments('id');
            $table->string('username', 100)->unique();
            $table->string('password', 60);
            $table->string('name', 100);
            $table->string('email', 150)->unique();
            $table->string('avatar', 255)->nullable();
            $table->string('remember_token', 100)->nullable();
            $table->timestamps();
        });

        Schema::create(SC_DB_PREFIX.'admin_role', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name', 50)->unique();
            $table->string('slug', 50)->unique();
            $table->timestamps();
        });

        Schema::create(SC_DB_PREFIX.'admin_permission', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name', 50)->unique();
            $table->string('slug', 50)->unique();
            $table->text('http_uri')->nullable();
            $table->timestamps();

        });

        Schema::create(SC_DB_PREFIX.'admin_menu', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('parent_id')->default(0);
            $table->integer('sort')->default(0);
            $table->string('title', 50);
            $table->string('icon', 50);
            $table->string('uri', 255)->nullable();
            $table->integer('type')->default(0);
            $table->string('key',50)->unique()->nullable();
            $table->string('permission')->nullable();

            $table->timestamps();
        });

        Schema::create(SC_DB_PREFIX.'admin_role_user', function (Blueprint $table) {
            $table->integer('role_id');
            $table->integer('user_id');
            $table->index(['role_id', 'user_id']);
            $table->timestamps();
        });

        Schema::create(SC_DB_PREFIX.'admin_role_permission', function (Blueprint $table) {
            $table->integer('role_id');
            $table->integer('permission_id');
            $table->index(['role_id', 'permission_id']);
            $table->timestamps();
            $table->primary(['role_id', 'permission_id']);
        });

        Schema::create(SC_DB_PREFIX.'admin_role_menu', function (Blueprint $table) {
            $table->integer('role_id');
            $table->integer('menu_id');
            $table->index(['role_id', 'menu_id']);
            $table->timestamps();
            $table->primary(['role_id', 'menu_id']);
        });

        Schema::create(SC_DB_PREFIX.'admin_menu_permission', function (Blueprint $table) {
            $table->integer('menu_id');
            $table->integer('permission_id');
            $table->index(['menu_id', 'permission_id']);
            $table->timestamps();
            $table->primary(['menu_id', 'permission_id']);
        });

        Schema::create(SC_DB_PREFIX.'admin_user_permission', function (Blueprint $table) {
            $table->integer('user_id');
            $table->integer('permission_id');
            $table->index(['user_id', 'permission_id']);
            $table->timestamps();
            $table->primary(['user_id', 'permission_id']);
        });

        Schema::create(SC_DB_PREFIX.'admin_log', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('user_id');
            $table->string('path');
            $table->string('method', 10);
            $table->string('ip');
            $table->string('user_agent')->nullable();
            $table->text('input');
            $table->index('user_id');
            $table->timestamps();
        });

        Schema::create(SC_DB_PREFIX.'admin_config', function (Blueprint $table) {
            $table->increments('id');
            $table->string('group', 50)->nullable();
            $table->string('code', 50)->index();
            $table->string('key', 50)->unique();
            $table->string('value', 200)->nullable();
            $table->string('store_id', 200)->default(1);
            $table->tinyInteger('sort')->default(0);
            $table->string('detail', 300)->nullable();

        });

        Schema::create(SC_DB_PREFIX.'admin_store', function (Blueprint $table) {
            $table->increments('id');
            $table->string('logo', 255)->nullable();
            $table->string('phone', 20)->nullable();
            $table->string('long_phone', 100)->nullable();
            $table->string('email', 150)->nullable();
            $table->string('time_active', 200);
            $table->string('address', 300);
            $table->string('office', 300)->nullable();
            $table->string('warehouse', 300)->nullable();
            $table->string('template', 100)->nullable();
        });

        Schema::create(SC_DB_PREFIX.'admin_store_description', function (Blueprint $table) {
            $table->integer('config_id');
            $table->string('lang', 10)->index();
            $table->string('title', 200)->nullable();
            $table->string('description', 300)->nullable();
            $table->string('keyword', 200)->nullable();
            $table->text('maintain_content')->nullable();
            $table->primary(['config_id', 'lang']);
        });

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists(SC_DB_PREFIX.'admin_user');
        Schema::dropIfExists(SC_DB_PREFIX.'admin_role');
        Schema::dropIfExists(SC_DB_PREFIX.'admin_permission');
        Schema::dropIfExists(SC_DB_PREFIX.'admin_menu');
        Schema::dropIfExists(SC_DB_PREFIX.'admin_user_permission');
        Schema::dropIfExists(SC_DB_PREFIX.'admin_role_user');
        Schema::dropIfExists(SC_DB_PREFIX.'admin_role_permission');
        Schema::dropIfExists(SC_DB_PREFIX.'admin_role_menu');
        Schema::dropIfExists(SC_DB_PREFIX.'admin_menu_permission');
        Schema::dropIfExists(SC_DB_PREFIX.'admin_log');
        Schema::dropIfExists(SC_DB_PREFIX.'admin_config');
        Schema::dropIfExists(SC_DB_PREFIX.'admin_store');
        Schema::dropIfExists(SC_DB_PREFIX.'admin_store_description');
    }

}
