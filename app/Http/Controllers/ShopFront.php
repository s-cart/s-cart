<?php
#app/Http/Controller/ShopFront.php
namespace App\Http\Controllers;

use App\Models\ShopBrand;
use App\Models\ShopBanner;
use App\Models\ShopCategory;
use App\Models\ShopProduct;
use App\Models\ShopSupplier;
use App\Models\ShopEmailTemplate;
use App\Models\ShopNews;
use App\Models\ShopPage;
use App\Models\ShopSubscribe;
use Illuminate\Http\Request;

class ShopFront extends GeneralController
{
    public function __construct()
    {
        parent::__construct();
    }
    /**
     * Home page
     * @return [view]
     */
    public function index()
    {
        return view($this->templatePath . '.screen.shop_home',
            array(
                'title' => sc_store('title'),
                'keyword' => sc_store('keyword'),
                'description' => sc_store('description'),
                'layout_page' => 'shop_home',
            )
        );
    }

    /**
     * Shop page
     * @return [view]
     */
    public function shop()
    {
        $sortBy = 'sort';
        $sortOrder = 'asc';
        $filter_sort = request('filter_sort') ?? '';
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

        return view($this->templatePath . '.screen.shop_product_list',
            array(
                'title' => trans('front.shop'),
                'keyword' => sc_store('keyword'),
                'description' => sc_store('description'),
                'products' => $products,
                'layout_page' => 'product_list',
                'filter_sort' => $filter_sort,
            )
        );
    }


    /**
     * display list category root (parent = 0)
     * @return [view]  
     */
    public function allCategory()
    {
        $sortBy = 'sort';
        $sortOrder = 'asc';
        $filter_sort = request('filter_sort') ?? '';
        $filterArr = [
            'sort_desc' => ['sort', 'desc'],
            'sort_asc' => ['sort', 'asc'],
            'id_desc' => ['id', 'desc'],
            'id_asc' => ['id', 'asc'],
        ];
        if (array_key_exists($filter_sort, $filterArr)) {
            $sortBy = $filterArr[$filter_sort][0];
            $sortOrder = $filterArr[$filter_sort][1];
        }

        $itemsList = (new ShopCategory)
            ->getCategoryRoot()
            ->setSort([$sortBy, $sortOrder])
            ->setPaginate()
            ->setLimit(sc_config('item_list'))
            ->getData();

        return view($this->templatePath . '.screen.shop_item_list',
            array(
                'title' => trans('front.categories'),
                'itemsList' => $itemsList,
                'keyword' => '',
                'description' => '',
                'layout_page' => 'item_list',
                'filter_sort' => $filter_sort,
            )
        );
    }

    /**
     * Category detail: list category child + product list
     * @param  [string] $alias
     * @return [view]
     */
    public function categoryDetail($alias)
    {
        $sortBy = 'sort';
        $sortOrder = 'asc';
        $filter_sort = request('filter_sort') ?? '';
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

        $category = (new ShopCategory)->getDetail($alias, $type = 'alias');

        if ($category) {
            $products = (new ShopProduct)
                ->getProductToCategory([$category->id])
                ->setLimit(sc_config('product_list'))
                ->setPaginate()
                ->setSort([$sortBy, $sortOrder])
                ->getData();

            $subCategory = (new ShopCategory)
                ->setParent($category->id)
                ->setLimit(sc_config('item_list'))
                ->setPaginate()
                ->getData();

            return view($this->templatePath . '.screen.shop_product_list',
                array(
                    'title' => $category->title,
                    'description' => $category->description,
                    'keyword' => $category->keyword,
                    'products' => $products,
                    'subCategory' => $subCategory,
                    'layout_page' => 'product_list',
                    'og_image' => asset($category->getImage()),
                    'filter_sort' => $filter_sort,
                )
            );
        } else {
            return $this->itemNotFound();
        }

    }

    /**
     * All products
     * @param  [type] $key [description]
     * @return [type]      [description]
     */
    public function allProduct()
    {
        $sortBy = 'sort';
        $sortOrder = 'asc';
        $filter_sort = request('filter_sort') ?? '';
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
        
        return view($this->templatePath . '.screen.shop_product_list',
            array(
                'title' => trans('front.all_product'),
                'keyword' => '',
                'description' => '',
                'products' => $products,
                'layout_page' => 'product_list',
                'filter_sort' => $filter_sort,
        ));
    }

