<?php
namespace App\Http\Controllers;

use App\Http\Controllers\Controller;

class RootFrontController extends Controller
{
    public $templatePath;
    public $templateFile;
    public function __construct()
    {
        $this->templatePath = 'templates.' . sc_store('template');
        $this->templateFile = 'templates/' . sc_store('template');
    }


    /**
     * Default page not found
     *
     * @return  [type]  [return description]
     */
    public function pageNotFound()
    {
        sc_check_view( $this->templatePath . '.notfound');
        return view(
             $this->templatePath . '.notfound',
            [
            'title' => sc_language_render('front.page_not_found_title'),
            'msg' => sc_language_render('front.page_not_found'),
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
        sc_check_view( $this->templatePath . '.notfound');
        return view(
             $this->templatePath . '.notfound',
            [
                'title' => sc_language_render('front.data_not_found_title'),
                'msg' => sc_language_render('front.data_not_found'),
                'description' => '',
                'keyword' => '',
            ]
        );
    }
}
