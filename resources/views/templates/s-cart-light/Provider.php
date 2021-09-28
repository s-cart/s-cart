<?php

//Setup for every store
function sc_template_install_store($storeId = null) {
    $storeId = $storeId ? $storeId : session('adminStoreId');
    //Uninstall for store before install
    sc_template_uninstall_store($storeId);

    $dataInsert[] = [
        'name'     => 'Banner top (s-cart-light)',
        'position' => 'banner_top',
        'page'     => 'home',
        'text'     => 'banner_image',
        'type'     => 'view',
        'sort'     => 10,
        'status'   => 1,
        'template' => 's-cart-light',
        'store_id' => $storeId,
    ];

    $dataInsert[] = [
        'name'     => 'New product (s-cart-light)',
        'position' => 'top',
        'page'     => 'home',
        'text'     => 'product_new',
        'type'     => 'view',
        'sort'     => 20,
        'status'   => 1,
        'template' => 's-cart-light',
        'store_id' => $storeId,
    ];

    $dataInsert[] = [
        'name'     => 'Top news (s-cart-light)',
        'position' => 'bottom',
        'page'     => 'home',
        'text'     => 'top_news',
        'type'     => 'view',
        'sort'     => 10,
        'status'   => 1,
        'template' => 's-cart-light',
        'store_id' => $storeId,
    ];

    
    $dataInsert[] = [
        'name'     => 'Category store left (s-cart-light)',
        'position' => 'left',
        'page'     => 'shop_home,vendor_home,vendor_product_list',
        'text'     => 'category_store_left',
        'type'     => 'view',
        'sort'     => 10,
        'status'   => 1,
        'template' => 's-cart-light',
        'store_id' => $storeId,
    ];

    $dataInsert[] = [
        'name'     => 'Category left (s-cart-light)',
        'position' => 'left',
        'page'     => 'shop_product_list',
        'text'     => 'category_left',
        'type'     => 'view',
        'sort'     => 20,
        'status'   => 1,
        'template' => 's-cart-light',
        'store_id' => $storeId,
    ];

    $dataInsert[] = [
        'name'     => 'Brand left (s-cart-light)',
        'position' => 'left',
        'page'     => 'shop_product_list',
        'text'     => 'brand_left',
        'type'     => 'view',
        'sort'     => 30,
        'status'   => 1,
        'template' => 's-cart-light',
        'store_id' => $storeId,
    ];


    $dataInsert[] = [
        'name'     => 'Product last view (s-cart-light)',
        'position' => 'left',
        'page'     => '*',
        'text'     => 'product_lastview_left',
        'type'     => 'view',
        'sort'     => 40,
        'status'   => 1,
        'template' => 's-cart-light',
        'store_id' => $storeId,
    ];

    $dataInsert[] = [
        'name'     => 'Product special (s-cart-light)',
        'position' => 'left',
        'page'     => '*',
        'text'     => 'product_special_left',
        'type'     => 'view',
        'sort'     => 50,
        'status'   => 1,
        'template' => 's-cart-light',
        'store_id' => $storeId,
    ];

    \SCart\Core\Admin\Models\AdminStoreBlockContent::createStoreBlockContentAdmin($dataInsert);
    
    $modelBanner = new \SCart\Core\Front\Models\ShopBanner;
    $modelBannerStore = new \SCart\Core\Front\Models\ShopBannerStore;   
    $idBanner1 = $modelBanner->insertGetId(['title' => 'Banner special 1 (s-cart-light)', 'image' => '/templates/s-cart-light/images/banner/banner-special-1.jpg', 'target' => '_self', 'html' => '', 'status' => 1, 'type' => 'banner-special']);
    $modelBannerStore->insert(['banner_id' => $idBanner1, 'store_id' => $storeId]);
    $idBanner2 = $modelBanner->insertGetId(['title' => 'Banner special 2 (s-cart-light)', 'image' => '/templates/s-cart-light/images/banner/banner-special-2.jpg', 'target' => '_self', 'html' => '', 'status' => 1, 'type' => 'banner-special']);
    $modelBannerStore->insert(['banner_id' => $idBanner2, 'store_id' => $storeId]);
    
    $idBannerHome1 = $modelBanner->insertGetId(['title' => 'Banner home 1 (s-cart-light)', 'image' => '/templates/s-cart-light/images/banner/banner-home-1.jpg', 'target' => '_self', 'html' => '<div class="row"><div class="col-lg-5"><h1>Sale off</h1><p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore</p><a href="#" class="primary-btn">Shop Now</a></div></div><div class="off-card"><h2>Sale <span>50%</span></h2></div>', 'status' => 1, 'type' => 'banner-home']);
    $modelBannerStore->insert(['banner_id' => $idBannerHome1, 'store_id' => $storeId]);
    $idBannerHome2 = $modelBanner->insertGetId(['title' => 'Banner home 2 (s-cart-light)', 'image' => '/templates/s-cart-light/images/banner/banner-home-2.jpg', 'target' => '_self', 'html' => '<div class="row"><div class="col-lg-5"><h1>Sale off</h1><p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore</p><a href="#" class="primary-btn">Shop Now</a></div></div><div class="off-card"><h2>Sale <span>50%</span></h2></div>', 'status' => 1, 'type' => 'banner-home']);
    $modelBannerStore->insert(['banner_id' => $idBannerHome2, 'store_id' => $storeId]);

    $idBannerSmall1 = $modelBanner->insertGetId(['title' => 'Banner small 1 (s-cart-light)', 'image' => '/templates/s-cart-light/images/banner/banner-small-1.jpg', 'target' => '_self', 'html' => '', 'status' => 1, 'type' => 'banner-small']);
    $modelBannerStore->insert(['banner_id' => $idBannerSmall1, 'store_id' => $storeId]);
    $idBannerSmall2 = $modelBanner->insertGetId(['title' => 'Banner small 2 (s-cart-light)', 'image' => '/templates/s-cart-light/images/banner/banner-small-2.jpg', 'target' => '_self', 'html' => '', 'status' => 1, 'type' => 'banner-small']);
    $modelBannerStore->insert(['banner_id' => $idBannerSmall2, 'store_id' => $storeId]);
    $idBannerSmall3 = $modelBanner->insertGetId(['title' => 'Banner small 3 (s-cart-light)', 'image' => '/templates/s-cart-light/images/banner/banner-small-3.jpg', 'target' => '_self', 'html' => '', 'status' => 1, 'type' => 'banner-small']);
    $modelBannerStore->insert(['banner_id' => $idBannerSmall3, 'store_id' => $storeId]);
}

