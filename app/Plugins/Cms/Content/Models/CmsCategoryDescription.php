<?php
#app/Plugins/Cms/Models/Content/CmsCategoryDescription.php
namespace App\Plugins\Cms\Content\Models;

use Illuminate\Database\Eloquent\Model;

class CmsCategoryDescription extends Model
{
    protected $primaryKey = ['lang', 'category_id'];
    public $incrementing  = false;
    protected $guarded    = [];
    public $timestamps    = false;
    public $table = SC_DB_PREFIX.'cms_category_description';
    protected $connection = SC_CONNECTION;
}