    /**
     * product detail
     * @param  [string] $alias
     * @return [view]
     */
    public function productDetail($alias)
    {
        $product = (new ShopProduct)->getDetail($alias, $type = 'alias' );
        if ($product && $product->status && (sc_config('product_display_out_of_stock') || $product->stock > 0)) {
            //Update last view
            $product->view += 1;
            $product->date_lastview = date('Y-m-d H:i:s');
            $product->save();
            //End last viewed

            //Product last view
                $arrlastView = empty(\Cookie::get('productsLastView')) ? array() : json_decode(\Cookie::get('productsLastView'), true);
                $arrlastView[$product->id] = date('Y-m-d H:i:s');
                arsort($arrlastView);
                \Cookie::queue('productsLastView', json_encode($arrlastView), (86400 * 30));
            //End product last view

            $categories = $product->categories->keyBy('id')->toArray();
            $arrCategoriId = array_keys($categories);

            $productRelation = (new ShopProduct)
                ->getProductToCategory($arrCategoriId)
                ->setLimit(sc_config('product_relation'))
                ->setRandom()
                ->getData();

            return view($this->templatePath . '.screen.shop_product_detail',
                array(
                    'title' => $product->name,
                    'description' => $product->description,
                    'keyword' => $product->keyword,
                    'product' => $product,
                    'productRelation' => $productRelation,
                    'og_image' => asset($product->getImage()),
                    'layout_page' => 'product_detail',
                )
            );
        } else {
            return $this->itemNotFound();
        }
    }

    /**
     * Get product info
     * @return [json]
     */
    public function productInfo()
    {
        $id = request('id') ?? 0;
        $product = (new ShopProduct)->getDetail($id);
        $product['showPrice'] = $product->showPriceDetail();
        $product['brand_name'] = $product->brand->name;
        //Hidden cost
        unset($product['cost']);
        $product['image'] = asset($product->getImage());
        $subImages = [];
        if ($product->images->count()) {
            foreach ($product->images as $key => $image) {
                $subImages[] = asset($image->getImage());
            }
        }

        $availability = '';
        if (sc_config('show_date_available') && $product->date_available >= date('Y-m-d H:i:s')) {
            $availability .= $product->date_available;
        } elseif ($product->stock <= 0 && sc_config('product_buy_out_of_stock') == 0) {
            $availability .= trans('product.out_stock');
        } else {
            $availability .= trans('product.in_stock');
        }
        $product['availability'] = $availability;
        $product['url'] = $product->getUrl();
        $product['subImages'] = $subImages;
        return response()->json($product);

    }

    /**
     * get all brand
     * @return [view]
     */
    public function allBrand()
    {
        $sortBy = 'sort';
        $sortOrder = 'asc';
        $filter_sort = request('filter_sort') ?? '';
        $filterArr = [
            'name_desc' => ['name', 'desc'],
            'name_asc' => ['name', 'asc'],
            'sort_desc' => ['sort', 'desc'],
            'sort_asc' => ['sort', 'asc'],
            'id_desc' => ['id', 'desc'],
            'id_asc' => ['id', 'asc'],
        ];
        if (array_key_exists($filter_sort, $filterArr)) {
            $sortBy = $filterArr[$filter_sort][0];
            $sortOrder = $filterArr[$filter_sort][1];
        }

        $itemsList = (new ShopBrand)
            ->setSort([$sortBy, $sortOrder])
            ->setPaginate()
            ->setLimit(sc_config('item_list'))
            ->getData();
        return view($this->templatePath . '.screen.shop_item_list',
            array(
                'title' => trans('front.brands'),
                'itemsList' => $itemsList,
                'keyword' => '',
                'description' => '',
                'layout_page' => 'item_list',
                'filter_sort' => $filter_sort,
            )
        );
    }

    /**
     * brand detail
     * @param  [string] $alias
     * @return [view] 
     */
    public function brandDetail($alias)
    {
        $sortBy = 'sort';
        $sortOrder = 'asc';
        $filter_sort = request('filter_sort') ?? '';
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

        $brand = (new ShopBrand)->getDetail($alias, $type = 'alias');
        if($brand) {
            $products = (new ShopProduct)
            ->getProductToBrand($brand->id)
            ->setPaginate()
            ->setLimit(sc_config('product_list'))
            ->setSort([$sortBy, $sortOrder])
            ->getData();

            return view($this->templatePath . '.screen.shop_product_list',
                array(
                    'title' => $brand->name,
                    'description' => $brand->description,
                    'keyword' => $brand->keyword,
                    'layout_page' => 'product_list',
                    'products' => $products,
                    'og_image' => asset($brand->getImage()),
                    'filter_sort' => $filter_sort,
                )
            );
        } else {
            return $this->itemNotFound();
        }
    }

