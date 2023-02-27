<?php
namespace App\Pmo\Front\Controllers;

use App\Pmo\Front\Controllers\RootFrontController;
use App\Pmo\Front\Models\ShopBanner;
use App\Pmo\Front\Models\ShopNews;
use App\Pmo\Front\Models\ShopPage;
use App\Pmo\Front\Models\ShopSubscribe;
use Illuminate\Http\Request;

class ShopContentController extends RootFrontController
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
        $viewHome = $this->templatePath . '.screen.home';
        $layoutPage = 'home';
        sc_check_view($viewHome);
        return view(
            $viewHome,
            array(
                'title'       => sc_store('title'),
                'keyword'     => sc_store('keyword'),
                'description' => sc_store('description'),
                'storeId'     => config('app.storeId'),
                'layout_page' => $layoutPage,
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
        return ;
    }

    /**
     * Process click banner
     *
     * @param   [int]  $id
     *
     */
    public function clickBanner($id = 0)
    {
        $banner = ShopBanner::find($id);
        if ($banner) {
            $banner->click +=1;
            $banner->save();
            return redirect(url($banner->url??'/'));
        }
        return redirect(url('/'));
    }

    /**
     * Process front form contact page
     *
     * @param [type] ...$params
     * @return void
     */
    public function getContactProcessFront(...$params)
    {
        if (config('app.seoLang')) {
            $lang = $params[0] ?? '';
            sc_lang_switch($lang);
        }
        return $this->_getContact();
    }

    /**
     * form contact
     * @return [view]
     */
    private function _getContact()
    {
        $viewCaptcha = '';
        if (sc_captcha_method() && in_array('contact', sc_captcha_page())) {
            if (view()->exists(sc_captcha_method()->pathPlugin.'::render')) {
                $dataView = [
                    'titleButton' => sc_language_render('action.submit'),
                    'idForm' => 'sc_form-process',
                    'idButtonForm' => 'sc_button-form-process',
                ];
                $viewCaptcha = view(sc_captcha_method()->pathPlugin.'::render', $dataView)->render();
            }
        }
        sc_check_view($this->templatePath . '.screen.shop_contact');
        return view(
            $this->templatePath . '.screen.shop_contact',
            array(
                'title'       => sc_language_render('contact.page_title'),
                'description' => '',
                'keyword'     => '',
                'layout_page' => 'shop_contact',
                'og_image'    => '',
                'viewCaptcha' => $viewCaptcha,
                'breadcrumbs' => [
                    ['url'    => '', 'title' => sc_language_render('contact.page_title')],
                ],
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
        $data   = $request->all();

        $dataMap = sc_contact_mapping_validate();
        $validate = $dataMap['validate'];
        $messages = $dataMap['messages'];
        if (sc_captcha_method() && in_array('contact', sc_captcha_page())) {
            $data['captcha_field'] = $data[sc_captcha_method()->getField()] ?? '';
            $validate['captcha_field'] = ['required', 'string', new \App\Pmo\Rules\CaptchaRule];
        }
        $validator = \Illuminate\Support\Facades\Validator::make($data, $validate, $messages);
        if ($validator->fails()) {
            return redirect()->back()
                        ->withErrors($validator)
                        ->withInput();
        }
        // Process escape
        $data = sc_clean($data);
        
        //Send email
        $data['content'] = str_replace("\n", "<br>", $data['content']);
        sc_contact_form_sendmail($data);

        return redirect(sc_route('contact'))
            ->with('success', sc_language_render('contact.thank_contact'));
    }

    /**
     * Process front form page detail
     *
     * @param [type] ...$params
     * @return void
     */
    public function pageDetailProcessFront(...$params)
    {
        if (config('app.seoLang')) {
            $lang = $params[0] ?? '';
            $alias = $params[1] ?? '';
            sc_lang_switch($lang);
        } else {
            $alias = $params[0] ?? '';
        }
        return $this->_pageDetail($alias);
    }

    /**
     * Render page
     * @param  [string] $alias
     */
    private function _pageDetail($alias)
    {
        $page = (new ShopPage)->getDetail($alias, $type = 'alias');
        if ($page) {
            sc_check_view($this->templatePath . '.screen.shop_page');
            return view(
                $this->templatePath . '.screen.shop_page',
                array(
                    'title'       => $page->title,
                    'description' => $page->description,
                    'keyword'     => $page->keyword,
                    'page'        => $page,
                    'og_image'    => sc_file($page->getImage()),
                    'layout_page' => 'shop_page',
                    'breadcrumbs' => [
                        ['url'    => '', 'title' => $page->title],
                    ],
                )
            );
        } else {
            return $this->pageNotFound();
        }
    }

    /**
     * Process front news
     *
     * @param [type] ...$params
     * @return void
     */
    public function newsProcessFront(...$params)
    {
        if (config('app.seoLang')) {
            $lang = $params[0] ?? '';
            sc_lang_switch($lang);
        }
        return $this->_news();
    }

    /**
     * Render news
     * @return [type] [description]
     */
    private function _news()
    {
        $news = (new ShopNews)
            ->setLimit(sc_config('news_list'))
            ->setPaginate()
            ->getData();

        sc_check_view($this->templatePath . '.screen.shop_news');
        return view(
            $this->templatePath . '.screen.shop_news',
            array(
                'title'       => sc_language_render('front.blog'),
                'description' => sc_store('description'),
                'keyword'     => sc_store('keyword'),
                'news'        => $news,
                'layout_page' => 'shop_news',
                'breadcrumbs' => [
                    ['url'    => '', 'title' => sc_language_render('front.blog')],
                ],
            )
        );
    }

    /**
     * Process front news detail
     *
     * @param [type] ...$params
     * @return void
     */
    public function newsDetailProcessFront(...$params)
    {
        if (config('app.seoLang')) {
            $lang = $params[0] ?? '';
            $alias = $params[1] ?? '';
            sc_lang_switch($lang);
        } else {
            $alias = $params[0] ?? '';
        }
        return $this->_newsDetail($alias);
    }

    /**
     * News detail
     *
     * @param   [string]  $alias
     *
     * @return  view
     */
    private function _newsDetail($alias)
    {
        $news = (new ShopNews)->getDetail($alias, $type ='alias');
        if ($news) {
            sc_check_view($this->templatePath . '.screen.shop_news_detail');
            return view(
                $this->templatePath . '.screen.shop_news_detail',
                array(
                    'title'       => $news->title,
                    'news'        => $news,
                    'description' => $news->description,
                    'keyword'     => $news->keyword,
                    'og_image'    => sc_file($news->getImage()),
                    'layout_page' => 'shop_news_detail',
                    'breadcrumbs' => [
                        ['url'    => sc_route('news'), 'title' => sc_language_render('front.blog')],
                        ['url'    => '', 'title' => $news->title],
                    ],
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
            'email.required' => sc_language_render('validation.required'),
            'email.email'    => sc_language_render('validation.email'),
        ]);
        $data       = $request->all();
        $checkEmail = ShopSubscribe::where('email', $data['subscribe_email'])
            ->where('store_id', config('app.storeId'))
            ->first();
        if (!$checkEmail) {
            ShopSubscribe::create(['email' => $data['subscribe_email'], 'store_id' => config('app.storeId')]);
        }
        return redirect()->back()
            ->with(['success' => sc_language_render('subscribe.subscribe_success')]);
    }


    /**
     * Process front form about page
     *
     * @param [type] ...$params
     * @return void
     */
    public function getAboutProcessFront(...$params)
    {
        if (config('app.seoLang')) {
            $lang = $params[0] ?? '';
            sc_lang_switch($lang);
        }
        return $this->_getAbout();
    }

    /**
     * form about
     * @return [view]
     */
    private function _getAbout()
    {
        sc_check_view($this->templatePath . '.screen.shop_about');
        $page = (new ShopPage)->getDetail('about', $type = 'alias');
        if ($page) {
            $title = $page->title;
            $description = $page->description;
            $keyword = $page->keyword;
            $og_image = sc_file($page->getImage());
        } else {
            $title = sc_language_render('front.about');
            $description = '';
            $keyword = '';
            $og_image = '';
        }
        return view(
            $this->templatePath . '.screen.shop_about',
            array(
                'title'       => $title,
                'description' => $description,
                'keyword'     => $keyword,
                'layout_page' => 'shop_about',
                'og_image'    => $og_image,
                'page'        => $page,
                'breadcrumbs' => [
                    ['url'    => '', 'title' => $title],
                ],
            )
        );
    }

}
