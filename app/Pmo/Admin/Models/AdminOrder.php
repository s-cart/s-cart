<?php

namespace App\Pmo\Admin\Models;

use App\Pmo\Front\Models\ShopOrder;
use App\Pmo\Front\Models\ShopOrderTotal;
use Cache;

class AdminOrder extends ShopOrder
{
    public static $mapStyleStatus = [
        '1' => 'info', //new
        '2' => 'primary', //processing
        '3' => 'warning', //Hold
        '4' => 'danger', //Cancel
        '5' => 'success', //Success
        '6' => 'default', //Failed
    ];

    /**
     * Get order detail in admin
     *
     * @param   [type]  $id  [$id description]
     *
     * @return  [type]       [return description]
     */
    public static function getOrderAdmin($id, $storeId = null)
    {
        $data  = self::with(['details', 'orderTotal'])
        ->where('id', $id);
        if ($storeId) {
            $data = $data->where('store_id', $storeId);
        }
        return $data->first();
    }

    /**
     * Get list order in admin
     *
     * @param   [array]  $dataSearch  [$dataSearch description]
     *
     * @return  [type]               [return description]
     */
    public static function getOrderListAdmin(array $dataSearch)
    {
        $keyword      = $dataSearch['keyword'] ?? '';
        $email        = $dataSearch['email'] ?? '';
        $from_to      = $dataSearch['from_to'] ?? '';
        $end_to       = $dataSearch['end_to'] ?? '';
        $sort_order   = $dataSearch['sort_order'] ?? '';
        $arrSort      = $dataSearch['arrSort'] ?? '';
        $order_status = $dataSearch['order_status'] ?? '';
        $storeId      = $dataSearch['storeId'] ?? '';

        $orderList = (new ShopOrder);
        
        if ($storeId) {
            $orderList = $orderList->where('store_id', $storeId);
        }

        if ($order_status) {
            $orderList = $orderList->where('status', $order_status);
        }
        if ($keyword) {
            $orderList = $orderList->where(function ($sql) use ($keyword) {
                $sql->Where('id', $keyword);
            });
        }

        if ($email) {
            $orderList = $orderList->where(function ($sql) use ($email) {
                $sql->Where('email', 'like', '%'.$email.'%');
            });
        }

        if ($from_to) {
            $orderList = $orderList->where(function ($sql) use ($from_to) {
                $sql->Where('created_at', '>=', $from_to);
            });
        }

        if ($end_to) {
            $orderList = $orderList->where(function ($sql) use ($end_to) {
                $sql->Where('created_at', '<=', $end_to);
            });
        }

        if ($sort_order && array_key_exists($sort_order, $arrSort)) {
            $field = explode('__', $sort_order)[0];
            $sort_field = explode('__', $sort_order)[1];
            $orderList = $orderList->sort($field, $sort_field);
        } else {
            $orderList = $orderList->sort('created_at', 'desc');
        }
        $orderList = $orderList->paginate(20);

        return $orderList;
    }

    /**
     * Insert order total
     *
     * @param   [type]  $dataInsert  [$dataInsert description]
     *
     * @return  [type]               [return description]
     */
    public static function insertOrderTotal($dataInsert)
    {
        $dataInsert = sc_clean($dataInsert);
        return ShopOrderTotal::insert($dataInsert);
    }

    /**
     * Get item order total, then re-sort
     * @param  [int] $order_id [description]
     * @return [array]           [description]
     */
    public static function getOrderTotal($orderId)
    {
        $objects = ShopOrderTotal::where('order_id', $orderId)->get()->toArray();
        usort($objects, function ($a, $b) {
            if ($a['sort'] > $b['sort']) {
                return 1;
            } else {
                return -1;
            }
        });
        return $objects;
    }

    /**
     * Get row order total
     *
     * @param   [type]  $rowId  [$rowId description]
     *
     * @return  [type]          [return description]
     */
    public static function getRowOrderTotal($rowId)
    {
        return ShopOrderTotal::find($rowId);
    }

    /**
     * Update data when row of total change
     * @param  [array] $row [description]
     * @return [void]
     */
    public static function updateRowOrderTotal($dataRowTotal)
    {
        //Udate dataRowTotal
        $upField = ShopOrderTotal::find($dataRowTotal['id']);
        $upField->value = $dataRowTotal['value'];
        $upField->text = $dataRowTotal['text'];
        $upField->updated_at = sc_time_now();
        $upField->save();
        $order_id = $upField->order_id;

        //Sum value item order total
        $totalData = ShopOrderTotal::where('order_id', $order_id)->get();
        $total = $discount = $shipping = $received = $other_fee = 0;
        foreach ($totalData as $key => $value) {
            if ($value['code'] === 'subtotal') {
                $total += $value['value'];
            }
            if ($value['code'] === 'tax') {
                $total += $value['value'];
            }
            if ($value['code'] === 'discount') {
                $discount += $value['value'];
                $total += $value['value'];
            }
            if ($value['code'] === 'other_fee') {
                $other_fee += $value['value'];
                $total += $value['value'];
            }
            if ($value['code'] === 'shipping') {
                $shipping += $value['value'];
                $total += $value['value'];
            }
            if ($value['code'] === 'received') {
                $received += $value['value'];
            }
        }

        //Update total
        $updateTotal = ShopOrderTotal::where('order_id', $order_id)
            ->where('code', 'total')
            ->first();
        $updateTotal->value = $total;
        $updateTotal->save();

        //Update Order
        $order = ShopOrder::find($order_id);
        $order->discount = $discount;
        $order->shipping = $shipping;
        $order->other_fee = $other_fee;
        $order->received = $received;
        $order->balance = $total + $received;
        $order->total = $total;
        $order->save();
    }


