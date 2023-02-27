<?php

namespace App\Pmo\Admin\Models;

use App\Pmo\Front\Models\ShopNews;
use Cache;
use App\Pmo\Front\Models\ShopNewsDescription;
use App\Pmo\Front\Models\ShopNewsStore;

class AdminNews extends ShopNews
{
    protected static $getListTitleAdmin = null;
    protected static $getListNewsGroupByParentAdmin = null;
    /**
     * Get news detail in admin
     *
     * @param   [type]  $id  [$id description]
     *
     * @return  [type]       [return description]
     */
    public static function getNewsAdmin($id, $storeId = null)
    {
        $data = self::where('id', $id);
        if ($storeId) {
            $tableNewsStore = (new ShopNewsStore)->getTable();
            $tableNews = (new ShopNews)->getTable();
            $data = $data->leftJoin($tableNewsStore, $tableNewsStore . '.news_id', $tableNews . '.id');
            $data = $data->where($tableNewsStore . '.store_id', $storeId);
        }
        $data = $data->first();
        return $data;
    }

    /**
     * Get list news in admin
     *
     * @param   [array]  $dataSearch  [$dataSearch description]
     *
     * @return  [type]               [return description]
     */
    public static function getNewsListAdmin(array $dataSearch, $storeId = null)
    {
        $keyword          = $dataSearch['keyword'] ?? '';
        $sort_order       = $dataSearch['sort_order'] ?? '';
        $arrSort          = $dataSearch['arrSort'] ?? '';
        $tableDescription = (new ShopNewsDescription)->getTable();
        $tableNews     = (new ShopNews)->getTable();

        $newsList = (new ShopNews)
            ->leftJoin($tableDescription, $tableDescription . '.news_id', $tableNews . '.id')
            ->where($tableDescription . '.lang', sc_get_locale());

        $tableNews = (new ShopNews)->getTable();
        if ($storeId) {
            $tableNewsStore = (new ShopNewsStore)->getTable();
            $newsList = $newsList->leftJoin($tableNewsStore, $tableNewsStore . '.news_id', $tableNews . '.id');
            $newsList = $newsList->where($tableNewsStore . '.store_id', $storeId);
        }

        if ($keyword) {
            $newsList = $newsList->where(function ($sql) use ($tableDescription, $keyword) {
                $sql->where($tableDescription . '.title', 'like', '%' . $keyword . '%');
            });
        }

        if ($sort_order && array_key_exists($sort_order, $arrSort)) {
            $field = explode('__', $sort_order)[0];
            $sort_field = explode('__', $sort_order)[1];
            $newsList = $newsList->orderBy($field, $sort_field);
        } else {
            $newsList = $newsList->orderBy($tableNews.'.created_at', 'desc');
        }
        $newsList = $newsList->paginate(20);

        return $newsList;
    }


    /**
     * Get array title news
     * user for admin
     *
     * @return  [type]  [return description]
     */
    public static function getListTitleAdmin($storeId = null)
    {
        $storeCache = $storeId ? $storeId : session('adminStoreId');
        $tableDescription = (new ShopNewsDescription)->getTable();
        $table = (new AdminNews)->getTable();
        if (sc_config_global('cache_status') && sc_config_global('cache_news')) {
            if (!Cache::has($storeCache.'_cache_news_'.sc_get_locale())) {
                if (self::$getListTitleAdmin === null) {
                    $data = self::join($tableDescription, $tableDescription.'.news_id', $table.'.id')
                    ->where('lang', sc_get_locale());
                    if ($storeId) {
                        $tableNewsStore = (new ShopNewsStore)->getTable();
                        $data = $data->leftJoin($tableNewsStore, $tableNewsStore . '.news_id', $table . '.id');
                        $data = $data->where($tableNewsStore . '.store_id', $storeId);
                    }
                    $data = $data->pluck('title', 'id')->toArray();
                    self::$getListTitleAdmin = $data;
                }
                sc_set_cache($storeCache.'_cache_news_'.sc_get_locale(), self::$getListTitleAdmin);
            }
            return Cache::get($storeCache.'_cache_news_'.sc_get_locale());
        } else {
            if (self::$getListTitleAdmin === null) {
                $data = self::join($tableDescription, $tableDescription.'.news_id', $table.'.id')
                ->where('lang', sc_get_locale());
                if ($storeId) {
                    $tableNewsStore = (new ShopNewsStore)->getTable();
                    $data = $data->leftJoin($tableNewsStore, $tableNewsStore . '.news_id', $table . '.id');
                    $data = $data->where($tableNewsStore . '.store_id', $storeId);
                }
                $data = $data->pluck('title', 'id')->toArray();
                self::$getListTitleAdmin = $data;
            }
            return self::$getListTitleAdmin;
        }
    }


    /**
     * Create a new news
     *
     * @param   array  $dataCreate  [$dataCreate description]
     *
     * @return  [type]              [return description]
     */
    public static function createNewsAdmin(array $dataCreate)
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
        return ShopNewsDescription::create($dataCreate);
    }

    /**
    * Get total news of system
    *
    * @return  [type]  [return description]
    */
    public static function getTotalNews()
    {
        return self::count();
    }
}
