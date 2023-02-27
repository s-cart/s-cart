<?php

use App\Pmo\Front\Models\ShopProduct;
use App\Pmo\Front\Models\ShopProductStore;
use App\Pmo\Front\Models\ShopProductDescription;

if (!function_exists('sc_product_admin_select_list') && !in_array('sc_get_plugin_captcha_installed', config('helper_except', []))) {
    /**
     * Get list product select use in admin page
     *
     * @param   [string]  $domain
     *
     * @return  [string]         [$domain]
     */
    function sc_product_admin_select_list(array $dataFilter = [], $storeId = null)
    {
        $keyword          = $dataFilter['keyword'] ?? '';
        $limit            = $dataFilter['limit'] ?? '';
        $kind             = $dataFilter['kind'] ?? [];
        $tableDescription = (new ShopProductDescription)->getTable();
        $tableProduct     = (new ShopProduct)->getTable();
        $tableProductStore = (new ShopProductStore)->getTable();
        $colSelect = [
            'id',
            'sku',
             $tableDescription . '.name'
        ];
        $productList = (new ShopProduct)->select($colSelect)
            ->leftJoin($tableDescription, $tableDescription . '.product_id', $tableProduct . '.id')
            ->leftJoin($tableProductStore, $tableProductStore . '.product_id', $tableProduct . '.id')
            ->where($tableDescription . '.lang', sc_get_locale());

        if ($storeId) {
            // Only get products of store if store <> root or store is specified
            $productList = $productList->where($tableProductStore . '.store_id', $storeId);
        }

        if (is_array($kind) && $kind) {
            $productList = $productList->whereIn('kind', $kind);
        }
        if ($keyword) {
            $productList = $productList->where(function ($sql) use ($tableDescription, $tableProduct, $keyword) {
                $sql->where($tableDescription . '.name', 'like', '%' . $keyword . '%')
                    ->orWhere($tableProduct . '.sku', 'like', '%' . $keyword . '%');
            });
        }

        if ($limit) {
            $productList = $productList->limit($limit);
        }
        $productList->groupBy($tableProduct.'.id');
        $dataTmp = $productList->get()->keyBy('id');
        $data = [];
        foreach ($dataTmp as $key => $row) {
            $data[$key] = [
                'id' => $row['id'],
                'sku' => $row['sku'],
                'name' => addslashes($row['name']),
            ];
        }
        return $data;
    }
}