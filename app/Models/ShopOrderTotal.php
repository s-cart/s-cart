<?php
#app/Models/ShopOrderTotal.php
namespace App\Models;

use App\Models\ShopOrder;
use App\Models\ShopCurrency;
use Cart;
use Illuminate\Database\Eloquent\Model;

class ShopOrderTotal extends Model
{
    protected $table = SC_DB_PREFIX.'shop_order_total';
    protected $fillable = ['order_id', 'title', 'code', 'value', 'text', 'sort'];
    protected $connection = SC_CONNECTION;
    protected $guarded = [];
    const POSITION_SUBTOTAL = 1;
    const POSITION_TAX = 2;
    const POSITION_SHIPPING_METHOD = 10;
    const POSITION_TOTAL_METHOD = 20;
    const POSITION_TOTAL = 100;
    const POSITION_RECEIVED = 200;
    const NOT_YET_PAY = 0;
    const PART_PAY = 1;
    const PAID = 2;
    const NEED_REFUND = 3;

    /**
     * Process data order total
     * @param  array      $objects  [description]
     * @return [array]    order total after process
     */
    public static function processDataTotal(array $objects = [])
    {
        $carts  = ShopCurrency::sumCart(Cart::instance('default')->content());
        $subtotal = $carts['subTotal'];
        $tax = $carts['subTotalWithTax'] - $carts['subTotal'];

        //Set subtotal
        $arraySubtotal = [
            'title' => trans('order.totals.sub_total'),
            'code' => 'subtotal',
            'value' => $subtotal,
            'text' => sc_currency_render_symbol($subtotal),
            'sort' => self::POSITION_SUBTOTAL,
        ];

        //Set tax
        $arrayTax = [
            'title' => trans('order.totals.tax'),
            'code' => 'tax',
            'value' => $tax,
            'text' => sc_currency_render_symbol($tax),
            'sort' => self::POSITION_TAX,
        ];



        // set total value
        $total = $subtotal + $tax;
        foreach ($objects as $key => $object) {
            if (is_array($object) && $object) {
                if ($object['code'] != 'received') {
                    $total += $object['value'];
                }
            } else {
                unset($objects[$key]);
            }
        }
        $arrayTotal = array(
            'title' => trans('order.totals.total'),
            'code' => 'total',
            'value' => $total,
            'text' => sc_currency_render_symbol($total),
            'sort' => self::POSITION_TOTAL,
        );
        //End total value

        $objects[] = $arraySubtotal;
        $objects[] = $arrayTax;
        $objects[] = $arrayTotal;

        //re-sort item total
        usort($objects, function ($a, $b) {
            return $a['sort'] > $b['sort'];
        });
        //

        return $objects;
    }

    /**
     * Get sum value in order total
     * @param  string $code      [description]
     * @param  arra $dataTotal [description]
     * @return int            [description]
     */
    public function sumValueTotal($code, $dataTotal)
    {
        $keys = array_keys(array_column($dataTotal, 'code'), $code);
        $value = 0;
        foreach ($keys as $object) {
            $value += $dataTotal[$object]['value'];
        }
        return $value;
    }

    /**
     * Get shipping method
     */
    public static function getShippingMethod()
    {
        $arrShipping = [];
        $shippingMethod = session('shippingMethod') ?? '';
        if ($shippingMethod) {
            $moduleClass = sc_get_class_plugin_config('Shipping', $shippingMethod);
            $returnModuleShipping = (new $moduleClass)->getData();
            $arrShipping = [
                'title' => $returnModuleShipping['title'],
                'code' => 'shipping',
                'value' => sc_currency_value($returnModuleShipping['value']),
                'text' => sc_currency_render($returnModuleShipping['value']),
                'sort' => self::POSITION_SHIPPING_METHOD,
            ];
        }
        return $arrShipping;
    }

    /**
     * Get payment method
     */
    public static function getPaymentMethod()
    {
        $arrPayment = [];
        $paymentMethod = session('paymentMethod') ?? '';
        if ($paymentMethod) {
            $moduleClass = sc_get_class_plugin_config('Paypal', $paymentMethod);
            $returnModulePayment = (new $moduleClass)->getData();
            $arrPayment = [
                'title' => $returnModulePayment['title'],
                'method' => $paymentMethod,
            ];
        }
        return $arrPayment;
    }

