<?php
#app/Plugins/Cms/Content/Models/CmsContentDescription.php
namespace App\Plugins\Cms\Content\Models;

use Illuminate\Database\Eloquent\Model;

class CmsContentDescription extends Model
{
    protected $primaryKey = ['lang', 'content_id'];
    public $incrementing  = false;
    protected $guarded    = [];
    public $timestamps    = false;
    public $table = SC_DB_PREFIX.'cms_content_description';
    protected $connection = SC_CONNECTION;
}
