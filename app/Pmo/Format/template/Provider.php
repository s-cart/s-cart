<?php
/**
 * [sc_template_info description]
 *
 * @return  [type]  [return description]
 */
function sc_template_info() {
    $config = [];
    if (file_exists($fileConfig = __DIR__.'/config.json')) {
        $config = json_decode(file_get_contents($fileConfig), true);
    }
    return $config;
}

/**
 * Install template
 *
 * @param [type] $storeId
 * @return void
 */
function sc_template_install($data = []) {
    $storeId = $data['store_id'] ?? null;
    sc_template_install_default();
    sc_template_install_store($storeId);
}

/**
 * Uninstall template
 *
 * @param [type] $storeId
 * @return void
 */
function sc_template_uninstall($data = []) {
    $storeId = $data['store_id'] ?? null;
    sc_template_uninstall_default();
    sc_template_uninstall_store($storeId);
}


/**
 * Insert css default for template
 *
 * @param   [type]  $storeId  [$storeId description]
 *
 * @return  [type]            [return description]
 */
function sc_process_css_default($storeId = null) {
        if ($storeId) {
        $cssContent = '';
        if (file_exists($path = resource_path() . '/views/templates/'.sc_template_info()['configKey'].'/css_default.css')) {
            $cssContent = file_get_contents($path);
        }
        \App\Pmo\Front\Models\ShopStoreCss::insert(['css' => $cssContent, 'store_id' => $storeId, 'template' => sc_template_info()['configKey']]);
    }
}

/**
 * [sc_template_install_store description]
 * This function contains the settings information for each store using the template. It is called when:
 * The main store installs the template for the first time in the system. The parameters are set for the main store.
 * When a new store is created, the parameters of the selected template will be set for this store.
 * When the store changes the new template, the parameters of this template will be set for the store
 * -> Therefore, the default data for the whole system, only setting 1 should not be placed here. Let's put them in sc_template_install_default()
 */
function sc_template_install_store($storeId = null) {
    $storeId = $storeId ? $storeId : session('adminStoreId');
    $dataInsert[] = [
        'id'       => sc_uuid(),
        'name'     => 'Banner top ('.sc_template_info()['configKey'].')',
        'position' => 'banner_top',
        'page'     => 'home',
        'text'     => 'banner_image',
        'type'     => 'view',
        'sort'     => 10,
        'status'   => 1,
        'template' => sc_template_info()['configKey'],
        'store_id' => $storeId,
    ];
    \App\Pmo\Admin\Models\AdminStoreBlockContent::insert($dataInsert);

    $modelBanner = new \App\Pmo\Front\Models\ShopBanner;
    $modelBannerStore = new \App\Pmo\Front\Models\ShopBannerStore; 

    $idBanner = $modelBanner->create(['title' => 'Banner store ('.sc_template_info()['configKey'].')', 'image' => '/data/banner/banner-store.jpg', 'target' => '_self', 'html' => '', 'status' => 1, 'type' => 'banner-store']);
    $modelBannerStore->create(['banner_id' => $idBanner->id, 'store_id' => $storeId]);

    //Insert css default
    sc_process_css_default($storeId);
}

/**
 * Setup default
 * This function installs information for the whole system. This function is only called the first time the template is installed.
 * @return void
 */
function sc_template_install_default() {}

/**
 * Remove default
 *
 * @return void
 */
function sc_template_uninstall_default() {}


/**
 * Remove setup for every store
 *
 * @param [type] $storeId
 * @return void
 */
function sc_template_uninstall_store($storeId = null) {
        if ($storeId) {
        \App\Pmo\Admin\Models\AdminStoreBlockContent::where('template', sc_template_info()['configKey'])
            ->where('store_id', $storeId)
            ->delete();
        $tableBanner = (new \App\Pmo\Front\Models\ShopBanner)->getTable();
        $tableBannerStore = (new \App\Pmo\Front\Models\ShopBannerStore)->getTable();
        $idBanners = (new \App\Pmo\Front\Models\ShopBanner)
            ->join($tableBannerStore, $tableBannerStore.'.banner_id', $tableBanner.'.id')
            ->where($tableBanner.'.title', 'like', '%('.sc_template_info()['configKey'].')%')
            ->where($tableBannerStore.'.store_id', $storeId)
            ->pluck('id');

        if ($idBanners) {
            \App\Pmo\Front\Models\ShopBannerStore::whereIn('banner_id', $idBanners)
            ->delete();
            \App\Pmo\Front\Models\ShopBanner::whereIn('id', $idBanners)
            ->delete();
        }
        \App\Pmo\Front\Models\ShopStoreCss::where('template', sc_template_info()['configKey'])
        ->where('store_id', $storeId)
        ->delete();
    } else {
        // Remove from all stories
        \App\Pmo\Admin\Models\AdminStoreBlockContent::where('template', sc_template_info()['configKey'])
            ->delete();
        $idBanners = \App\Pmo\Front\Models\ShopBanner::where('title', 'like', '%('.sc_template_info()['configKey'].')%')
            ->pluck('id');
        if ($idBanners) {
            \App\Pmo\Front\Models\ShopBannerStore::whereIn('banner_id', $idBanners)
            ->delete();
            \App\Pmo\Front\Models\ShopBanner::whereIn('id', $idBanners)
            ->delete();
        }
        \App\Pmo\Front\Models\ShopStoreCss::where('template', sc_template_info()['configKey'])
        ->delete();
    }
}