    /**
     * Get total method
     */
    public static function getTotalMethod()
    {
        $totalMethod = [];

        $totalMethod = session('totalMethod', []);
        if($totalMethod && is_array($totalMethod)) {
            foreach ($totalMethod as $keyMethod => $valueMethod) {
                $classTotalConfig = sc_get_class_plugin_config('Total', $keyMethod);
                $returnModuleTotal = (new $classTotalConfig)->getData();
                $totalMethod[] = [
                    'title' => $returnModuleTotal['title'],
                    'code' => 'discount',
                    'value' => $returnModuleTotal['value'],
                    'text' => sc_currency_render_symbol($returnModuleTotal['value']),
                    'sort' => self::POSITION_TOTAL_METHOD,
                ];
            }
        }
        if(!count($totalMethod)) {
            $totalMethod[] = array(
                'title' => trans('order.totals.discount'),
                'code' => 'discount',
                'value' => 0,
                'text' => 0,
                'sort' => self::POSITION_TOTAL_METHOD,
            );
        }
        return $totalMethod;
    }

    /**
     * Get received value
     */
    public static function getReceived()
    {
        return array(
            'title' => trans('order.totals.received'),
            'code' => 'received',
            'value' => 0,
            'text' => 0,
            'sort' => self::POSITION_RECEIVED,
        );
    }

    /**
     * Get item order total, then re-sort
     * @param  [int] $order_id [description]
     * @return [array]           [description]
     */
    public static function getTotal($order_id)
    {
        $objects = self::where('order_id', $order_id)->get()->toArray();
        usort($objects, function ($a, $b) {
            return $a['sort'] > $b['sort'];
        });
        return $objects;
    }

    /**
     * Update new sub total
     * @param  [int] $order_id [description]
     * @return [type]           [description]
     */
    public static function updateSubTotal($order_id)
    {
        try {
            $order = ShopOrder::find($order_id);
            $details = $order->details;
            $tax = $subTotal = 0;
            if($details->count()) {
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
                $payment_status = self::NOT_YET_PAY; //Not pay
            } elseif ($balance < 0) {
                $payment_status = self::NEED_REFUND; //Need refund
            } elseif ($balance == 0) {
                $payment_status = self::PAID; //Paid
            } else {
                $payment_status = self::PART_PAY; //Part pay
            }
            $order->payment_status = $payment_status;
            $order->total = $total;
            $order->balance = $balance;
            $order->save();

            //Update total
            $updateTotal = self::where('order_id', $order_id)
                ->where('code', 'total')
                ->first();
            $updateTotal->value = $total;
            $updateTotal->save();
            
            //Update Subtotal
            $updateSubTotal = self::where('order_id', $order_id)
                ->where('code', 'subtotal')
                ->first();
            $updateSubTotal->value = $subTotal;
            $updateSubTotal->save();

            //Update tax
            $updateSubTotal = self::where('order_id', $order_id)
            ->where('code', 'tax')
            ->first();
            $updateSubTotal->value = $tax;
            $updateSubTotal->save();

            return 1;
        } catch (\Exception $e) {
            return $e->getMessage();
        }
    }

    /**
     * Update data when row of total change
     * @param  [array] $row [description]
     * @return [void]
     */
    public static function updateRowTotal($row)
    {
        //Udate row
        $upField = self::find($row['id']);
        $upField->value = $row['value'];
        $upField->text = $row['text'];
        $upField->updated_at = date('Y-m-d H:i:s');
        $upField->save();
        $order_id = $upField->order_id;

        //Sum value item order total
        $totalData = self::where('order_id', $order_id)->get();
        $total = $discount = $shipping = $received = 0;
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
            if ($value['code'] === 'shipping') {
                $shipping += $value['value'];
                $total += $value['value'];
            }
            if ($value['code'] === 'received') {
                $received += $value['value'];
            }
        }

        //Update total
        $updateTotal = self::where('order_id', $order_id)
            ->where('code', 'total')
            ->first();
        $updateTotal->value = $total;
        $updateTotal->save();

        //Update Order
        $order = ShopOrder::find($order_id);
        $order->discount = $discount;
        $order->shipping = $shipping;
        $order->received = $received;
        $order->balance = $total + $received;
        $order->total = $total;
        $order->save();
    }

    /**
     * Get object total for order
     */
    public static function getObjectOrderTotal(){
        $objects = array();
        $objects[] = self::getShippingMethod();
        foreach (self::getTotalMethod() as  $totalMethod) {
            $objects[] = $totalMethod;
        }
        $objects[] = self::getReceived();
        return $objects;
    }

}
