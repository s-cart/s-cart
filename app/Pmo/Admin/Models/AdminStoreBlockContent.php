<?php

namespace App\Pmo\Admin\Models;

use App\Pmo\Front\Models\ShopStoreBlockContent;

class AdminStoreBlockContent extends ShopStoreBlockContent
{
    /**
     * Get blockContent detail in admin
     *
     * @param   [type]  $id  [$id description]
     *
     * @return  [type]       [return description]
     */
    public function getStoreBlockContentAdmin($id, $storeId = null)
    {
        $data  = $this->where('id', $id);
        if ($storeId) {
            $data = $data->where('store_id', $storeId);
        }
        return $data->first();
    }

    /**
     * Get list blockContent in admin
     *
     * @param   [array]  $dataSearch  [$dataSearch description]
     *
     * @return  [type]               [return description]
     */
    public function getStoreBlockContentListAdmin($storeId = null)
    {
        if ($storeId) {
            $data = $this->where('store_id', $storeId)
                ->orderBy('id', 'desc');
        } else {
            $data = $this->orderBy('id', 'desc');
        }
        return $data->paginate(20);
    }

    /**
     * Create a new blockContent
     *
     * @param   array  $dataInsert  [$dataInsert description]
     *
     * @return  [type]              [return description]
     */
    public static function createStoreBlockContentAdmin(array $dataCreate)
    {
        return self::create($dataCreate);
    }
}
