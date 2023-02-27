<?php

namespace App\Pmo\Front\Controllers\Auth;

/**
 * Trait Auth controller.
 */
trait AuthTrait
{
    /**
     * Map validate when edit customer
     *
     * @param   [array]  $data  [$data description]
     *
     * @return  [array]         [return description]
     */
    public function mappingValidatorEdit(array $data)
    {
        $dataMap = sc_customer_data_edit_mapping($data);
        return $dataMap;
    }

    /**
     * Mapp validate when register new customer
     *
     * @param [array] $data  [$data description]
     *
     * @return [array]         [return description]
     */
    public function mappingValidator(array $data)
    {
        $dataMap = sc_customer_data_insert_mapping($data);
        return $dataMap;
    }
}
