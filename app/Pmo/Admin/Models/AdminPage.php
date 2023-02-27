<?php

namespace App\Pmo\Admin\Models;

use App\Pmo\Front\Models\ShopPage;
use Cache;
use App\Pmo\Front\Models\ShopPageDescription;
use App\Pmo\Front\Models\ShopPageStore;

class AdminPage extends ShopPage
{
    protected static $getListTitleAdmin = null;
    protected static $getListPageGroupByParentAdmin = null;
    /**
     * Get page detail in admin
     *
     * @param   [type]  $id  [$id description]
     *
     * @return  [type]       [return description]
     */
    public static function getPageAdmin($id, $storeId = null)
    {
        $data = self::where('id', $id);
        if ($storeId) {
            $tablePageStore = (new ShopPageStore)->getTable();
            $tablePage = (new ShopPage)->getTable();
            $data = $data->leftJoin($tablePageStore, $tablePageStore . '.page_id', $tablePage . '.id');
            $data = $data->where($tablePageStore . '.store_id', $storeId);
        }
        $data = $data->first();
        return $data;
    }

    /**
     * Get list page in admin
     *
     * @param   [array]  $dataSearch  [$dataSearch description]
     *
     * @return  [type]               [return description]
     */
    public static function getPageListAdmin(array $dataSearch, $storeId = null)
    {
        $keyword          = $dataSearch['keyword'] ?? '';
        $sort_order       = $dataSearch['sort_order'] ?? '';
        $arrSort          = $dataSearch['arrSort'] ?? '';
        $tableDescription = (new ShopPageDescription)->getTable();
        $tablePage     = (new AdminPage)->getTable();

        $pageList = (new ShopPage)
            ->leftJoin($tableDescription, $tableDescription . '.page_id', $tablePage . '.id')
            ->where($tableDescription . '.lang', sc_get_locale());

        $tablePage = (new ShopPage)->getTable();
        if ($storeId) {
            $tablePageStore = (new ShopPageStore)->getTable();
            $pageList = $pageList->leftJoin($tablePageStore, $tablePageStore . '.page_id', $tablePage . '.id');
            $pageList = $pageList->where($tablePageStore . '.store_id', $storeId);
        }

        if ($keyword) {
            $pageList = $pageList->where(function ($sql) use ($tableDescription, $keyword) {
                $sql->where($tableDescription . '.title', 'like', '%' . $keyword . '%');
            });
        }

        if ($sort_order && array_key_exists($sort_order, $arrSort)) {
            $field = explode('__', $sort_order)[0];
            $sort_field = explode('__', $sort_order)[1];
            $pageList = $pageList->orderBy($field, $sort_field);
        } else {
            $pageList = $pageList->orderBy($tablePage.'.created_at', 'desc');
        }
        $pageList = $pageList->paginate(20);

        return $pageList;
    }


    /**
     * Get array title page
     * user for admin
     *
     * @return  [type]  [return description]
     */
    public static function getListTitleAdmin($storeId = null)
    {
        $storeCache = $storeId ? $storeId : session('adminStoreId');
        $tableDescription = (new ShopPageDescription)->getTable();
        $table = (new AdminPage)->getTable();
        if (sc_config_global('cache_status') && sc_config_global('cache_page')) {
            if (!Cache::has($storeCache.'_cache_page_'.sc_get_locale())) {
                if (self::$getListTitleAdmin === null) {
                    $data = self::join($tableDescription, $tableDescription.'.page_id', $table.'.id')
                    ->where('lang', sc_get_locale());
                    if ($storeId) {
                        $tablePageStore = (new ShopPageStore)->getTable();
                        $data = $data->leftJoin($tablePageStore, $tablePageStore . '.page_id', $table . '.id');
                        $data = $data->where($tablePageStore . '.store_id', $storeId);
                    }
                    $data = $data->pluck('title', 'id')->toArray();
                    self::$getListTitleAdmin = $data;
                }
                sc_set_cache($storeCache.'_cache_page_'.sc_get_locale(), self::$getListTitleAdmin);
            }
            return Cache::get($storeCache.'_cache_page_'.sc_get_locale());
        } else {
            if (self::$getListTitleAdmin === null) {
                $data = self::join($tableDescription, $tableDescription.'.page_id', $table.'.id')
                ->where('lang', sc_get_locale());
                if ($storeId) {
                    $tablePageStore = (new ShopPageStore)->getTable();
                    $data = $data->leftJoin($tablePageStore, $tablePageStore . '.page_id', $table . '.id');
                    $data = $data->where($tablePageStore . '.store_id', $storeId);
                }
                $data = $data->pluck('title', 'id')->toArray();
                self::$getListTitleAdmin = $data;
            }
            return self::$getListTitleAdmin;
        }
    }


    /**
     * Create a new page
     *
     * @param   array  $dataCreate  [$dataCreate description]
     *
     * @return  [type]              [return description]
     */
    public static function createPageAdmin(array $dataCreate)
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
        return ShopPageDescription::create($dataCreate);
    }

    /**
     * [getListPageAlias description]
     *
     * @param   [type]  $storeId  [$storeId description]
     *
     * @return  array             [return description]
     */
    public function getListPageAlias($storeId = null):array 
    {
        $storeId = $storeId ? $storeId : session('adminStoreId');
        $arrReturn = [];
        $tablePage = $this->getTable();
        $tablePageStore = (new ShopPageStore)->getTable();
        $data = $this;
        if ($storeId) {
            $data = $this->leftJoin($tablePageStore, $tablePageStore . '.page_id', $tablePage . '.id');
            $data = $data->where($tablePageStore . '.store_id', $storeId);
        }
        $arrReturn = $data->pluck('alias')->toArray();
        return $arrReturn;
    }
}
