<?php
    view()->share('modelCmsCategory', (new \App\Plugins\Cms\Content\Models\CmsCategory));
    view()->share('modelCmsContent', (new App\Plugins\Cms\Content\Models\CmsContent));

    $this->loadTranslationsFrom(__DIR__.'/Lang', 'Plugins/Cms/Content');
    $this->loadViewsFrom(__DIR__.'/Views', 'Plugins/Cms/Content');

    \Illuminate\Support\Facades\Validator::extend('cms_category_alias_unique', function ($attribute, $value, $parameters, $validator) {
        $objectId = $parameters[0] ?? '';
        return (new \App\Plugins\Cms\Content\Admin\Models\AdminCmsCategory)
        ->checkAliasValidationAdmin('alias', $value, $objectId, session('adminStoreId'));
    });

    \Illuminate\Support\Facades\Validator::extend('cms_content_alias_unique', function ($attribute, $value, $parameters, $validator) {
        $objectId = $parameters[0] ?? '';
        return (new \App\Plugins\Cms\Content\Admin\Models\AdminCmsContent)
        ->checkAliasValidationAdmin('alias', $value, $objectId, session('adminStoreId'));
    });