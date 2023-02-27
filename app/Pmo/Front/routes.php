<?php

use Illuminate\Support\Facades\Route;

$suffix = sc_config('SUFFIX_URL')??'';
$langUrl = config('app.seoLang');
//Process namespace
if (file_exists(app_path('Http/Controllers/ShopContentController.php'))) {
    $nameSpaceFrontContent = 'App\Http\Controllers';
} else {
    $nameSpaceFrontContent = 'App\Pmo\Front\Controllers';
}

if (file_exists(app_path('Http/Controllers/ShopStoreController.php'))) {
    $nameSpaceFrontStore = 'App\Http\Controllers';
} else {
    $nameSpaceFrontStore = 'App\Pmo\Front\Controllers';
}


//Route customize
Route::group(
    [
        'middleware' => SC_FRONT_MIDDLEWARE,
    ],
    function () use($langUrl){
        //Include route custom
        if (file_exists(base_path('routes/myroute.php'))) {
            require_once base_path('routes/myroute.php');
        }
    }
);


//Include route ecommerce
if (config('s-pmo.ecommerce_mode', 1)) {
    Route::middleware(SC_FRONT_MIDDLEWARE)
        ->group(function () use ($suffix, $langUrl) {
            foreach (glob(__DIR__ . '/Routes/*.php') as $filename) {
                    require_once $filename;
            }
        }
    );

    //Route shop
    Route::group(
        [
            'middleware' => SC_FRONT_MIDDLEWARE
        ],
        function () use ($langUrl, $nameSpaceFrontStore) {
            $prefixShop = sc_config('PREFIX_SHOP') ?? 'shop';
            Route::get($langUrl.$prefixShop, $nameSpaceFrontStore.'\ShopStoreController@shopProcessFront')
            ->name('shop');
        }
    );

}


//Content with prefix
Route::group(
    [
        'prefix' => $langUrl,
        'middleware' => SC_FRONT_MIDDLEWARE
    ],
    function () use ($suffix, $nameSpaceFrontContent, $nameSpaceFrontStore) {
        $prefixSearch = sc_config('PREFIX_SEARCH')??'search';
        $prefixContact = sc_config('PREFIX_CONTACT')??'contact';
        $prefixAbout = sc_config('PREFIX_ABOUT')??'about';
        $prefixNews = sc_config('PREFIX_NEWS')??'news';

        //Search
        if (config('s-pmo.ecommerce_mode', 1)) {
            Route::get($prefixSearch.$suffix, $nameSpaceFrontStore.'\ShopStoreController@searchProcessFront')
                ->name('search');
        } else {
            Route::get($prefixSearch.$suffix, $nameSpaceFrontContent.'\ShopContentController@searchProcessFront')
                ->name('search');
        }


        //Subscribe
        Route::post('/subscribe', $nameSpaceFrontContent.'\ShopContentController@emailSubscribe')
            ->name('subscribe');

        //contact
        Route::get($prefixContact.$suffix, $nameSpaceFrontContent.'\ShopContentController@getContactProcessFront')
            ->name('contact');
        Route::post('/contact', $nameSpaceFrontContent.'\ShopContentController@postContact')
            ->name('contact.post');

        //About
        Route::get($prefixAbout.$suffix, $nameSpaceFrontContent.'\ShopContentController@getAboutProcessFront')
        ->name('about');

        //News
        Route::get($prefixNews, $nameSpaceFrontContent.'\ShopContentController@newsProcessFront')
            ->name('news');
        Route::get($prefixNews.'/{alias}'.$suffix, $nameSpaceFrontContent.'\ShopContentController@newsDetailProcessFront')
            ->name('news.detail');

        //Process click banner
        Route::get('/banner/{id}', $nameSpaceFrontContent.'\ShopContentController@clickBanner')
            ->name('banner.click');
    }
);


//Content without prefix
Route::group(
    [
        'middleware' => SC_FRONT_MIDDLEWARE
    ],
    function () use ($nameSpaceFrontContent) {
        //Process click banner
        Route::get('/banner/{id}', $nameSpaceFrontContent.'\ShopContentController@clickBanner')
        ->name('banner.click');

        //Route home
        Route::get('/', $nameSpaceFrontContent.'\ShopContentController@index')
            ->name('home');
        Route::get('index.html', $nameSpaceFrontContent.'\ShopContentController@index');
        Route::get('{lang?}', $nameSpaceFrontContent.'\ShopContentController@index')
            ->where(['lang' => '[a-zA-Z]{2}'])
            ->name('home.lang');

        //Language
        Route::get('locale/{code}', function ($code) {
            session(['locale' => $code]);
            if (request()->fullUrl() === redirect()->back()->getTargetUrl()
            ) {
                return redirect()->route('home');
            }
            if (sc_route('home.lang') === redirect()->back()->getTargetUrl()
            ) {
                return redirect(sc_route('home.lang', ['lang' => $code]));
            }
            $urlBack = str_replace(url('/' . app()->getLocale()) . '/', url('/' . $code) . '/', back()->getTargetUrl());
            return redirect($urlBack);
        })->name('locale');
        
        if (config('s-pmo.ecommerce_mode', 1)) {
            //Currency
            Route::get('currency/{code}', function ($code) {
                session(['currency' => $code]);
                if (request()->fullUrl() === redirect()->back()->getTargetUrl()) {
                    return redirect()->route('home');
                }
                return back();
            })->name('currency');
        }
    }
);


//Route plugin
Route::group(
    [
        'middleware' => SC_FRONT_MIDDLEWARE,
    ],
    function () use($langUrl){
        foreach (glob(app_path() . '/Plugins/*/*/Route.php') as $filename) {
            require_once $filename;
        }
    }
);


Route::group(
    [
        'middleware' => SC_FRONT_MIDDLEWARE,
    ],
    function () use ($suffix, $langUrl, $nameSpaceFrontContent) {
        //--Please keep 2 lines route (pages + pageNotFound) at the bottom
        Route::get($langUrl.'{alias}'.$suffix, $nameSpaceFrontContent.'\ShopContentController@pageDetailProcessFront')->name('page.detail');
        // Route::fallback('ShopContentController@pageNotFound')->name('pageNotFound'); //Make sure before using this route.
        // There will be disadvantages when detecting 404 errors for static files like images, scripts ..
        //--end keep
        
        //=======End Front
    }
);
