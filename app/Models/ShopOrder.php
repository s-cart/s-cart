<?php
#app/Models/ShopOrder.php
namespace App\Models;

use App\Models\ShopOrderDetail;
use App\Models\ShopOrderHistory;
use App\Models\ShopOrderTotal;
use App\Models\ShopProduct;
use DB;
use Illuminate\Database\Eloquent\Model;
use App\Models\ModelTrait;

class ShopOrder extends Model
{
    use ModelTrait;

    public $table = SC_DB_PREFIX.'shop_order';
    protected $guarded = [];
    protected $connection = SC_CONNECTION;

    protected  $sc_order_profile = 0; // 0: all, 1: only user's order


    public static $mapStyleStatus = [
        '1' => 'info', //new
        '2' => 'primary', //processing
        '3' => 'warning', //Hold
        '4' => 'danger', //Cancel
        '5' => 'success', //Success
        '6' => 'default', //Failed
    ];

    public function details()
    {
        return $this->hasMany(ShopOrderDetail::class, 'order_id', 'id');
    }
    public function orderTotal()
    {
        return $this->hasMany(ShopOrderTotal::class, 'order_id', 'id');
    }

    public function customer()
    {
        return $this->belongsTo('App\Models\ShopUser', 'user_id', 'id');
    }
    public function orderStatus()
    {
        return $this->hasOne(ShopOrderStatus::class, 'id', 'status');
    }
    public function paymentStatus()
    {
        return $this->hasOne(ShopPaymentStatus::class, 'id', 'payment_status');
    }
    public function history()
    {
        return $this->hasMany(ShopOrderHistory::class, 'order_id', 'id');
    }
    protected static function boot()
    {
        parent::boot();
        // before delete() method call this
        static::deleting(function ($order) {
            foreach ($order->details as $key => $orderDetail) {
                $item = ShopProduct::find($orderDetail->product_id);
                //Update stock, sold
                ShopProduct::updateStock($orderDetail->product_id, -$orderDetail->qty);

            }
            $order->details()->delete(); //delete order details
            $order->orderTotal()->delete(); //delete order total
            $order->history()->delete(); //delete history

        });
    }

/**
 * Update status order
 * @param  [type]  $orderId
 * @param  integer $status
 * @param  string  $msg
 */
    public function updateStatus($orderId, $status = 0, $msg = '')
    {
        $uID = auth()->user()->id ?? 0;
        $order = $this->find($orderId);
        if ($order) {
            //Update status
            $order->update(['status' => (int) $status]);

            //Add history
            $dataHistory = [
                'order_id' => $orderId,
                'content' => $msg,
                'user_id' => $uID,
                'order_status_id' => $status,
            ];
            $this->addOrderHistory($dataHistory);
        }
    }

//Scort
    public function scopeSort($query, $sortBy = null, $sortOrder = 'desc')
    {
        $sortBy = $sortBy ?? 'sort';
        return $query->orderBy($sortBy, $sortOrder);
    }

