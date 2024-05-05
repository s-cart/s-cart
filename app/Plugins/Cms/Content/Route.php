<?php
/**
 * Route front
 */

$suffix = sc_config('SUFFIX_URL')??'';
$prefixCmsCategory = sc_config('PREFIX_CMS_CATEGORY')??'cms-category';
$langUrl = config('app.seoLang'); 

if (sc_config_exist('Content')) {
    Route::group(
        [
            'namespace' => 'App\Plugins\Cms\Content\Controllers',
            'prefix' => $langUrl
        ], function () use ($suffix, $prefixCmsCategory) {
            Route::get($prefixCmsCategory, 'ContentController@cmsProcessFront')
                ->name('cms.index');
            Route::get($prefixCmsCategory.'/{alias}', 'ContentController@categoryProcessFront')
                ->name('cms.category');
            Route::get('{category}/{alias}'.$suffix, 'ContentController@contentProcessFront')
                ->name('cms.content');
        }
    );
}

if (sc_config_exist('Content', SC_ID_ROOT)) {
/**
 * Route admin
 */
Route::group(
    [
        'prefix' => SC_ADMIN_PREFIX,
        'middleware' => SC_ADMIN_MIDDLEWARE,
        'namespace' => 'App\Plugins\Cms\Content\Admin',
    ], 
    function () {
        Route::group(['prefix' => 'cms_category'], function () {
            Route::get('/', 'CmsCategoryController@index')
                ->name('admin_cms_category.index');
            Route::get('create', 'CmsCategoryController@create')
                ->name('admin_cms_category.create');
            Route::post('/create', 'CmsCategoryController@postCreate')
                ->name('admin_cms_category.create');
            Route::get('/edit/{id}', 'CmsCategoryController@edit')
                ->name('admin_cms_category.edit');
            Route::post('/edit/{id}', 'CmsCategoryController@postEdit')
                ->name('admin_cms_category.edit');
            Route::post('/delete', 'CmsCategoryController@deleteList')
                ->name('admin_cms_category.delete');
        });

        Route::group(['prefix' => 'cms_content'], function () {
            Route::get('/', 'CmsContentController@index')
                ->name('admin_cms_content.index');
            Route::get('create', 'CmsContentController@create')
                ->name('admin_cms_content.create');
            Route::post('/create', 'CmsContentController@postCreate')
                ->name('admin_cms_content.create');
            Route::get('/edit/{id}', 'CmsContentController@edit')
                ->name('admin_cms_content.edit');
            Route::post('/edit/{id}', 'CmsContentController@postEdit')
                ->name('admin_cms_content.edit');
            Route::post('/delete', 'CmsContentController@deleteList')
                ->name('admin_cms_content.delete');
        });

    }
);
}