    /**
     * all supplier
     * @return [view]
     */
    public function allSupplier()
    {
        $sortBy = 'sort';
        $sortOrder = 'asc';
        $filter_sort = request('filter_sort') ?? '';
        $filterArr = [
            'name_desc' => ['name', 'desc'],
            'name_asc' => ['name', 'asc'],
            'sort_desc' => ['sort', 'desc'],
            'sort_asc' => ['sort', 'asc'],
            'id_desc' => ['id', 'desc'],
            'id_asc' => ['id', 'asc'],
        ];
        if (array_key_exists($filter_sort, $filterArr)) {
            $sortBy = $filterArr[$filter_sort][0];
            $sortOrder = $filterArr[$filter_sort][1];
        }
        $itemsList = (new ShopSupplier)
            ->setSort([$sortBy, $sortOrder])
            ->setPaginate()
            ->setLimit(sc_config('item_list'))
            ->getData();

        return view($this->templatePath . '.screen.shop_item_list',
            array(
                'title' => trans('front.suppliers'),
                'itemsList' => $itemsList,
                'keyword' => '',
                'description' => '',
                'layout_page' => 'item_list',
                'filter_sort' => $filter_sort,
            )
        );
    }

    /**
     * supplier detail
     * @param  [string] alias [description]
     * @return [view]
     */
    public function supplierDetail($alias)
    {
        $sortBy = 'sort';
        $sortOrder = 'asc';
        $filter_sort = request('filter_sort') ?? '';
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

        $supplier = (new ShopSupplier)->getDetail($alias, $type = 'alias');
        if ($supplier) {
            $products = (new ShopProduct)
            ->getProductToSupplier($supplier->id)
            ->setPaginate()
            ->setLimit(sc_config('product_list'))
            ->setSort([$sortBy, $sortOrder])
            ->getData();

            return view($this->templatePath . '.screen.shop_product_list',
                array(
                    'title' => $supplier->name,
                    'description' => $supplier->description,
                    'keyword' => $supplier->keyword,
                    'layout_page' => 'product_list',
                    'products' => $products,
                    'og_image' => asset($supplier->getImage()),
                    'filter_sort' => $filter_sort,
                    )
            );
        } else {
            return $this->itemNotFound();
        }


    }

    /**
     * search product
     * @return [view]
     */
    public function search()
    {
        $sortBy = 'sort';
        $sortOrder = 'asc';
        $filter_sort = request('filter_sort') ?? '';
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
        $keyword = request('keyword') ?? '';
        $products = (new ShopProduct)->setKeyword($keyword)
                    ->setSort([$sortBy, $sortOrder])
                    ->setPaginate()
                    ->setLimit(sc_config('product_list'))
                    ->getData();

        return view($this->templatePath . '.screen.shop_product_list',
            array(
                'title' => trans('front.search') . ': ' . $keyword,
                'products' => $products,
                'layout_page' => 'product_list',
                'filter_sort' => $filter_sort,
            )
        );
    }

    /**
     * Process click banner
     *
     * @param   [int]  $id  
     *
     */
    public function clickBanner($id){
        $banner = ShopBanner::find($id);
        if($banner) {
            $banner->click +=1;
            $banner->save();
            return redirect(url($banner->url??'/'));
        }
        return redirect(url('/'));
    }



    /**
     * form contact
     * @return [view]
     */
    public function getContact()
    {
        return view(
            $this->templatePath . '.screen.shop_contact',
            array(
                'title' => trans('front.contact'),
                'description' => '',
                'keyword' => '',
                'layout_page' => 'shop_contact',
                'og_image' => '',
            )
        );
    }


