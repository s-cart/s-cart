<?php
#S-Cart/Core/Front/Models/ShopOrder.php
namespace App\Pmo\Front\Models;

use App\Pmo\Front\Models\ShopOrderDetail;
use App\Pmo\Front\Models\ShopOrderHistory;
use App\Pmo\Front\Models\ShopOrderTotal;
use App\Pmo\Front\Models\ShopProduct;
use DB;
use Illuminate\Database\Eloquent\Model;


class ShopOrder extends Model
{
    use \App\Pmo\Front\Models\ModelTrait;
    use \App\Pmo\Front\Models\UuidTrait;

    public $table = SC_DB_PREFIX.'shop_order';
    protected $guarded = [];
    protected $connection = SC_CONNECTION;

    protected $sc_order_profile = 0; // 0: all, 1: only user's order
    public $sc_status = 1;
    
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
        return $this->belongsTo('App\Pmo\Front\Models\ShopCustomer', 'customer_id', 'id');
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
                //Update stock, sold
                ShopProduct::updateStock($orderDetail->product_id, -$orderDetail->qty);
            }
            $order->details()->delete(); //delete order details
            $order->orderTotal()->delete(); //delete order total
            $order->history()->delete(); //delete history
        });

        //Uuid
        static::creating(function ($model) {
            if (empty($model->{$model->getKeyName()})) {
                $model->{$model->getKeyName()} = sc_generate_id($type = 'shop_order');
            }
        });
    }


    /**
     * Update status order
     *
     * @param [type] $orderId
     * @param integer $status
     * @param array $history
     * @return void
     */
    public function updateStatus($orderId, $status = 0, $history = [])
    {
        $order = $this->find($orderId);
        if ($order) {
            //Update status
            $order->update(['status' => (int) $status]);

            //Add history
            $dataHistory = [
                'order_id' => $orderId,
                'customer_id' => $history['user_id'] ?? 0,
                'admin_id' => $history['admin_id'] ?? 0,
                'content' => $history['content'] ?? '',
                'order_status_id' => $status,
            ];
            $this->addOrderHistory($dataHistory);

            //Process event update status order
            sc_event_order_update_status($order);
        }
    }


    public function scopeSort($query, $sortBy = null, $sortOrder = 'asc')
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
        //Process escape
        $dataOrder     = sc_clean($dataOrder);
        $dataTotal     = sc_clean($dataTotal);
        $arrCartDetail = sc_clean($arrCartDetail);
        try {
            DB::connection(SC_CONNECTION)->beginTransaction();
            $dataOrder['domain'] = url('/');
            $uID = $dataOrder['customer_id'] ?? 0;
            $adminID = $dataOrder['admin_id'] ?? 0;
            unset($dataOrder['admin_id']);
            $currency = $dataOrder['currency'];
            $exchange_rate = $dataOrder['exchange_rate'];

            //Insert order
            $order = ShopOrder::create($dataOrder);
            $orderID = $order->id;
            //End insert order

            //Insert order total
            foreach ($dataTotal as $key => $row) {
                $row = sc_clean($row);
                $row['id'] = sc_generate_id($type = 'shop_order_total');
                $row['order_id'] = $orderID;
                $row['created_at'] = sc_time_now();
                $dataTotal[$key] = $row;
            }
            ShopOrderTotal::insert($dataTotal);
            //End order total

            //Order detail
            foreach ($arrCartDetail as $cartDetail) {
                $pID = $cartDetail['product_id'];
                $product = ShopProduct::find($pID);
                
                //Check product flash sale over stock
                if (function_exists('sc_product_flash_check_over') && !sc_product_flash_check_over($pID, $cartDetail['qty'])) {
                    return $return = ['error' => 1, 'msg' => sc_language_render('cart.item_over_qty', ['sku' => $product->sku, 'qty' => $cartDetail['qty']])];
                }

                //If product out of stock
                if (!sc_config('product_buy_out_of_stock') && $product->stock < $cartDetail['qty']) {
                    return $return = ['error' => 1, 'msg' => sc_language_render('cart.item_over_qty', ['sku' => $product->sku, 'qty' => $cartDetail['qty']])];
                }
                //
                $tax = (sc_tax_price($cartDetail['price'], $product->getTaxValue()) - $cartDetail['price']) *  $cartDetail['qty'];

                $cartDetail['order_id'] = $orderID;
                $cartDetail['currency'] = $currency;
                $cartDetail['exchange_rate'] = $exchange_rate;
                $cartDetail['sku'] = $product->sku;
                $cartDetail['tax'] = $tax;
                $cartDetail['store_id'] = $cartDetail['store_id'];
                $cartDetail['attribute'] = json_encode($cartDetail['attribute']);
                $this->addOrderDetail($cartDetail);

                //Update stock flash sale
                if (function_exists('sc_product_flash_update_stock')) {
                    sc_product_flash_update_stock($pID, $cartDetail['qty']);
                }

                //Update stock and sold
                ShopProduct::updateStock($pID, $cartDetail['qty']);
            }
            //End order detail

            //Add history
            $dataHistory = [
                'order_id' => $orderID,
                'content' => 'New order',
                'customer_id' => $uID,
                'admin_id' => $adminID,
                'order_status_id' => $order->status,
            ];
            $this->addOrderHistory($dataHistory);

            //Process Discount
            $totalMethod = session('totalMethod') ?? [];
            foreach ($totalMethod as $keyPlugin => $codeApply) {
                if ($codeApply) {
                    $moduleClass = sc_get_class_plugin_controller($code = 'Total', $key = $keyPlugin);
                    $arrReturnModuleDiscount = (new $moduleClass)->apply($codeApply, $uID, $msg = 'Order #' . $orderID);
                    if ($arrReturnModuleDiscount['error'] == 1) {
                        $msg = $arrReturnModuleDiscount['msg'];
                        DB::connection(SC_CONNECTION)->rollBack();
                        $return = ['error' => 1, 'msg' => $msg];
                        return $return;
                    }
                }
            }
            // End process Discount

            DB::connection(SC_CONNECTION)->commit();

            // Process event created
            sc_event_order_created($order);

            $return = ['error' => 0, 'orderID' => $orderID, 'msg' => "", 'detail' => $order];
        } catch (\Throwable $e) {
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
    public function start()
    {
        if ($this->sc_order_profile) {
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
        if (empty($orderID)) {
            return null;
        }
        $customer = auth()->user();
        if ($customer) {
            return $this->where('id', $orderID)
                ->where('customer_id', $customer->id)
                ->first();
        } else {
            return null;
        }
    }

    /**
     * Disable only user's order mode
     */
    public function setOrderProfile()
    {
        $this->sc_order_profile = 1;
        $this->sc_status = 'all' ;
        return $this;
    }

    public function profile()
    {
        $this->setOrderProfile();
        return $this;
    }

    /**
     * Get list order new
     */
    public function getOrderNew()
    {
        $this->sc_status = 1;
        return $this;
    }

    /**
     * Get list order processing
     */
    public function getOrderProcessing()
    {
        $this->sc_status = 2;
        return $this;
    }

    /**
     * Get list order hold
     */
    public function getOrderHold()
    {
        $this->sc_status = 3;
        return $this;
    }

    /**
     * Get list order canceld
     */
    public function getOrderCanceled()
    {
        $this->sc_status = 4;
        return $this;
    }

    /**
     * Get list order done
     */
    public function getOrderDone()
    {
        $this->sc_status = 5;
        return $this;
    }

    /**
     * Get list order failed
     */
    public function getOrderFailed()
    {
        $this->sc_status = 6;
        return $this;
    }

    /**
     * build Query
     */
    public function buildQuery()
    {
        $customer = auth()->user();
        if ($this->sc_order_profile == 1) {
            if (!$customer) {
                return null;
            }
            $uID = $customer->id;
            $query = $this->with('orderTotal')->where('customer_id', $uID);
        } else {
            $query = $this->with('orderTotal')->with('details');
        }

        if ($this->sc_status !== 'all') {
            $query = $query->where('status', $this->sc_status);
        }

        /**
        Note: sc_moreWhere will remove in the next version
         */
        if (count($this->sc_moreWhere)) {
            foreach ($this->sc_moreWhere as $key => $where) {
                if (count($where)) {
                    $query = $query->where($where[0], $where[1], $where[2]);
                }
            }
        }
        $query = $this->processMoreQuery($query);
        

        if ($this->random) {
            $query = $query->inRandomOrder();
        } else {
            if (is_array($this->sc_sort) && count($this->sc_sort)) {
                foreach ($this->sc_sort as  $rowSort) {
                    if (is_array($rowSort) && count($rowSort) == 2) {
                        $query = $query->sort($rowSort[0], $rowSort[1]);
                    }
                }
            }
        }

        return $query;
    }

    /**
     * Update value balance, received when order capture full money with payment method
     *
     * @return  [type]  [return description]
     */
    public function processPaymentPaid()
    {
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
