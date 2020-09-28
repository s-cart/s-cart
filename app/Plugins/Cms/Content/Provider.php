<?php
    view()->share('modelCmsCategory', (new \App\Plugins\Cms\Content\Models\CmsCategory));
    view()->share('modelCmsContent', (new App\Plugins\Cms\Content\Models\CmsContent));

    $this->loadTranslationsFrom(__DIR__.'/Lang', 'Plugins/Cms/Content');
    $this->loadViewsFrom(__DIR__.'/Views', 'Plugins/Cms/Content');