    /**
     * process contact form
     * @param  Request $request [description]
     * @return [mix]
     */
    public function postContact(Request $request)
    {
        $validator = $request->validate([
            'name' => 'required',
            'title' => 'required',
            'content' => 'required',
            'email' => 'required|email',
            'phone' => 'required|regex:/^0[^0][0-9\-]{7,13}$/',
        ], [
            'name.required' => trans('validation.required', ['attribute' => trans('front.contact_form.name')]),
            'content.required' => trans('validation.required', ['attribute' => trans('front.contact_form.content')]),
            'title.required' => trans('validation.required', ['attribute' => trans('front.contact_form.title')]),
            'email.required' => trans('validation.required', ['attribute' => trans('front.contact_form.email')]),
            'email.email' => trans('validation.email', ['attribute' => trans('front.contact_form.email')]),
            'phone.required' => trans('validation.required', ['attribute' => trans('front.contact_form.phone')]),
            'phone.regex' => trans('validation.phone', ['attribute' => trans('front.contact_form.phone')]),
        ]);
        //Send email
        $data = $request->all();
        $data['content'] = str_replace("\n", "<br>", $data['content']);

        if (sc_config('contact_to_admin')) {
            $checkContent = (new ShopEmailTemplate)
                ->where('group', 'contact_to_admin')
                ->where('status', 1)
                ->first();
            if ($checkContent) {
                $content = $checkContent->text;
                $dataFind = [
                    '/\{\{\$title\}\}/',
                    '/\{\{\$name\}\}/',
                    '/\{\{\$email\}\}/',
                    '/\{\{\$phone\}\}/',
                    '/\{\{\$content\}\}/',
                ];
                $dataReplace = [
                    $data['title'],
                    $data['name'],
                    $data['email'],
                    $data['phone'],
                    $data['content'],
                ];
                $content = preg_replace($dataFind, $dataReplace, $content);
                $dataView = [
                    'content' => $content,
                ];

                $config = [
                    'to' => sc_store('email'),
                    'replyTo' => $data['email'],
                    'subject' => $data['title'],
                ];
                sc_send_mail($this->templatePath . '.mail.contact_to_admin', $dataView, $config, []);
            }
        }

        return redirect()
            ->route('contact')
            ->with('success', trans('front.thank_contact'));
    }

    /**
     * Render page
     * @param  [string] $alias
     */
    public function pageDetail($alias)
    {
        $page = (new ShopPage)->getDetail($alias, $type = 'alias');
        if ($page) {
            return view(
                $this->templatePath . '.screen.shop_page',
                array(
                    'title' => $page->title,
                    'description' => $page->description,
                    'keyword' => $page->keyword,
                    'page' => $page,
                    'og_image' => asset($page->getImage()),
                    'layout_page' => 'shop_page',
                )
            );
        } else {
            return $this->pageNotFound();
        }
    }

    /**
     * Render news
     * @return [type] [description]
     */
    public function news()
    {
        $news = (new ShopNews)
            ->setLimit(sc_config('news_list'))
            ->setPaginate()
            ->getData();

        return view(
            $this->templatePath . '.screen.shop_news',
            array(
                'title' => trans('front.blog'),
                'description' => sc_store('description'),
                'keyword' => sc_store('keyword'),
                'news' => $news,
                'layout_page' => 'news_list',
            )
        );
    }

    /**
     * News detail
     *
     * @param   [string]  $alias 
     *
     * @return  view
     */
    public function newsDetail($alias)
    {
        $news = (new ShopNews)->getDetail($alias, $type ='alias');
        if ($news) {
            return view(
                $this->templatePath . '.screen.shop_news_detail',
                array(
                    'title' => $news->title,
                    'news' => $news,
                    'description' => $news->description,
                    'keyword' => $news->keyword,
                    'og_image' => asset($news->getImage()),
                    'layout_page' => 'news_detail',
                )
            );
        } else {
            return $this->pageNotFound();
        }
    }

    /**
     * email subscribe
     * @param  Request $request
     * @return json
     */
    public function emailSubscribe(Request $request)
    {
        $validator = $request->validate([
            'subscribe_email' => 'required|email',
            ], [
            'email.required' => trans('validation.required'),
            'email.email'    => trans('validation.email'),
        ]);
        $data       = $request->all();
        $checkEmail = ShopSubscribe::where('email', $data['subscribe_email'])
            ->first();
        if (!$checkEmail) {
            ShopSubscribe::insert(['email' => $data['subscribe_email']]);
        }
        return redirect()->back()
            ->with(['success' => trans('subscribe.subscribe_success')]);
    }

}
