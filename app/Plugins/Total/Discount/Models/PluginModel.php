<?php
#App\Plugins\Total\Discount\Models\PluginModel.php
namespace App\Plugins\Total\Discount\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use App\Models\AdminStore;
class PluginModel extends Model
{
    public $timestamps    = false;
    public $table = SC_DB_PREFIX.'shop_discount';
    public $table_store = SC_DB_PREFIX.'shop_discount_store';
    public $table_related = SC_DB_PREFIX.'shop_discount_user';
    protected $connection = SC_CONNECTION;
    protected $guarded    = [];
    protected $dates      = ['expires_at'];

    public function __construct(array $attributes = [])
    {
        parent::__construct($attributes);
    }
    public function uninstall() {
        if (Schema::hasTable($this->table)) {
            Schema::drop($this->table);
        }
        if (Schema::hasTable($this->table_store)) {
            Schema::drop($this->table_store);
        }
        if (Schema::hasTable($this->table_related)) {
            Schema::drop($this->table_related);
        }
    }

    public function stories()
    {
        return $this->belongsToMany(AdminStore::class, $this->table_store, $this->table.'_id', 'store_id');
    }

    protected static function boot()
    {
        parent::boot();
        // before delete() method call this
        static::deleting(function ($model) {
                $model->stories()->detach();
                $model->users()->detach();
            }
        );
    }

    public function install()
    {
        $this->uninstall();

        Schema::create($this->table, function (Blueprint $table) {
            $table->increments('id');
            $table->string('code', 50)->unique();
            $table->integer('reward')->default(2);
            $table->string('type', 10)->default('point')->comment('point - Point; percent - %');
            $table->string('data', 300)->nullable();
            $table->integer('limit')->default(1);
            $table->integer('used')->default(0);
            $table->integer('login')->default(0);
            $table->tinyInteger('status')->default(0);
            $table->dateTime('expires_at')->nullable();
        });

        Schema::create($this->table_store, function (Blueprint $table) {
            $table->integer($this->table.'_id');
            $table->integer('store_id');
            $table->primary([$this->table.'_id', 'store_id']);
        });
        
        Schema::create($this->table_related, function (Blueprint $table) {
            $table->integer($this->table.'_id');
            $table->integer('store_id');
            $table->primary([$this->table.'_id', 'store_id']);
        });
        

    }
    /**
     * Get the users who is related promocode.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function users()
    {
        return $this->belongsToMany(\App\Models\ShopUser::class, $this->table_related, $this->table.'_id','user_id')
            ->withPivot('used_at', 'log');
    }

    /**
     * Query builder to get expired promotion codes.
     *
     * @param $query
     * @return mixed
     */
    public function scopeExpired($query)
    {
        return $query->whereNotNull('expires_at')->whereDate('expires_at', '<=', Carbon::now());
    }

    /**
     * Check if code is expired.
     *
     * @return bool
     */
    public function isExpired()
    {
        return $this->expires_at ? Carbon::now()->gte($this->expires_at) : false;
    }

    /**
     * [getPromotionByCode description]
     *
     * @param   [type]  $code  [$code description]
     *
     * @return  [type]         [return description]
     */
    public function getPromotionByCode($code) {
        $promocode = $this
        ->leftJoin($this->table_store, $this->table_store . '.'.$this->table.'_id', $this->table . '.id')
        ->where($this->table . '.code', $code)
        ->whereIn($this->table_store.'.store_id', [0, config('app.storeId')])
        ->first();
        return $promocode;
    }
}
