<?php
namespace App\Pmo\Front\Controllers;

use App\Pmo\Front\Controllers\RootFrontController;
use App\Pmo\Front\Models\ShopProduct;
use App\Pmo\Front\Models\ShopBrand;
use App\Pmo\Front\Models\ShopCategory;

class ShopStoreController extends RootFrontController
{
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Process front shop page
     *
     * @param [type] ...$params
     * @return void
     */
    public function shopProcessFront(...$params)
    {
        if (config('app.seoLang')) {
            $lang = $params[0] ?? '';
            sc_lang_switch($lang);
        }
        return $this->_shop();
    }

    /**
     * Shop page
     * @return [view]
     */
    private function _shop()
    {
        $filter_sort = sc_request('filter_sort','','string');
        
        $products = $this->processProductList();

        sc_check_view($this->templatePath . '.screen.shop_home');
        
        return view(
            $this->templatePath . '.screen.shop_home',
            array(
                'title'       => sc_language_render('front.shop'),
                'keyword'     => sc_store('keyword'),
                'description' => sc_store('description'),
                'products'    => $products,
                'layout_page' => 'shop_home',
                'filter_sort' => $filter_sort,
                'breadcrumbs'        => [
                    ['url'           => '', 'title' => sc_language_render('front.shop')],
                ],
            )
        );
    }

    /**
     * Process front search page
     *
     * @param [type] ...$params
     * @return void
     */
    public function searchProcessFront(...$params)
    {
        if (config('app.seoLang')) {
            $lang = $params[0] ?? '';
            sc_lang_switch($lang);
        }
        return $this->_search();
    }

    /**
     * search product
     * @return [view]
     */
    private function _search()
    {
        $filter_sort = sc_request('filter_sort','','string');
        $keyword = sc_request('keyword','','string');
        
        $products = $this->processProductList();


        $view = $this->templatePath . '.screen.shop_product_list';

        if (view()->exists($this->templatePath . '.screen.shop_search')) {
            $view = $this->templatePath . '.screen.shop_search';
        }
        sc_check_view($view);
        return view(
            $view,
            array(
                'title'       => sc_language_render('action.search') . ': ' . $keyword,
                'products'    => $products,
                'layout_page' => 'shop_search',
                'filter_sort' => $filter_sort,
                'breadcrumbs' => [
                    ['url'    => '', 'title' => sc_language_render('action.search')],
                ],
            )
        );
    }

    /**
     * Process product list
     *
     * @return  [type]  [return description]
     */
    protected function processProductList() {
        $sortBy = 'sort';
        $sortOrder = 'asc';
        $arrBrandId = [];
        $categoryId = '';
        $filter_sort = sc_request('filter_sort','','string');
        $filterArr = [
            'price_desc' => ['price', 'desc'],
            'price_asc' => ['price', 'asc'],
            'sort_desc' => ['sort', 'desc'],
            'sort_asc' => ['sort', 'asc'],
            'id_desc' => ['id', 'desc'],
            'id_asc' => ['id', 'asc'],
        ];
        if (array_key_exists($filter_sort, $filterArr)) {
            $sortBy = $filterArr[$filter_sort][0];
            $sortOrder = $filterArr[$filter_sort][1];
        }
        $keyword = sc_request('keyword','', 'string');
        $cid = sc_request('cid','', 'string');
        $bid = sc_request('bid','', 'string');
        $price = sc_request('price','', 'string');
        $brand = sc_request('brand','', 'string');
        $category = sc_request('category','', 'string');
        if ($bid) {
            $arrBrandId = explode(',', $bid);
        } else {
            if ($brand) {
                $arrAliasBrand = explode(',', $brand);
                $arrBrandId = ShopBrand::whereIn('alias', $arrAliasBrand)->pluck('id')->toArray();
            }
        }

        if ($cid) {
            $categoryId = trim($cid);
        } else {
            if ($category) {
                $categoryId = ShopCategory::where('alias', $category)->first();
                if ($categoryId) {
                    $categoryId = $categoryId->id;
                }
            }
        }

        $products = (new ShopProduct);

        if ($keyword) {
            $products = $products->setKeyword($keyword);
        }
        //Filter category
        if ($categoryId) {
            $arrCate = (new ShopCategory)->getListSub($categoryId);
            $products = $products->getProductToCategory($arrCate);
        }
        //filter brand
        if ($arrBrandId) {
            $products = $products->getProductToBrand($arrBrandId);
        }
        //Filter price
        if ($price) {
            $products = $products->setRangePrice($price);
        }

        $products = $products
            ->setLimit(sc_config('product_list'))
            ->setPaginate()
            ->setSort([$sortBy, $sortOrder])
            ->getData();

        return $products;
    }
}
