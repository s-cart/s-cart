<?php

namespace App\Plugins\Cms\Content\Admin\Models;

use App\Plugins\Cms\Content\Models\CmsContent;
use App\Plugins\Cms\Content\Models\CmsContentDescription;
use Cache;

class AdminCmsContent extends CmsContent
{
    protected static $getListTitleAdmin = null;
    protected static $getListContentGroupByParentAdmin = null;
    /**
     * Get content detail in admin
     *
     * @param   [type]  $id  [$id description]
     *
     * @return  [type]       [return description]
     */
    public static function getContentAdmin($id) {
        return self::where('id', $id)
        ->where('store_id', session('adminStoreId'))
        ->first();
    }

    /**
     * Get list content in admin
     *
     * @param   [array]  $dataSearch  [$dataSearch description]
     *
     * @return  [type]               [return description]
     */
    public function getContentListAdmin(array $dataSearch) {
        $keyword          = $dataSearch['keyword'] ?? '';
        $sort_order       = $dataSearch['sort_order'] ?? '';
        $arrSort          = $dataSearch['arrSort'] ?? '';
        $tableDescription = (new CmsContentDescription)->getTable();
        $tableContent    = $this->getTable();

        $contentList = (new CmsContent)
            ->leftJoin($tableDescription, $tableDescription . '.content_id', $tableContent . '.id')
            ->where('store_id', session('adminStoreId'))
            ->where($tableDescription . '.lang', sc_get_locale());

        if ($keyword) {
            $contentList = $contentList->where(function ($sql) use($tableDescription, $keyword){
                $sql->where($tableDescription . '.title', 'like', '%' . $keyword . '%');
            });
        }

        if ($sort_order && array_key_exists($sort_order, $arrSort)) {
            $field = explode('__', $sort_order)[0];
            $sort_field = explode('__', $sort_order)[1];
            $contentList = $contentList->sort($field, $sort_field);
        } else {
            $contentList = $contentList->sort('id', 'desc');
        }
        $contentList = $contentList->paginate(20);

        return $contentList;
    }

    /**
     * Get tree categories
     *
     * @param   [type]  $parent      [$parent description]
     * @param   [type]  &$tree       [&$tree description]
     * @param   [type]  $categories  [$categories description]
     * @param   [type]  &$st         [&$st description]
     *
     * @return  [type]               [return description]
     */
    public function getTreeCategoriesAdmin($parent = 0, &$tree = [], $categories = null, &$st = '')
    {
        $categories = $categories ?? $this->getListCategoryGroupByParentAdmin();
        $categoriesTitle =  $this->getListTitleAdmin();
        $tree = $tree ?? [];
        $lisContent = $categories[$parent] ?? [];
        if ($lisContent) {
            foreach ($lisContent as $content) {
                $tree[$content['id']] = $st . $categoriesTitle[$content['id']]??'';
                if (!empty($categories[$content['id']])) {
                    $st .= '--';
                    $this->getTreeCategoriesAdmin($content['id'], $tree, $categories, $st);
                    $st = '';
                }
            }
        }
        return $tree;
    }

    /**
     * Get array title content
     * user for admin 
     *
     * @return  [type]  [return description]
     */
    public static function getListTitleAdmin()
    {
        $tableDescription = (new CmsContentDescription)->getTable();
        $table = (new AdminCmsContent)->getTable();
        if (sc_config_global('cache_status') && sc_config_global('cache_content')) {
            if (!Cache::has(session('adminStoreId').'_cache_content_'.sc_get_locale())) {
                if (self::$getListTitleAdmin === null) {
                    self::$getListTitleAdmin = self::join($tableDescription, $tableDescription.'.content_id', $table.'.id')
                    ->where('lang', sc_get_locale())
                    ->where('store_id', session('adminStoreId'))
                    ->pluck('title', 'id')
                    ->toArray();
                }
                sc_set_cache(session('adminStoreId').'_cache_content_'.sc_get_locale(), self::$getListTitleAdmin);
            }
            return Cache::get(session('adminStoreId').'_cache_content_'.sc_get_locale());
        } else {
            if (self::$getListTitleAdmin === null) {
                self::$getListTitleAdmin = self::join($tableDescription, $tableDescription.'.content_id', $table.'.id')
                ->where('lang', sc_get_locale())
                ->where('store_id', session('adminStoreId'))
                ->pluck('title', 'id')
                ->toArray();
            }
            return self::$getListTitleAdmin;
        }
    }


    /**
     * Get array title content
     * user for admin 
     *
     * @return  [type]  [return description]
     */
    public static function getListCategoryGroupByParentAdmin()
    {
        if (self::$getListCategoryGroupByParentAdmin === null) {
            self::$getListCategoryGroupByParentAdmin = self::select('id', 'parent')
            ->where('store_id', session('adminStoreId'))
            ->get()
            ->groupBy('parent')
            ->toArray();
        }
        return self::$getListCategoryGroupByParentAdmin;
    }


    /**
     * Create a new content
     *
     * @param   array  $dataInsert  [$dataInsert description]
     *
     * @return  [type]              [return description]
     */
    public static function createContentAdmin(array $dataInsert) {

        return self::create($dataInsert);
    }


    /**
     * Insert data description
     *
     * @param   array  $dataInsert  [$dataInsert description]
     *
     * @return  [type]              [return description]
     */
    public static function insertDescriptionAdmin(array $dataInsert) {

        return CmsContentDescription::create($dataInsert);
    }

    /**
     * [checkAliasValidationAdmin description]
     *
     * @param   [type]$type     [$type description]
     * @param   null  $fieldValue    [$field description]
     * @param   null  $contentId      [$contentId description]
     * @param   null  $storeId  [$storeId description]
     * @param   null            [ description]
     *
     * @return  [type]          [return description]
     */
    public function checkAliasValidationAdmin($type = null, $fieldValue = null, $contentId = null, $storeId = null) {
        $storeId = $storeId ? $storeId : session('adminStoreId');
        $type = $type ? $type : 'alias';
        $fieldValue = $fieldValue;
        $contentId = $contentId;
        $tablePTS = (new AdminCmsContent)->getTable();
        $check =  $this
        ->where($type, $fieldValue)
        ->where($tablePTS . '.store_id', $storeId);
        if($contentId) {
            $check = $check->where('id', '<>', $contentId);
        }
        $check = $check->first();

        if($check) {
            return false;
        } else {
            return true;
        }
    }

}
