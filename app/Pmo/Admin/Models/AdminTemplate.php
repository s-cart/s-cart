<?php
namespace App\Pmo\Admin\Models;

use Illuminate\Database\Eloquent\Model;

class AdminTemplate extends Model
{
    public $table = SC_DB_PREFIX.'admin_template';
    protected $guarded = [];
    protected $connection = SC_CONNECTION;

    /**
     * Get list template installed
     *
     * @return void
     */
    public function getListTemplate()
    {
        return $this->pluck('name', 'key')
            ->all();
    }


    /**
     * Get list template active
     *
     * @return void
     */
    public function getListTemplateActive()
    {
        $arrTemplate =  $this->where('status', 1)
            ->pluck('name', 'key')
            ->all();
        if (!count($arrTemplate)) {
            $arrTemplate['s-cart-light'] = 'S-Cart Light';
        }
        return $arrTemplate;
    }
}