/**
 * Setup default
 *
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
        \SCart\Core\Admin\Models\AdminStoreBlockContent::where('template', 's-cart-light')
            ->where('store_id', $storeId)
            ->delete();
        $tableBanner = (new \SCart\Core\Front\Models\ShopBanner)->getTable();
        $tableBannerStore = (new \SCart\Core\Front\Models\ShopBannerStore)->getTable();
        $idBanners = (new \SCart\Core\Front\Models\ShopBanner)
            ->join($tableBannerStore, $tableBannerStore.'.banner_id', $tableBanner.'.id')
            ->where($tableBanner.'.title', 'like', '%(s-cart-light)%')
            ->where($tableBannerStore.'.store_id', $storeId)
            ->pluck('id');

        if ($idBanners) {
            \SCart\Core\Front\Models\ShopBannerStore::whereIn('banner_id', $idBanners)
            ->delete();
            \SCart\Core\Front\Models\ShopBanner::whereIn('id', $idBanners)
            ->delete();
        }
    } else {
        // Remove from all stories
        \SCart\Core\Admin\Models\AdminStoreBlockContent::where('template', 's-cart-light')
            ->delete();
        $idBanners = \SCart\Core\Front\Models\ShopBanner::where('title', 'like', '%(s-cart-light)%')
            ->pluck('id');
        if ($idBanners) {
            \SCart\Core\Front\Models\ShopBannerStore::whereIn('banner_id', $idBanners)
            ->delete();
            \SCart\Core\Front\Models\ShopBanner::where('title', 'like', '%(s-cart-light)%')
            ->delete();
        }
    }

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