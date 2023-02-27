<?php

namespace App\Pmo\Admin\Models;

use App\Pmo\Front\Models\ShopCategory;
use Cache;
use App\Pmo\Front\Models\ShopCategoryDescription;

class AdminCategory extends ShopCategory
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
    public static function getCategoryAdmin($id)
    {
        return self::where('id', $id)
        ->first();
    }

    /**
     * Get list category in admin
     *
     * @param   [array]  $dataSearch  [$dataSearch description]
     *
     * @return  [type]               [return description]
     */
    public static function getCategoryListAdmin(array $dataSearch)
    {
        $keyword          = $dataSearch['keyword'] ?? '';
        $sort_order       = $dataSearch['sort_order'] ?? '';
        $arrSort          = $dataSearch['arrSort'] ?? '';
        $tableDescription = (new ShopCategoryDescription)->getTable();
        $tableCategory     = (new ShopCategory)->getTable();

        $categoryList = (new ShopCategory)
            ->leftJoin($tableDescription, $tableDescription . '.category_id', $tableCategory . '.id')
            ->where($tableDescription . '.lang', sc_get_locale());
        if ($keyword) {
            $categoryList = $categoryList->where(function ($sql) use ($tableDescription, $keyword) {
                $sql->where($tableDescription . '.title', 'like', '%' . $keyword . '%');
            });
        }

        if ($sort_order && array_key_exists($sort_order, $arrSort)) {
            $field = explode('__', $sort_order)[0];
            $sort_field = explode('__', $sort_order)[1];
            $categoryList = $categoryList->sort($field, $sort_field);
        } else {
            $categoryList = $categoryList->sort('created_at', 'desc');
        }
        $categoryList->groupBy($tableCategory.'.id');

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
                $tree[$category['id']] = $st . ($categoriesTitle[$category['id']]??'');
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
        $storeCache = session('adminStoreId');
        $tableDescription = (new ShopCategoryDescription)->getTable();
        $table = (new AdminCategory)->getTable();
        if (sc_config_global('cache_status') && sc_config_global('cache_category')) {
            if (!Cache::has($storeCache.'_cache_category_'.sc_get_locale())) {
                if (self::$getListTitleAdmin === null) {
                    self::$getListTitleAdmin = self::join($tableDescription, $tableDescription.'.category_id', $table.'.id')
                    ->where('lang', sc_get_locale())
                    ->pluck('title', 'id')
                    ->toArray();
                }
                sc_set_cache($storeCache.'_cache_category_'.sc_get_locale(), self::$getListTitleAdmin);
            }
            return Cache::get($storeCache.'_cache_category_'.sc_get_locale());
        } else {
            if (self::$getListTitleAdmin === null) {
                self::$getListTitleAdmin = self::join($tableDescription, $tableDescription.'.category_id', $table.'.id')
                ->where('lang', sc_get_locale())
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
            ->get()
            ->groupBy('parent')
            ->toArray();
        }
        return self::$getListCategoryGroupByParentAdmin;
    }


    /**
     * Create a new category
     *
     * @param   array  $dataCreate  [$dataCreate description]
     *
     * @return  [type]              [return description]
     */
    public static function createCategoryAdmin(array $dataCreate)
    {
        return self::create($dataCreate);
    }


    /**
     * Insert data description
     *
     * @param   array  $dataCreate  [$dataCreate description]
     *
     * @return  [type]              [return description]
     */
    public static function insertDescriptionAdmin(array $dataCreate)
    {
        return ShopCategoryDescription::create($dataCreate);
    }
}
