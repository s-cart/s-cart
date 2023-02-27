<?php
$prefixBrand = sc_config('PREFIX_BRAND')??'brand';
if (file_exists(app_path('Http/Controllers/ShopBrandController.php'))) {
    $nameSpaceFrontBrand = 'App\Http\Controllers';
} else {
    $nameSpaceFrontBrand = 'App\Pmo\Front\Controllers';
}

Route::group(
    [
        'prefix' => $langUrl.$prefixBrand
    ],
    function ($router) use ($suffix, $nameSpaceFrontBrand) {
        $router->get('/', $nameSpaceFrontBrand.'\ShopBrandController@allBrandsProcessFront')
            ->name('brand.all');
        $router->get('/{alias}'.$suffix, $nameSpaceFrontBrand.'\ShopBrandController@brandDetailProcessFront')
            ->name('brand.detail');
    }
);
