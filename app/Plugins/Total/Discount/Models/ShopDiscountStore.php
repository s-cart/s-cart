<?php
namespace App\Plugins\Total\Discount\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ShopDiscountStore extends Model
{
    protected $primaryKey = ['store_id', 'discount_id'];
    public $incrementing  = false;
    protected $guarded    = [];
    public $timestamps    = false;
    public $table = SC_DB_PREFIX.'shop_discount_store';
    protected $connection = SC_CONNECTION;


    public function install()
    {
        $this->uninstall();

        Schema::create($this->table, function (Blueprint $table) {
            $table->integer('discount_id');
            $table->integer('store_id');
            $table->primary(['discount_id', 'store_id']);
        });
    }

    public function uninstall() {

        if (Schema::hasTable($this->table)) {
            Schema::drop($this->table);
        }
        if (Schema::hasTable($this->table_related)) {
            Schema::drop($this->table_related);
        }
    }
}
