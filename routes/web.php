<?php
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
 */

/*
 Home
*/
$prefixShop = sc_config('PREFIX_SHOP')??'shop';

Route::get('/', 'ShopFront@index')->name('home');
Route::get('/'.$prefixShop, 'ShopFront@shop')->name('shop');
Route::get('index.html', 'ShopFront@index');

$suffix = sc_config('SUFFIX_URL')??'';

//Language
Route::get('locale/{code}', function ($code) {
    session(['locale' => $code]);
    return back();
})->name('locale');

//Currency
Route::get('currency/{code}', function ($code) {
    session(['currency' => $code]);
    return back();
})->name('currency');

//Process click banner
Route::get('/banner/{id}', 'ShopFront@clickBanner')
->name('banner.click');    

//--Please keep 2 lines route (pages + pageNotFound) at the bottom
Route::get('/{alias}'.$suffix, 'ShopFront@pageDetail')->name('page.detail');
// Route::fallback('ShopFront@pageNotFound')->name('pageNotFound'); //Make sure before using this route. 
// There will be disadvantages when detecting 404 errors for static files like images, scripts ..
//--end keep

//=======End Front
