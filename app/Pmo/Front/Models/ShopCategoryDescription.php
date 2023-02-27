<?php
namespace App\Pmo\Front\Models;

use Illuminate\Database\Eloquent\Model;

class ShopCategoryDescription extends Model
{
    use \App\Pmo\Front\Models\ModelTrait;
    
    protected $primaryKey = ['category_id', 'lang'];
    public $incrementing  = false;
    public $timestamps    = false;
    public $table = SC_DB_PREFIX.'shop_category_description';
    protected $connection = SC_CONNECTION;
    protected $guarded    = [];
}
