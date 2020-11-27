<?php

namespace App\Plugins\Cms\Content\Admin\Models;

use App\Plugins\Cms\Content\Models\CmsCategory;
use App\Plugins\Cms\Content\Models\CmsCategoryDescription;
use Cache;

class AdminCmsCategory extends CmsCategory
{
    protected static $getListTitleAdmin = null;
    protected static $getListCategoryGroupByParentAdmin = null;
    /**
     * Get category detail in admin
     *
     * @param   [type]  $id  [$id description]
     *
     * @return  [type]       [return description]
     */
    public static function getCategoryAdmin($id) {
        return self::where('id', $id)
        ->where('store_id', session('adminStoreId'))
        ->first();
    }

    /**
     * Get list category in admin
     *
     * @param   [array]  $dataSearch  [$dataSearch description]
     *
     * @return  [type]               [return description]
     */
    public function getCategoryListAdmin(array $dataSearch) {
        $keyword          = $dataSearch['keyword'] ?? '';
        $sort_order       = $dataSearch['sort_order'] ?? '';
        $arrSort          = $dataSearch['arrSort'] ?? '';
        $tableDescription = (new CmsCategoryDescription)->getTable();
        $tableCategory    = $this->getTable();

        $categoryList = (new CmsCategory)
            ->leftJoin($tableDescription, $tableDescription . '.category_id', $tableCategory . '.id')
            ->where('store_id', session('adminStoreId'))
            ->where($tableDescription . '.lang', sc_get_locale());

        if ($keyword) {
            $categoryList = $categoryList->where(function ($sql) use($tableDescription, $tableCategory, $keyword){
                $sql->where($tableDescription . '.title', 'like', '%' . $keyword . '%');
            });
        }

        if ($sort_order && array_key_exists($sort_order, $arrSort)) {
            $field = explode('__', $sort_order)[0];
            $sort_field = explode('__', $sort_order)[1];
            $categoryList = $categoryList->sort($field, $sort_field);
        } else {
            $categoryList = $categoryList->sort('id', 'desc');
        }
        $categoryList = $categoryList->paginate(20);

        return $categoryList;
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
        $lisCategory = $categories[$parent] ?? [];
        if ($lisCategory) {
            foreach ($lisCategory as $category) {
                $tree[$category['id']] = $st . $categoriesTitle[$category['id']]??'';
                if (!empty($categories[$category['id']])) {
                    $st .= '--';
                    $this->getTreeCategoriesAdmin($category['id'], $tree, $categories, $st);
                    $st = '';
                }
            }
        }
        return $tree;
    }

    /**
     * Get array title category
     * user for admin 
     *
     * @return  [type]  [return description]
     */
    public static function getListTitleAdmin()
    {
        $tableDescription = (new CmsCategoryDescription)->getTable();
        $table = (new AdminCmsCategory)->getTable();
        if (sc_config_global('cache_status') && sc_config_global('cache_category')) {
            if (!Cache::has(session('adminStoreId').'_cache_category_'.sc_get_locale())) {
                if (self::$getListTitleAdmin === null) {
                    self::$getListTitleAdmin = self::join($tableDescription, $tableDescription.'.category_id', $table.'.id')
                    ->where('lang', sc_get_locale())
                    ->where('store_id', session('adminStoreId'))
                    ->pluck('title', 'id')
                    ->toArray();
                }
                sc_set_cache(session('adminStoreId').'_cache_category_'.sc_get_locale(), self::$getListTitleAdmin);
            }
            return Cache::get(session('adminStoreId').'_cache_category_'.sc_get_locale());
        } else {
            if (self::$getListTitleAdmin === null) {
                self::$getListTitleAdmin = self::join($tableDescription, $tableDescription.'.category_id', $table.'.id')
                ->where('lang', sc_get_locale())
                ->where('store_id', session('adminStoreId'))
                ->pluck('title', 'id')
                ->toArray();
            }
            return self::$getListTitleAdmin;
        }
    }


    /**
     * Get array title category
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
     * Create a new category
     *
     * @param   array  $dataInsert  [$dataInsert description]
     *
     * @return  [type]              [return description]
     */
    public static function createCategoryAdmin(array $dataInsert) {

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

        return CmsCategoryDescription::create($dataInsert);
    }

    /**
     * [checkAliasValidationAdmin description]
     *
     * @param   [type]$type     [$type description]
     * @param   null  $fieldValue    [$field description]
     * @param   null  $categoryId      [$categoryId description]
     * @param   null  $storeId  [$storeId description]
     * @param   null            [ description]
     *
     * @return  [type]          [return description]
     */
    public function checkAliasValidationAdmin($type = null, $fieldValue = null, $categoryId = null, $storeId = null) {
        $storeId = $storeId ? $storeId : session('adminStoreId');
        $type = $type ? $type : 'alias';
        $fieldValue = $fieldValue;
        $categoryId = $categoryId;
        $tablePTS = (new AdminCmsCategory)->getTable();
        $check =  $this
            ->where($type, $fieldValue)
            ->where($tablePTS . '.store_id', $storeId);
        if($categoryId) {
            $check = $check->where('id', '<>', $categoryId);
        }
        $check = $check->first();

        if($check) {
            return false;
        } else {
            return true;
        }
    }

}
