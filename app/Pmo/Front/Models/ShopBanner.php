<?php
namespace App\Pmo\Front\Models;

use Illuminate\Database\Eloquent\Model;
use App\Pmo\Front\Models\ShopStore;


class ShopBanner extends Model
{
    
    use \App\Pmo\Front\Models\ModelTrait;
    use \App\Pmo\Front\Models\UuidTrait;

    public $table = SC_DB_PREFIX.'shop_banner';
    protected $guarded = [];
    protected $connection = SC_CONNECTION;

    protected $sc_type = 'all'; // all or interger
    protected $sc_store = 0; // 1: only produc promotion,

    public function stores()
    {
        return $this->belongsToMany(ShopStore::class, ShopBannerStore::class, 'banner_id', 'store_id');
    }

    /*
    Get thumb
    */
    public function getThumb()
    {
        return sc_image_get_path_thumb($this->image);
    }

    /*
    Get image
    */
    public function getImage()
    {
        return sc_image_get_path($this->image);
    }
    
    public function scopeSort($query, $sortBy = null, $sortOrder = 'asc')
    {
        $sortBy = $sortBy ?? 'sort';
        return $query->orderBy($sortBy, $sortOrder);
    }

    /**
     * Get info detail
     *
     * @param   [int]  $id
     * @param   [int]  $checkActive
     *
     */
    public function getDetail($id, $checkActive = 1)
    {
        $storeId = config('app.storeId');
        $dataSelect = $this->getTable().'.*';
        $data =  $this->selectRaw($dataSelect)
            ->where('id', $id);
        if ($checkActive) {
            $data = $data->where($this->getTable() .'.status', 1);
        }
        if (sc_check_multi_shop_installed()) {
            $tableBannerStore = (new ShopBannerStore)->getTable();
            $tableStore = (new ShopStore)->getTable();
            $data = $data->join($tableBannerStore, $tableBannerStore.'.banner_id', $this->getTable() . '.id');
            $data = $data->join($tableStore, $tableStore . '.id', $tableBannerStore.'.store_id');
            $data = $data->where($tableStore . '.status', '1');
            $data = $data->where($tableBannerStore.'.store_id', $storeId);
        }
        $data = $data->first();
        return $data;
    }

    protected static function boot()
    {
        parent::boot();
        // before delete() method call this
        static::deleting(function ($banner) {
            $banner->stores()->detach();

            //Delete custom field
            (new ShopCustomFieldDetail)
            ->join(SC_DB_PREFIX.'shop_custom_field', SC_DB_PREFIX.'shop_custom_field.id', SC_DB_PREFIX.'shop_custom_field_detail.custom_field_id')
            ->where(SC_DB_PREFIX.'shop_custom_field_detail.rel_id', $banner->id)
            ->where(SC_DB_PREFIX.'shop_custom_field.type', 'shop_banner')
            ->delete();

        });


        //Uuid
        static::creating(function ($model) {
            if (empty($model->{$model->getKeyName()})) {
                $model->{$model->getKeyName()} = sc_generate_id($type = 'shop_banner');
            }
        });
    }


    /**
     * Start new process get data
     *
     * @return  new model
     */
    public function start()
    {
        return new ShopBanner;
    }

    /**
     * Set type
     */
    public function setType($type)
    {
        $this->sc_type = $type;
        return $this;
    }

    /**
     * Get banner
     */
    public function getBanner()
    {
        $this->setType('banner');
        return $this;
    }

    /**
     * Get banner
     */
    public function getBannerStore()
    {
        $this->setType('banner-store');
        return $this;
    }

    /**
     * Get background
     */
    public function getBackground()
    {
        $this->setType('background');
        $this->setLimit(1);
        return $this;
    }

    /**
     * Get background
     */
    public function getBackgroundStore()
    {
        $this->setType('background-store');
        $this->setLimit(1);
        return $this;
    }

    /**
     * Get banner
     */
    public function getBreadcrumb()
    {
        $this->setType('breadcrumb');
        $this->setLimit(1);
        return $this;
    }

    /**
     * Get banner
     */
    public function getBreadcrumbStore()
    {
        $this->setType('breadcrumb-store');
        $this->setLimit(1);
        return $this;
    }

    /**
     * Set store id
     *
     */
    public function setStore($id)
    {
        $this->sc_store = $id;
        return $this;
    }

    /**
     * build Query
     */
    public function buildQuery()
    {
        $dataSelect = $this->getTable().'.*';
        $query =  $this->selectRaw($dataSelect)
            ->where($this->getTable() .'.status', 1);

        $storeId = config('app.storeId');

        if (sc_check_multi_shop_installed()) {
            //Get product active for store
            if (!empty($this->sc_store)) {
                //If sepcify store id
                $storeId = $this->sc_store;
            }
            $tableBannerStore = (new ShopBannerStore)->getTable();
            $tableStore = (new ShopStore)->getTable();
            $query = $query->join($tableBannerStore, $tableBannerStore.'.banner_id', $this->getTable() . '.id');
            $query = $query->join($tableStore, $tableStore . '.id', $tableBannerStore.'.store_id');
            $query = $query->where($tableStore . '.status', '1');
            $query = $query->where($tableBannerStore.'.store_id', $storeId);
        }

        if ($this->sc_type !== 'all') {
            $query = $query->where('type', $this->sc_type);
        }
        
        /**
        Note: sc_moreWhere will remove in the next version
         */
        if (count($this->sc_moreWhere)) {
            foreach ($this->sc_moreWhere as $key => $where) {
                if (count($where)) {
                    $query = $query->where($where[0], $where[1], $where[2]);
                }
            }
        }
        $query = $this->processMoreQuery($query);

        if ($this->sc_random) {
            $query = $query->inRandomOrder();
        } else {
            $ckeckSort = false;
            if (is_array($this->sc_sort) && count($this->sc_sort)) {
                foreach ($this->sc_sort as  $rowSort) {
                    if (is_array($rowSort) && count($rowSort) == 2) {
                        if ($rowSort[0] == 'sort') {
                            $ckeckSort = true;
                        }
                        $query = $query->sort($rowSort[0], $rowSort[1]);
                    }
                }
            }
            //Use field "sort" if haven't above
            if (!$ckeckSort) {
                $query = $query->orderBy($this->getTable().'.sort', 'asc');
            }
            //Default, will sort id
            $query = $query->orderBy($this->getTable().'.id', 'desc');
        }

        return $query;
    }
}
