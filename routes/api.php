<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
 */

// Route::middleware('auth:api')->get('/user', function (Request $request) {
//     return $request->user();
// });
Route::group(['middleware' => ['json.response', 'api.connection', 'throttle:1000']], function () {
    Route::group(['prefix' => 'auth'], function () {
        Route::post('login', 'AuthController@login');
        Route::post('create', 'AuthController@create');
      
        Route::group([
          'middleware' => 'auth:api'
        ], function() {
            Route::get('logout', 'AuthController@logout');
            Route::get('user', 'AccountController@user');
            Route::get('orders', 'AccountController@orders');
            Route::get('orders/{id}', 'AccountController@ordersDetail');
        });
    });
    
    Route::get('categories', 'ShopFront@allCategory');
    Route::get('categories/{id}', 'ShopFront@categoryDetail');
    Route::get('products', 'ShopFront@allProduct');
    Route::get('products/{id}', 'ShopFront@productDetail');
    Route::get('brands', 'ShopFront@allBrand');
    Route::get('brands/{id}', 'ShopFront@brandDetail');
    Route::get('supplieres', 'ShopFront@allSupplier');
    Route::get('supplieres/{id}', 'ShopFront@brandDetail');
});