    /**
     * Create new order
     * @param  [array] $dataOrder
     * @param  [array] $dataTotal
     * @param  [array] $arrCartDetail
     * @return [array]
     */
    public function createOrder($dataOrder, $dataTotal, $arrCartDetail)
    {
        try {
            DB::connection(SC_CONNECTION)->beginTransaction();
            $dataOrder = sc_clean($dataOrder);
            $dataOrder['domain'] = url('/');
            $dataOrder['store_id'] = config('app.storeId');
            $uID = $dataOrder['user_id'];
            $currency = $dataOrder['currency'];
            $exchange_rate = $dataOrder['exchange_rate'];

            //Insert order
            $order = ShopOrder::create($dataOrder);
            $orderID = $order->id;
            //End insert order

            //Insert order total
            foreach ($dataTotal as $key => $row) {
                array_walk($row, function (&$v, $k) {
                    return $v = sc_clean($v);
                    }
                );
                $row['order_id'] = $orderID;
                $row['created_at'] = date('Y-m-d H:i:s');
                $dataTotal[$key] = $row;
            }
            ShopOrderTotal::insert($dataTotal);
            //End order total

            //Order detail
            foreach ($arrCartDetail as $cartDetail) {
                $pID = $cartDetail['product_id'];
                $product = ShopProduct::find($pID);
                //If product out of stock
                if (!sc_config('product_buy_out_of_stock') && $product->stock < $cartDetail['qty']) {
                    return $return = ['error' => 1, 'msg' => trans('cart.over', ['item' => $product->sku])];
                }
                //
                $cartDetail['order_id'] = $orderID;
                $cartDetail['currency'] = $currency;
                $cartDetail['exchange_rate'] = $exchange_rate;
                $cartDetail['sku'] = $product->sku;
                $cartDetail['tax'] = (sc_tax_price($cartDetail['price'], $product->getTaxValue()) - $cartDetail['price']) *  $cartDetail['qty'];
                $this->addOrderDetail($cartDetail);

                //Update stock and sold
                ShopProduct::updateStock($pID, $cartDetail['qty']);
            }
            //End order detail

            //Add history
            $dataHistory = [
                'order_id' => $orderID,
                'content' => 'New order',
                'user_id' => $uID,
                'order_status_id' => $order->status,
            ];
            $this->addOrderHistory($dataHistory);

            //Process Discount
            $codeDiscount = session('Discount') ?? '';
            if ($codeDiscount) {
                if (!empty(sc_config('Discount'))) {
                    $moduleClass = sc_get_class_plugin_controller($code = 'Total', $key = 'Discount');
                    $returnModuleDiscount = (new $moduleClass)->apply($codeDiscount, $uID, $msg = 'Order #' . $orderID);
                    $arrReturnModuleDiscount = json_decode($returnModuleDiscount, true);
                    if ($arrReturnModuleDiscount['error'] == 1) {
                        if ($arrReturnModuleDiscount['msg'] == 'error_code_not_exist') {
                            $msg = trans('promotion.process.invalid');
                        } elseif ($arrReturnModuleDiscount['msg'] == 'error_code_cant_use') {
                            $msg = trans('promotion.process.over');
                        } elseif ($arrReturnModuleDiscount['msg'] == 'error_code_expired_disabled') {
                            $msg = trans('promotion.process.expire');
                        } elseif ($arrReturnModuleDiscount['msg'] == 'error_user_used') {
                            $msg = trans('promotion.process.used');
                        } elseif ($arrReturnModuleDiscount['msg'] == 'error_uID_input') {
                            $msg = trans('promotion.process.user_id_invalid');
                        } elseif ($arrReturnModuleDiscount['msg'] == 'error_login') {
                            $msg = trans('promotion.process.must_login');
                        } else {
                            $msg = trans('promotion.process.undefined');
                        }
                        return redirect()->route('cart')->with(['error_discount' => $msg]);
                    }
                }
            }
            // End process Discount

            DB::connection(SC_CONNECTION)->commit();
            $return = ['error' => 0, 'orderID' => $orderID, 'msg' => ""];
        } catch (\Exception $e) {
            DB::connection(SC_CONNECTION)->rollBack();
            $return = ['error' => 1, 'msg' => $e->getMessage()];
        }
        return $return;
    }

/**
 * Add order history
 * @param [array] $dataHistory
 */
    public function addOrderHistory($dataHistory)
    {
        $dataHistory['admin_id'] = (\App\Admin\Admin::user())?\App\Admin\Admin::user()->id:0;
        return ShopOrderHistory::create($dataHistory);
    }

/**
 * Add order detail
 * @param [type] $dataDetail [description]
 */
    public function addOrderDetail($dataDetail)
    {
        return ShopOrderDetail::create($dataDetail);
    }


    /**
     * Start new process get data
     *
     * @return  new model
     */
    public function start() {
        if($this->sc_order_profile) {
            $obj = (new ShopOrder);
            $obj->sc_order_profile = 1;
            return $obj;
        } else {
            return new ShopOrder;
        }
    }

