<?php
namespace App\Pmo\Front\Controllers;

use App\Pmo\Front\Controllers\RootFrontController;
use App\Pmo\Front\Models\ShopProduct;

class ShopProductController extends RootFrontController
{
    public function __construct()
    {
        parent::__construct();
    }
    
    /**
     * Process front all products
     *
     * @param [type] ...$params
     * @return void
     */
    public function allProductsProcessFront(...$params)
    {
        if (config('app.seoLang')) {
            $lang = $params[0] ?? '';
            sc_lang_switch($lang);
        }
        return $this->_allProducts();
    }

    /**
     * All products
     * @return [view]
     */
    private function _allProducts()
    {
        $sortBy = 'sort';
        $sortOrder = 'asc';
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

        $products = (new ShopProduct)
            ->setLimit(sc_config('product_list'))
            ->setPaginate()
            ->setSort([$sortBy, $sortOrder])
            ->getData();

        sc_check_view($this->templatePath . '.screen.shop_product_list');
        return view(
            $this->templatePath . '.screen.shop_product_list',
            array(
                'title'       => sc_language_render('front.all_product'),
                'keyword'     => '',
                'description' => '',
                'products'    => $products,
                'layout_page' => 'shop_product_list',
                'filter_sort' => $filter_sort,
                'breadcrumbs' => [
                    ['url'    => '', 'title' => sc_language_render('front.all_product')],
                ],
            )
        );
    }

    /**
     * Process front product detail
     *
     * @param [type] ...$params
     * @return void
     */
    public function productDetailProcessFront(...$params)
    {
        if (config('app.seoLang')) {
            $lang = $params[0] ?? '';
            $alias = $params[1] ?? '';
            sc_lang_switch($lang);
        } else {
            $alias = $params[0] ?? '';
        }
        return $this->_productDetail($alias);
    }

    /**
     * Get product detail
     *
     * @param   [string]  $alias      [$alias description]
     *
     * @return  [mix]
     */
    private function _productDetail($alias)
    {
        $storeId = config('app.storeId');
        $product = (new ShopProduct)->getDetail($alias, $type = 'alias', $storeId);
        if ($product && $product->status && (!sc_config('product_stock', $storeId) || sc_config('product_display_out_of_stock', $storeId) || $product->stock > 0)) {
            //Update last view
            $product->view += 1;
            $product->date_lastview = sc_time_now();
            $product->save();
            //End last viewed

            //Product last view
            $arrlastView = empty(\Cookie::get('productsLastView')) ? array() : json_decode(\Cookie::get('productsLastView'), true);
            $arrlastView[$product->id] = sc_time_now();
            arsort($arrlastView);
            \Cookie::queue('productsLastView', json_encode($arrlastView), (86400 * 30));
            //End product last view

            $categories = $product->categories->keyBy('id')->toArray();
            $arrCategoriId = array_keys($categories);

            //first category
            $categoryFirst = $product->categories->first();
            if ($categoryFirst) {
                $dataCategoryFirst = [
                    'url' => $categoryFirst->getUrl(),
                    'title' => $categoryFirst->getTitle(),
                ];
            } else {
                $dataCategoryFirst = [
                    'url' => '',
                    'title' => '',
                ];
            }

            $productRelation = (new ShopProduct)
                ->getProductToCategory($arrCategoriId)
                ->setLimit(sc_config('product_relation', $storeId))
                ->setRandom()
                ->getData();

            sc_check_view($this->templatePath . '.screen.shop_product_detail');
            return view(
                $this->templatePath . '.screen.shop_product_detail',
                array(
                    'title'           => $product->name,
                    'description'     => $product->description,
                    'keyword'         => $product->keyword,
                    'productId'       => $product->id,
                    'product'         => $product,
                    'productRelation' => $productRelation,
                    'og_image'        => sc_file($product->getImage()),
                    'layout_page'     => 'shop_product_detail',
                    'breadcrumbs'     => [
                        ['url'        => sc_route('shop'), 'title' => sc_language_render('front.shop')],
                        $dataCategoryFirst,
                        ['url'        => '', 'title' => $product->name],
                    ],
                )
            );
        } else {
            return $this->itemNotFound();
        }
    }
}
