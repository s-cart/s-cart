<?php

use Illuminate\Support\Facades\Route;
if (config('s-pmo.ecommerce_mode', 1)) {
//Route api
Route::group(
    [
        'middleware' => SC_API_MIDDLEWARE,
        'prefix' => 'api',
        'namespace' => '\App\Pmo\Api\Controllers',
    ],
    function () {

    //Customer
        Route::group(['prefix' => 'member'], function () {
            Route::post('login', 'MemberAuthController@login');
            Route::post('create', 'MemberAuthController@create');
            Route::group([
            'middleware' => ['auth:api', config('api.auth.api_scope_type').':'.config('api.auth.api_scope_user').','.config('api.auth.api_scope_user_guest')]
            ], function () {
                Route::get('logout', 'MemberAuthController@logout');
                Route::get('info', 'MemberController@getInfo');
                Route::get('orders', 'MemberOrderController@orders');
                Route::get('orders/{id}', 'MemberOrderController@orderDetail');
            });

            Route::group([
            'middleware' => ['auth:api', config('api.auth.api_scope_type').':'.config('api.auth.api_scope_user')]
            ], function () {
                Route::post('create_order', 'MemberOrderController@createOrder');
                Route::post('cancel_order/{id}', 'MemberOrderController@cancelOrder');
            });
        });

        //Admin
        Route::group(['prefix' => 'admin'], function () {
            Route::post('login', 'AdminAuthController@login');
            Route::group([
            'middleware' => ['auth:admin-api', config('api.auth.api_scope_type_admin').':'.config('api.auth.api_scope_admin')]
            ], function () {
                Route::get('logout', 'AdminAuthController@logout');
                Route::get('info', 'AdminController@getInfo');

                // Management customer
                Route::post('create_customer', 'AdminCustomerController@create');
                Route::get('customers', 'AdminCustomerController@customers');
                Route::get('customers/{id}', 'AdminCustomerController@customerDetail');

                Route::get('orders', 'AdminOrderController@orders');
                Route::get('orders/{id}', 'AdminOrderController@orderDetail');
                Route::post('create_order', 'AdminOrderController@createOrder');
                Route::post('cancel_order/{id}', 'AdminOrderController@cancelOrder');

                Route::get('countries', 'AdminShopFront@allCountry');
                Route::get('countries/{id}', 'AdminShopFront@countryDetail');
                Route::get('currencies', 'AdminShopFront@allCurrency');
                Route::get('currencies/{id}', 'AdminShopFront@CurrencyDetail');
                Route::get('languages', 'AdminShopFront@allLanguage');
                Route::get('languages/{id}', 'AdminShopFront@LanguageDetail');


                Route::get('categories', 'AdminShopFront@allCategory');
                Route::get('categories/{id}', 'AdminShopFront@categoryDetail');
                Route::get('products', 'AdminShopFront@allProduct');
                Route::get('products/{id}', 'AdminShopFront@productDetail');
                Route::get('brands', 'AdminShopFront@allBrand');
                Route::get('brands/{id}', 'AdminShopFront@brandDetail');
                Route::get('supplieres', 'AdminShopFront@allSupplier');
                Route::get('supplieres/{id}', 'AdminShopFront@supplierDetail');
            });
        });
    }
);
}