    /**
     * Get order detail
     *
     * @param   [int]  $orderID 
     *
     */
    public function getDetail($orderID)
    {
        if(empty($orderID)) {
            return null;
        }
        if(auth()->user()) {
            return $this->where('id', $orderID)
            ->where('user_id', auth()->user()->id)
            ->first();
        } else {
            return null;
        }

    }

    /**
     * Disable only user's order mode
     */
    public function setOrderProfile() {
        $this->sc_order_profile = 1;
        $this->sc_status = 'all' ;
        return $this;
    }

    public function profile() {
        $this->setOrderProfile();
        return $this;
    }

    /**
     * Get list order new
     */
    public function getOrderNew() {
        $this->sc_status = 1;
        return $this;
    }

    /**
     * Get list order processing
     */
    public function getOrderProcessing() {
        $this->sc_status = 2;
        return $this;
    }

    /**
     * Get list order hold
     */
    public function getOrderHold() {
        $this->sc_status = 3;
        return $this;
    }

    /**
     * Get list order canceld
     */
    public function getOrderCanceled() {
        $this->sc_status = 4;
        return $this;
    }

    /**
     * Get list order done
     */
    public function getOrderDone() {
        $this->sc_status = 5;
        return $this;
    }

    /**
     * Get list order failed
     */
    public function getOrderFailed() {
        $this->sc_status = 6;
        return $this;
    }

    /**
     * build Query
     */
    public function buildQuery() {
        if ($this->sc_order_profile == 1) {
            if(!auth()->user()) {
                return null;
            }
            $uID = auth()->user()->id;
            $query = $this->with('orderTotal')->where('user_id', $uID);
        } else {
            $query = $this->with('orderTotal')->with('details');
        }

        if ($this->sc_status !== 'all') {
            $query = $query->where('status', $this->sc_status);
        }

        if (count($this->sc_moreWhere)) {
            foreach ($this->sc_moreWhere as $key => $where) {
                if(count($where)) {
                    $query = $query->where($where[0], $where[1], $where[2]);
                }
            }
        }

        if ($this->random) {
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

    /**
     * Get country order in year
     *
     * @return  [type]  [return description]
    */
    public function getCountryInYear() {
        return $this->selectRaw('country, count(id) as count')
            ->whereRaw('DATE(created_at) >=  DATE_SUB(DATE(NOW()), INTERVAL 12 MONTH)')
            ->groupBy('country')
            ->orderBy('count', 'desc')
            ->get();
    }
    
    /**
     * Get Sum order total In Year
     *
     * @return  [type]  [return description]
     */
    public function getSumOrderTotalInYear() {
        return $this->selectRaw('DATE_FORMAT(created_at, "%Y-%m") AS ym, SUM(total/exchange_rate) AS total_amount')
            ->whereRaw('created_at >=  DATE_FORMAT(DATE_SUB(CURRENT_DATE(), INTERVAL 12 MONTH), "%Y-%m")')
            ->groupBy('ym')->get();
    }

    /**
     * Get Sum order total In month
     *
     * @return  [type]  [return description]
     */
    public function getSumOrderTotalInMonth() {
        return $this->selectRaw('DATE_FORMAT(created_at, "%m-%d") AS md,
        SUM(total/exchange_rate) AS total_amount, count(id) AS total_order')
            ->whereRaw('created_at >=  DATE_FORMAT(DATE_SUB(CURRENT_DATE(), INTERVAL 1 MONTH), "%Y-%m-%d")')
            ->groupBy('md')->get();
    }

    /**
     * Update value balance, received when order capture full money with payment method
     *
     * @return  [type]  [return description]
     */
    public function processPaymentPaid() {
        $total = $this->total;
        $this->balance = 0;
        $this->received = -$total;
        $this->save();
        (new ShopOrderTotal)
            ->where('order_id', $this->id)
            ->where('code', 'received')
            ->update(['value' =>  -$total]);
    }
}
