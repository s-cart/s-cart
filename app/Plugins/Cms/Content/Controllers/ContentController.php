<?php
#App\Plugins\Cms\Content\Controllers\ContentController.php
namespace App\Plugins\Cms\Content\Controllers;

use App\Plugins\Cms\Content\Models\CmsCategory;
use App\Plugins\Cms\Content\Models\CmsContent;
use App\Http\Controllers\RootFrontController;
use App\Plugins\Cms\Content\AppConfig;

class ContentController extends RootFrontController
{
    public $plugin;
    public function __construct()
    {
        parent::__construct();
        $this->plugin = new AppConfig;
    }

    /**
     * Process cms front
     *
     * @param [type] ...$params
     * @return void
     */
    public function cmsProcessFront(...$params) 
    {
        if (config('app.seoLang')) {
            $lang = $params[0] ?? '';
            sc_lang_switch($lang);
        }
        return $this->_cms();
    }

    /**
     * Cms 
     * @return [type] [description]
     */
    private function _cms()
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

        $itemsList = (new CmsCategory)
            ->getCategoryRoot()
            ->setSort([$sortBy, $sortOrder])
            ->setPaginate()
            ->setLimit(sc_config('item_list'))
            ->getData();

        sc_check_view($this->templatePath . '.screen.shop_item_list');
        return view(
            $this->templatePath . '.screen.shop_item_list',
            array(
                'title'       => sc_language_render('front.categories'),
                'itemsList'   => $itemsList,
                'keyword'     => '',
                'description' => '',
                'layout_page' => 'shop_item_list',
                'filter_sort' => $filter_sort,
                'breadcrumbs' => [
                    ['url'    => '', 'title' => sc_language_render('front.categories')],
                ],
            )
        );
    }


    /**
     * Process front category
     *
     * @param [type] ...$params
     * @return void
     */
    public function categoryProcessFront(...$params) 
    {
        if (config('app.seoLang')) {
            $lang = $params[0] ?? '';
            $alias = $params[1] ?? '';
            sc_lang_switch($lang);
        } else {
            $alias = $params[0] ?? '';
        }
        return $this->_category($alias);
    }

    /**
     * Category cms
     * @return [type] [description]
     */
    private function _category($alias)
    {
        $category_currently = (new CmsCategory)->getDetail($alias, 'alias');
            if ($category_currently) { 
                $entries = (new CmsContent)
                    ->getContentToCategory($category_currently->id)
                    ->setPaginate()
                    ->getData();
                return view(
                    $this->plugin->pathPlugin.'::cms_category',
                    array(
                        'title'       => $category_currently['title'],
                        'description' => $category_currently['description'],
                        'keyword'     => $category_currently['keyword'],
                        'entries'     => $entries,
                        'layout_page' => 'content_list',
                        'breadcrumbs' => [
                            ['url'    => sc_route('cms.index'), 'title' => sc_language_render('front.categories')],
                            ['url'    => '', 'title' => $category_currently['title']],
                        ],
                    )
                );
            } else {
                return view('templates.' . sc_store('template') . '.notfound',
                    array(
                        'title'       => sc_language_render('front.data_not_found'),
                        'description' => '',
                        'keyword'     => '',
                        'msg'         => sc_language_render('front.data_not_found'),
                    )
                );
            }
    }

    /**
     * Process front Content detail
     *
     * @param [type] ...$params
     * @return void
     */
    public function contentProcessFront(...$params) 
    {
        if (config('app.seoLang')) {
            $lang = $params[0] ?? '';
            $alias = $params[1] ?? '';
            sc_lang_switch($lang);
        } else {
            $alias = $params[0] ?? '';
        }
        return $this->_content($alias);
    }

    /**
     * Content detail
     *
     * @param   [string]  $alias  [$alias description]
     *
     * @return  [type]          [return description]
     */
    private function _content($alias)
    {
        $entry_currently = (new CmsContent)->getDetail($alias, 'alias');
        if ($entry_currently) {
            $title = ($entry_currently) ? $entry_currently->title : sc_language_render('front.not_found');
            return view($this->plugin->pathPlugin.'::cms_entry_detail',
                array(
                    'title'           => $title,
                    'entry_currently' => $entry_currently,
                    'description'     => $entry_currently['description'],
                    'keyword'         => $entry_currently['keyword'],
                    'og_image'        => $entry_currently->getImage(),
                    'layout_page'     => 'content_detail',
                    'breadcrumbs'     => [
                        ['url'        => $entry_currently->category->getUrl(), 'title' => $entry_currently->category->getFull()->title],
                        ['url'        => '', 'title' => $title],
                    ],
                )
            );
        } else {
            return view('templates.' . sc_store('template') . '.notfound',
                array(
                    'title'       => sc_language_render('front.data_not_found'),
                    'description' => '',
                    'keyword'     => '',
                    'msg'         => sc_language_render('front.data_not_found'),
                )
            );
        }

    }
}
