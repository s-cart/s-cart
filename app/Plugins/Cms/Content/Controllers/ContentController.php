<?php
#App\Plugins\Cms\Content\Controllers\ContentController.php
namespace App\Plugins\Cms\Content\Controllers;

use App\Plugins\Cms\Content\Models\CmsCategory;
use App\Plugins\Cms\Content\Models\CmsContent;
use App\Http\Controllers\RootAdminController;
use App\Plugins\Cms\Content\AppConfig;

class ContentController extends RootAdminController
{
    public $plugin;
    public function __construct()
    {
        parent::__construct();
        $this->plugin = new AppConfig;
    }

    /**
     * Process front all products
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
                        'title' => $category_currently['title'],
                        'description' => $category_currently['description'],
                        'keyword' => $category_currently['keyword'],
                        'entries' => $entries,
                        'layout_page' => 'content_list',
                    )
                );
            } else {
                return view('templates.' . sc_store('template') . '.notfound',
                    array(
                        'title' => trans('front.item_not_found_title'),
                        'description' => '',
                        'keyword' => sc_store('keyword'),
                        'msg' => trans('front.item_not_found'),
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
            $title = ($entry_currently) ? $entry_currently->title : trans('front.not_found');
            return view($this->plugin->pathPlugin.'::cms_entry_detail',
                array(
                    'title' => $title,
                    'entry_currently' => $entry_currently,
                    'description' => $entry_currently['description'],
                    'keyword' => $entry_currently['keyword'],
                    'og_image' => $entry_currently->getImage(),
                    'layout_page' => 'content_detail',
                )
            );
        } else {
            return view('templates.' . sc_store('template') . '.notfound',
                array(
                    'title' => trans('front.item_not_found_title'),
                    'description' => '',
                    'keyword' => sc_store('keyword'),
                    'msg' => trans('front.item_not_found'),
                )
            );
        }

    }
}
