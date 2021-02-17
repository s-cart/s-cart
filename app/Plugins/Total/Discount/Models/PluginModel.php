<?php
#App\Plugins\Total\Discount\Models\PluginModel.php
namespace App\Plugins\Total\Discount\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
class PluginModel extends Model
{
    public $timestamps    = false;
    public $table = SC_DB_PREFIX.'shop_discount';
    public $table_related = SC_DB_PREFIX.'shop_discount_customer';
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
        if (Schema::hasTable($this->table_related)) {
            Schema::drop($this->table_related);
        }
    }

    protected static function boot()
    {
        parent::boot();
        // before delete() method call this
        static::deleting(function ($model) {
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
            $table->integer('store_id')->default(1)->index();
            $table->tinyInteger('status')->default(0);
            $table->dateTime('expires_at')->nullable();
        });

        Schema::create($this->table_related, function (Blueprint $table) {
            $table->integer('customer_id');
            $table->integer('discount_id');
            $table->text('log')->nullable();
            $table->timestamp('used_at')->nullable();
            $table->primary(['customer_id', 'discount_id']);
        });
        

    }
    /**
     * Get the users who is related promocode.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function users()
    {
        return $this->belongsToMany(\SCart\Core\Front\Models\ShopCustomer::class, $this->table_related, 'discount_id','customer_id')
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
        if (config('app.storeId') == SC_ID_ROOT) {
            //If store is primary store, dont check store id
            $promocode = $this
                ->where('code', $code)
                ->first();
        } else {
            // Only use for owner store
            $promocode = $this
                ->where('store_id', config('app.storeId'))
                ->where('code', $code)
                ->first();
        }

        return $promocode;
    }
}
