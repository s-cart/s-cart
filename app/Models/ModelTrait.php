<?php

namespace App\Models;

/**
 * Trait Model.
 */
trait ModelTrait
{

    protected  $sc_limit = 'all'; // all or interger
    protected  $sc_status = 1; // 1 - active, 0- inactive, all - all
    protected  $sc_paginate = 0; // 0: dont paginate,
    protected  $sc_sort = [];
    protected  $sc_moreWhere = []; // more wehere
    protected  $sc_random = 0; // 0: no random, 1: random
    protected  $sc_keyword = ''; // search search product
 

    
    /**
     * Set value limit
     * @param   [string]  $limit 
     */
    public function setLimit($limit) {
        if ($limit === 'all') {
            $this->sc_limit = $limit;
        } else {
            $this->sc_limit = (int)$limit;
        }
        return $this;
    }

    /**
     * Set status
     * @param   [string]  $status 
     */
    private function setStatus($status) {
        if ($status === 'all') {
            $this->sc_status = $status;
        } else {
            $this->sc_status = (int)$status ? 1 : 0;
        }
        return $this;
    }

    /**
     * Set value sort
     * @param   [array]  $sort ['field', 'asc|desc']
     */
    public function setSort(array $sort) {
        if (is_array($sort)) {
            $this->sc_sort[] = $sort;
        }
        return $this;
    }

    /**
     * Add more where
     * @param   [array]  $moreWhere 
     */
    public function setMoreWhere(array $moreWhere) {
        if (is_array($moreWhere)) {
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
     * Enable paginate mode
     *  0 - no paginate
     */
    public function setPaginate() {
        $this->sc_paginate = 1;
        return $this;
    }

    /**
     * Set random mode
     */
    public function setRandom() {
        $this->sc_random = 1;
        return $this;
    }
    
    /**
     * Set keyword search
     * @param   [string]  $keyword 
     */
    public function setKeyword($keyword) {
        if (trim($keyword)) {
            $this->sc_keyword = trim($keyword);
        }
        $this->setStatus(1);
        return $this;
    }


     /**
     * Get Query
     */
    public function getQuery() {
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
    public function getData(array $action = []) {
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
    public function getFull() {
        if (method_exists($this, 'getDetail')) {
            return $this->getDetail($this->id);
        } else {
            return $this;
        }

    }

}
