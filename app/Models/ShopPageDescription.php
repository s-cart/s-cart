<?php
#app/Models/ShopPageDescription.php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ShopPageDescription extends Model
{
    protected $primaryKey = ['lang', 'page_id'];
    public $incrementing  = false;
    protected $guarded    = [];
    public $timestamps    = false;
    public $table = SC_DB_PREFIX.'shop_page_description';
    protected $connection = SC_CONNECTION;
}
