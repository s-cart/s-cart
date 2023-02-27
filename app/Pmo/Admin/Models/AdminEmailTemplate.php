<?php

namespace App\Pmo\Admin\Models;

use App\Pmo\Front\Models\ShopEmailTemplate;

class AdminEmailTemplate extends ShopEmailTemplate
{
    protected static $getListTitleAdmin = null;
    protected static $getListEmailTemplateGroupByParentAdmin = null;
    /**
     * Get news detail in admin
     *
     * @param   [type]  $id  [$id description]
     *
     * @return  [type]       [return description]
     */
    public static function getEmailTemplateAdmin($id)
    {
        return self::where('id', $id)
        ->where('store_id', session('adminStoreId'))
        ->first();
    }

    /**
     * Get list news in admin
     *
     * @param   [array]  $dataSearch  [$dataSearch description]
     *
     * @return  [type]               [return description]
     */
    public static function getEmailTemplateListAdmin(array $dataSearch)
    {
        $keyword          = $dataSearch['keyword'] ?? '';
        $sort_order       = $dataSearch['sort_order'] ?? '';
        $arrSort          = $dataSearch['arrSort'] ?? '';

        $newsList = (new ShopEmailTemplate)
            ->where('store_id', session('adminStoreId'));

        if ($keyword) {
            $newsList = $newsList->where(function ($sql) {
                $sql->where('name', 'like', '%' . $keyword . '%');
            });
        }

        if ($sort_order && array_key_exists($sort_order, $arrSort)) {
            $field = explode('__', $sort_order)[0];
            $sort_field = explode('__', $sort_order)[1];
            $newsList = $newsList->orderBy($field, $sort_field);
        } else {
            $newsList = $newsList->orderBy('id', 'desc');
        }
        $newsList = $newsList->paginate(20);

        return $newsList;
    }

    /**
     * Create a new news
     *
     * @param   array  $dataCreate  [$dataCreate description]
     *
     * @return  [type]              [return description]
     */
    public static function createEmailTemplateAdmin(array $dataCreate)
    {
        return self::create($dataCreate);
    }
}
