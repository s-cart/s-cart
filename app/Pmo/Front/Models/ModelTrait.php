<?php

namespace App\Pmo\Front\Models;

/**
 * Trait Model.
 */
trait ModelTrait
{
    protected $sc_limit = 'all'; // all or interger
    protected $sc_paginate = 0; // 0: dont paginate,
    protected $sc_sort = [];
    protected $sc_moreWhere = []; // more where
    protected $sc_moreQuery = []; // more query
    protected $sc_random = 0; // 0: no random, 1: random
    protected $sc_keyword = ''; // search search product
 

    
    /**
     * Set value limit
     * @param   [string]  $limit
     */
    public function setLimit($limit)
    {
        if ($limit === 'all') {
            $this->sc_limit = $limit;
        } else {
            $this->sc_limit = (int)$limit;
        }
        return $this;
    }

    /**
     * Set value sort
     * @param   [array]  $sort ['field', 'asc|desc']
     */
    public function setSort(array $sort)
    {
        if (is_array($sort)) {
            $this->sc_sort[] = $sort;
        }
        return $this;
    }

    /**
     * Add more where
     * @param   [array]  $moreWhere
     * NOTE: Will remove in the next versions
     */
    public function setMoreWhere(array $moreWhere)
    {
        if (is_array($moreWhere)) {
            $where = [];
            if (count($moreWhere) == 2) {
                $where[0] = $moreWhere[0];
                $where[1] = '=';
                $where[2] = $moreWhere[1];
            } elseif (count($moreWhere) == 3) {
                $where = $moreWhere;
            }
            if (count($where) == 3) {
                $this->sc_moreWhere[] = $where;
            }
        }
        return $this;
    }

    /**
     * [setMoreQuery description]
     *
     * @param   string|array  $moreQuery  [$moreQuery description]
     *
     * @return  [type]              [return description]
     */

    public function setMoreQuery($moreQuery)
    {
        if (is_string($moreQuery) || is_array($moreQuery)) {
            $this->sc_moreQuery[] = $moreQuery;
        }
        return $this;
    }

    /**
     * process more query
     *
     * @param   [type]  $query  [$query description]
     *
     * @return  [type]          [return description]
     */
    public function processMoreQuery($query) {
        if (count($this->sc_moreQuery)) {
            foreach ($this->sc_moreQuery as $key => $where) {
                if (is_string($where)) {
                    $query = $query->whereRaw($where);
                }
                if (is_array($where) && count($where) == 1) {
                    foreach ($where as $ope => $obj) {
                        if (!is_numeric($ope) && is_array($obj)) {
                            $query = $query->{$ope}(...$obj);
                        }
                    }
                }
            }
        }
        return $query;
    }

    /**
     * Enable paginate mode
     *  0 - no paginate
     */
    public function setPaginate(int $value = 1)
    {
        $this->sc_paginate = $value;
        return $this;
    }

    /**
     * Set random mode
     */
    public function setRandom(int $value = 1)
    {
        $this->sc_random = $value;
        return $this;
    }
    
    /**
     * Set keyword search
     * @param   [string]  $keyword
     */
    public function setKeyword(string $keyword)
    {
        if (trim($keyword)) {
            $this->sc_keyword = trim($keyword);
        }
        return $this;
    }


    /**
    * Get Sql
    */
    public function getSql()
    {
        $query = $this->buildQuery();
        if (!$this->sc_paginate) {
            if ($this->sc_limit !== 'all') {
                $query = $query->limit($this->sc_limit);
            }
        }
        return $query = $query->toSql();
    }

    /**
    * Get data
    * @param   [array]  $action
    */
    public function getData(array $action = [])
    {
        $query = $this->buildQuery();
        if (!empty($action['query'])) {
            return $query;
        }
        if ($this->sc_paginate) {
            $data =  $query->paginate(($this->sc_limit === 'all') ? 20 : $this->sc_limit);
        } else {
            if ($this->sc_limit !== 'all') {
                $query = $query->limit($this->sc_limit);
            }
            $data = $query->get();
                
            if (!empty($action['keyBy'])) {
                $data = $data->keyBy($action['keyBy']);
            }
            if (!empty($action['groupBy'])) {
                $data = $data->groupBy($action['groupBy']);
            }
        }
        return $data;
    }

    /**
     * Get full data
     *
     * @return  [type]  [return description]
     */
    public function getFull()
    {
        if (method_exists($this, 'getDetail')) {
            return $this->getDetail($this->id);
        } else {
            return $this;
        }
    }
    
    /**
     * Get all custom fields
     *
     * @return void
     */
    public function getCustomFields()
    {
        $typeTmp = explode(SC_DB_PREFIX, $this->getTable());
        $type = $typeTmp[1] ?? null;
        $data =  (new \App\Pmo\Front\Models\ShopCustomFieldDetail)
            ->join(SC_DB_PREFIX.'shop_custom_field', SC_DB_PREFIX.'shop_custom_field.id', SC_DB_PREFIX.'shop_custom_field_detail.custom_field_id')
            ->select('code', 'name', 'text')
            ->where(SC_DB_PREFIX.'shop_custom_field_detail.rel_id', $this->id)
            ->where(SC_DB_PREFIX.'shop_custom_field.type', $type)
            ->where(SC_DB_PREFIX.'shop_custom_field.status', '1')
            ->get()
            ->keyBy('code');
        return $data;
    }

    /**
     * Get custom field
     *
     * @return void
     */
    public function getCustomField($code = null)
    {
        $typeTmp = explode(SC_DB_PREFIX, $this->getTable());
        $type = $typeTmp[1] ?? null;
        $data =  (new \App\Pmo\Front\Models\ShopCustomFieldDetail)
            ->join(SC_DB_PREFIX.'shop_custom_field', SC_DB_PREFIX.'shop_custom_field.id', SC_DB_PREFIX.'shop_custom_field_detail.custom_field_id')
            ->select('code', 'name', 'text')
            ->where(SC_DB_PREFIX.'shop_custom_field_detail.rel_id', $this->id)
            ->where(SC_DB_PREFIX.'shop_custom_field.type', $type)
            ->where(SC_DB_PREFIX.'shop_custom_field.status', '1');
        if ($code) {
            $data = $data->where(SC_DB_PREFIX.'shop_custom_field.code', $code);
        }
        $data = $data->first();
        return $data;
    }

    /*
    Get custom fields via attribute
    $item->custom_fields
     */
    public function getCustomFieldsAttribute()
    {
        return $this->getCustomFields();
    }
}
