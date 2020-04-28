<?php
#app/Http/Controller/GeneralController.php
namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\ShopSubscribe;
use Illuminate\Http\Request;
use App\Models\ShopProduct;
use App\Models\ShopCategory;
use App\Models\ShopBanner;
use App\Models\ShopBrand;
use App\Models\ShopSupplier;
use App\Models\ShopNews;
use App\Models\ShopPage;
use App\Models\ShopUser;
use App\Models\ShopOrder;

class GeneralController extends Controller
{
    public $templatePath;
    public $templateFile;
    public function __construct()
    {
        $languages = sc_language_all();
        $currencies = sc_currency_all();
        $blocksContent = sc_block_content();
        $layoutsUrl = sc_link();
        $this->templatePath = 'templates.' . sc_store('template');
        $this->templateFile = 'templates/' . sc_store('template');
        view()->share('languages', $languages);
        view()->share('currencies', $currencies);
        view()->share('blocksContent', $blocksContent);
        view()->share('layoutsUrl', $layoutsUrl);
        view()->share('templatePath', $this->templatePath);
        view()->share('templateFile', $this->templateFile);

        //variable model
        view()->share('modelProduct', (new ShopProduct));
        view()->share('modelCategory', (new ShopCategory));
        view()->share('modelBanner', (new ShopBanner));
        view()->share('modelBrand', (new ShopBrand));
        view()->share('modelSupplier', (new ShopSupplier));
        view()->share('modelNews', (new ShopNews));
        view()->share('modelPage', (new ShopPage));
    }


    /**
     * Default page not found
     *
     * @return  [type]  [return description]
     */
    public function pageNotFound()
    {
        return view(
            $this->templatePath . '.notfound',
            [
            'title' => trans('front.page_not_found_title'),
            'msg' => trans('front.page_not_found'),
            'description' => '',
            'keyword' => ''
            ]
        );
    }

    /**
     * Default item not found
     *
     * @return  [view]
     */
    public function itemNotFound()
    {
        return view(
            $this->templatePath . '.notfound',
            [
                'title' => trans('front.item_not_found_title'),
                'msg' => trans('front.item_not_found'),
                'description' => '',
                'keyword' => '',
            ]
        );
    }

}