    /**
     * Update new sub total
     * @param  [int] $orderId [description]
     * @return [type]           [description]
     */
    public static function updateSubTotal($orderId)
    {
        try {
            $order = self::getOrderAdmin($orderId);
            $details = $order->details;
            $tax = $subTotal = 0;
            if ($details->count()) {
                foreach ($details as $detail) {
                    $tax +=$detail->tax;
                    $subTotal +=$detail->total_price;
                }
            }
            $order->subtotal = $subTotal;
            $order->tax = $tax;
            $total = $subTotal + $tax + $order->discount + $order->shipping;
            $balance = $total + $order->received;
            $payment_status = 0;
            if ($balance == $total) {
                $payment_status = ShopOrderTotal::NOT_YET_PAY; //Not pay
            } elseif ($balance < 0) {
                $payment_status = ShopOrderTotal::NEED_REFUND; //Need refund
            } elseif ($balance == 0) {
                $payment_status = ShopOrderTotal::PAID; //Paid
            } else {
                $payment_status = ShopOrderTotal::PART_PAY; //Part pay
            }
            $order->payment_status = $payment_status;
            $order->total = $total;
            $order->balance = $balance;
            $order->save();

            //Update total
            $updateTotal = ShopOrderTotal::where('order_id', $orderId)
                ->where('code', 'total')
                ->first();
            $updateTotal->value = $total;
            $updateTotal->save();
            
            //Update Subtotal
            $updateSubTotal = ShopOrderTotal::where('order_id', $orderId)
                ->where('code', 'subtotal')
                ->first();
            $updateSubTotal->value = $subTotal;
            $updateSubTotal->save();

            //Update tax
            $updateSubTotal = ShopOrderTotal::where('order_id', $orderId)
            ->where('code', 'tax')
            ->first();
            $updateSubTotal->value = $tax;
            $updateSubTotal->save();

            return 1;
        } catch (\Throwable $e) {
            return $e->getMessage();
        }
    }


    /**
     * Get country order in year
     *
     * @return  [type]  [return description]
    */
    public static function getCountryInYear()
    {
        return self::selectRaw('country, count(id) as count')
        ->whereRaw('DATE(created_at) >=  DATE_SUB(DATE(NOW()), INTERVAL 12 MONTH)')
        ->groupBy('country')
        ->orderBy('count', 'desc')
        ->get();
    }

    /**
     * Get device order in year
     *
     * @return  [type]  [return description]
    */
    public static function getDeviceInYear()
    {
        return self::selectRaw('device_type, count(id) as count')
        ->whereRaw('DATE(created_at) >=  DATE_SUB(DATE(NOW()), INTERVAL 12 MONTH)')
        ->groupBy('device_type')
        ->orderBy('count', 'desc')
        ->get();
    }
    
    /**
     * Get Sum order total In Year
     *
     * @return  [type]  [return description]
     */
    public static function getSumOrderTotalInYear()
    {
        return self::selectRaw('DATE_FORMAT(created_at, "%Y-%m") AS ym, SUM(total/exchange_rate) AS total_amount')
            ->whereRaw('DATE_FORMAT(created_at, "%Y-%m") >=  DATE_FORMAT(DATE_SUB(CURRENT_DATE(), INTERVAL 12 MONTH), "%Y-%m")')
            ->groupBy('ym')->get();
    }

    /**
     * Get count order in Year
     *
     * @return  [type]  [return description]
     */
    public static function getCountOrderTotalInYear()
    {
        return self::selectRaw('DATE_FORMAT(created_at, "%Y-%m") AS ym, count(*) AS count')
            ->whereRaw('DATE_FORMAT(created_at, "%Y-%m") >=  DATE_FORMAT(DATE_SUB(CURRENT_DATE(), INTERVAL 12 MONTH), "%Y-%m")')
            ->groupBy('ym')->get();
    }

    /**
     * Get Sum order total In month
     *
     * @return  [type]  [return description]
     */
    public static function getSumOrderTotalInMonth()
    {
        return self::selectRaw('DATE_FORMAT(created_at, "%m-%d") AS md,
        SUM(total/exchange_rate) AS total_amount, count(id) AS total_order')
            ->whereRaw('created_at >=  DATE_FORMAT(DATE_SUB(CURRENT_DATE(), INTERVAL 1 MONTH), "%Y-%m-%d")')
            ->groupBy('md')->get();
    }


    /**
     * Get total order of system
     *
     * @return  [type]  [return description]
     */
    public static function getTotalOrder()
    {
        return self::count();
    }


    /**
     * Get count order new
     *
     * @return  [type]  [return description]
     */
    public static function getCountOrderNew()
    {
        return self::where('status', 1)
        ->count();
    }
    
    /**
     * Get total order of system
     *
     * @return  [type]  [return description]
     */
    public static function getTopOrder()
    {
        return self::with('orderStatus')
            ->orderBy('created_at', 'desc')
            ->limit(10)
            ->get();
    }

    /**
     * Sum amount order
     *
     * @param   [type]  $storeId  [$storeId description]
     *
     * @return  [type]            [return description]
     */
    public static function getSumAmountOrder($storeId = null) {
        $data = (new AdminOrder)
        ->selectRaw('sum(total) as total_sum, currency')
        ->where('status', 5);//Only process order completed
        if ($storeId) {
            $data = $data->where('store_id', $storeId);
        }
        $data = $data->groupBy('currency')
        ->get()
        ->toArray();
        return $data;
    }
}
