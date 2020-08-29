<?php
#app/Models/ShopNewsDescription.php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ShopNewsDescription extends Model
{
    protected $primaryKey = ['lang', 'news_id'];
    public $incrementing = false;
    protected $guarded = [];
    public $timestamps = false;
    public $table = SC_DB_PREFIX.'shop_news_description';
    protected $connection = SC_CONNECTION;
    protected $fillable = ['lang', 'title', 'description', 'keyword', 'news_id', 'content'];
}
