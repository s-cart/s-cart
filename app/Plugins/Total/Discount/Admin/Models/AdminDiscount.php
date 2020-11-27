<?php
#App\Plugins\Total\Discount\Admin\Models\AdminDiscount.php
namespace App\Plugins\Total\Discount\Admin\Models;

use App\Plugins\Total\Discount\Models\PluginModel;
class AdminDiscount extends PluginModel
{
    /**
     * Get discount detail in admin
     *
     * @param   [type]  $id  [$id description]
     *
     * @return  [type]       [return description]
     */
    public static function getDiscountAdmin($id) {
        return self::where('id', $id)
        ->where('store_id', session('adminStoreId'))
        ->first();
    }

    /**
     * Get list discount in admin
     *
     * @param   [array]  $dataSearch  [$dataSearch description]
     *
     * @return  [type]               [return description]
     */
    public function getDiscountListAdmin(array $dataSearch) {
        $sort_order       = $dataSearch['sort_order'] ?? '';
        $arrSort          = $dataSearch['arrSort'] ?? '';
        $discountList = (new AdminDiscount)
            ->where('store_id', session('adminStoreId'));

        if ($sort_order && array_key_exists($sort_order, $arrSort)) {
            $field = explode('__', $sort_order)[0];
            $sort_field = explode('__', $sort_order)[1];
            $discountList = $discountList->orderBy($field, $sort_field);
        } else {
            $discountList = $discountList->orderBy('id', 'desc');
        }
        $discountList = $discountList->paginate(20);

        return $discountList;
    }

    /**
     * Create a new discount
     *
     * @param   array  $dataInsert  [$dataInsert description]
     *
     * @return  [type]              [return description]
     */
    public static function createDiscountAdmin(array $dataInsert) {

        return self::create($dataInsert);
    }

     /**
     * [checkDiscountValidationAdmin description]
     *
     * @param   [type]$type     [$type description]
     * @param   null  $fieldValue    [$field description]
     * @param   null  $discountId      [$discountId description]
     * @param   null  $storeId  [$storeId description]
     * @param   null            [ description]
     *
     * @return  [type]          [return description]
     */
    public function checkDiscountValidationAdmin($type = null, $fieldValue = null, $discountId = null, $storeId = null) {
        $storeId = $storeId ? $storeId : session('adminStoreId');
        $type = $type ? $type : 'code';
        $fieldValue = $fieldValue;
        $discountId = $discountId;
        $tablePTS = (new AdminDiscount)->getTable();
        $check =  $this
            ->where($type, $fieldValue)
            ->where($tablePTS . '.store_id', $storeId);
        if ($discountId) {
            $check = $check->where('id', '<>', $discountId);
        }
        $check = $check->first();

        if ($check) {
            return false;
        } else {
            return true;
        }
    }
}
