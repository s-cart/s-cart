<?php
#app/Models/ShopBanner.php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\ModelTrait;

class ShopBanner extends Model
{
    use ModelTrait;

    public $table = SC_DB_PREFIX.'shop_banner';
    protected $guarded = [];
    protected $connection = SC_CONNECTION;

    protected  $sc_type = 'all'; // all or interger,0 - banner, 1 - background

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
//Scort
    public function scopeSort($query, $sortBy = null, $sortOrder = 'desc')
    {
        $sortBy = $sortBy ?? 'sort';
        return $query->orderBy($sortBy, $sortOrder);
    }

    /**
     * Get info detail
     *
     * @param   [int]  $id     
     * @param   [int]  $status 
     *
     */
    public function getDetail($id, $status = 1) {
        if ($status) {
            return $this->where('id', (int)$id)->where('status', 1)->first();
        } else {
            return $this->find((int)$id);
        }
    }

    /**
     * Start new process get data
     *
     * @return  new model
     */
    public function start() {
        return new ShopBanner;
    }

    /**
     * Set type
     */
    private function setType($type) {
        if ($type === 'all') {
            $this->sc_type = $type;
        } else {
            $this->sc_type = (int)$type;
        }
        return $this;
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
        if ($this->sc_type !== 'all') {
            $query = $query->where('type', $this->sc_type);
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
