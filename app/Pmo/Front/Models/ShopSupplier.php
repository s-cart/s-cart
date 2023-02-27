<?php
#s-pmo/Core/Front/Models/ShopSupplier.php
namespace App\Pmo\Front\Models;

use Illuminate\Database\Eloquent\Model;


class ShopSupplier extends Model
{
    use \App\Pmo\Front\Models\ModelTrait;
    use \App\Pmo\Front\Models\UuidTrait;

    public $table = SC_DB_PREFIX.'shop_supplier';
    protected $guarded = [];
    private static $getList = null;
    protected $connection = SC_CONNECTION;

    public static function getListAll()
    {
        if (self::$getList === null) {
            self::$getList = self::get()->keyBy('id');
        }
        return self::$getList;
    }

    /**
     * [getUrl description]
     * @return [type] [description]
     */
    public function getUrl($lang)
    {
        return sc_route('supplier.detail', ['alias' => $this->alias, 'lang' => $lang ?? app()->getLocale()]);
    }

    /*
    *Get thumb
    */
    public function getThumb()
    {
        return sc_image_get_path_thumb($this->image);
    }

    /*
    *Get image
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
     * Get page detail
     *
     * @param   [string]  $key     [$key description]
     * @param   [string]  $type  [id, alias]
     * @param   [int]  $checkActive
     *
     */
    public function getDetail($key, $type = null, $checkActive = 1)
    {
        if (empty($key)) {
            return null;
        }
        if ($type === null) {
            $data = $this->where('id', $key);
        } else {
            $data = $this->where($type, $key);
        }
        if ($checkActive) {
            $data = $data->where('status', 1);
        }
        $data = $data->where('store_id', config('app.storeId'));

        return $data->first();
    }


    /**
     * Start new process get data
     *
     * @return  new model
     */
    public function start()
    {
        return new ShopSupplier;
    }


    /**
     * build Query
     */
    public function buildQuery()
    {
        $query = $this->where('status', 1)
        ->where('store_id', config('app.storeId'));

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
            if (is_array($this->sc_sort) && count($this->sc_sort)) {
                foreach ($this->sc_sort as  $rowSort) {
                    if (is_array($rowSort) && count($rowSort) == 2) {
                        $query = $query->sort($rowSort[0], $rowSort[1]);
                    }
                }
            }
        }

        return $query;
    }

    protected static function boot()
    {
        parent::boot();
        // before delete() method call this
        static::deleting(
            function ($supplier) {
                //Delete custom field
                (new ShopCustomFieldDetail)
                ->join(SC_DB_PREFIX.'shop_custom_field', SC_DB_PREFIX.'shop_custom_field.id', SC_DB_PREFIX.'shop_custom_field_detail.custom_field_id')
                ->where(SC_DB_PREFIX.'shop_custom_field_detail.rel_id', $supplier->id)
                ->where(SC_DB_PREFIX.'shop_custom_field.type', 'shop_supplier')
                ->delete();
            }
        );
        //Uuid
        static::creating(function ($model) {
            if (empty($model->{$model->getKeyName()})) {
                $model->{$model->getKeyName()} = sc_generate_id($type = 'shop_supplier');
            }
        });
    }
}
