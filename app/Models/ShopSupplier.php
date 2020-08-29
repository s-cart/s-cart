<?php
#app/Models/ShopSupplier.php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\ModelTrait;

class ShopSupplier extends Model
{
    use ModelTrait;

    public $timestamps = false;
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

    protected static function boot()
    {
        parent::boot();
        // before delete() method call this
        static::deleting(function ($supplier) {
        });
    }

    /**
     * [getUrl description]
     * @return [type] [description]
     */
    public function getUrl()
    {
        return route('supplier.detail', ['alias' => $this->alias]);
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

//Scort
    public function scopeSort($query, $sortBy = null, $sortOrder = 'desc')
    {
        $sortBy = $sortBy ?? 'sort';
        return $query->orderBy($sortBy, $sortOrder);
    }

    /**
     * Get page detail
     *
     * @param   [string]  $key     [$key description]
     * @param   [string]  $type  [id, alias]
     *
     */
    public function getDetail($key, $type = null, $status = 1)
    {
        if(empty($key)) {
            return null;
        }
        if ($type === null) {
            $data = $this->where('id', (int) $key);
        } else {
            $data = $this->where($type, $key);
        }
        if ($status == 1) {
            $data = $data->where('status', 1);
        }
        return $data->first();
    }


    /**
     * Start new process get data
     *
     * @return  new model
     */
    public function start() {
        return new ShopSupplier;
    }

    /**
     * Get banner
     */
    public function getBanner() {
        $this->setType(0);
        $this->setStatus(1);
        return $this;
    }

    /**
     * Get background
     */
    public function getBackground() {
        $this->setType(1);
        $this->setStatus(1);
        return $this;
    }

    /**
     * build Query
     */
    public function buildQuery() {
        $query = $this;
        if ($this->sc_status !== 'all') {
            $query = $query->where('status', $this->sc_status);
        }

        if (count($this->sc_moreWhere)) {
            foreach ($this->sc_moreWhere as $key => $where) {
                if(count($where)) {
                    $query = $query->where($where[0], $where[1], $where[2]);
                }
            }
        }

        if ($this->sc_random) {
            $query = $query->inRandomOrder();
        } else {
            if (is_array($this->sc_sort) && count($this->sc_sort)) {
                foreach ($this->sc_sort as  $rowSort) {
                    if(is_array($rowSort) && count($rowSort) == 2) {
                        $query = $query->sort($rowSort[0], $rowSort[1]);
                    }
                }
            }
        }

        return $query;
    }
}
