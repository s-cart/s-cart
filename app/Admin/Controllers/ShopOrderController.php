<?php
#app/Http/Admin/Controllers/ShopOrderController.php
namespace App\Admin\Controllers;

use App\Admin\Admin;
use App\Http\Controllers\Controller;
use App\Models\ShopAttributeGroup;
use App\Models\ShopCountry;
use App\Models\ShopCurrency;
use App\Models\ShopOrder;
use App\Models\ShopOrderDetail;
use App\Models\ShopOrderStatus;
use App\Models\ShopOrderTotal;
use App\Models\ShopPaymentStatus;
use App\Models\ShopProduct;
use App\Models\ShopShippingStatus;
use App\Models\ShopUser;
use DB;
use Illuminate\Http\Request;
use Validator;

class ShopOrderController extends Controller
{
    public $statusPayment, $statusOrder, $statusShipping, $statusOrderMap, $statusShippingMap, $currency, $country, $countryMap;

    public function __construct()
    {
        $this->statusOrder = ShopOrderStatus::getListStatus();
        $this->statusOrderMap = ShopOrderStatus::mapValue();
        $this->currency = ShopCurrency::getList();
        $this->country = ShopCountry::getArray();
        $this->countryMap = ShopCountry::mapValue();
        $this->statusPayment = ShopPaymentStatus::getListStatus();
        $this->statusShipping = ShopShippingStatus::getListStatus();
        $this->statusShippingMap = ShopShippingStatus::mapValue();

    }

    /**
     * Index interface.
     *
     * @return Content
     */
    public function index()
    {

        $data = [
            'title' => trans('order.admin.list'),
            'subTitle' => '',
            'icon' => 'fa fa-indent',
            'menuRight' => [],
            'menuLeft' => [],
            'topMenuRight' => [],
            'topMenuLeft' => [],
            'urlDeleteItem' => route('admin_order.delete'),
            'removeList' => 1, // 1 - Enable function delete list item
            'buttonRefresh' => 1, // 1 - Enable button refresh
            'buttonSort' => 1, // 1 - Enable button sort
            'css' => '', 
            'js' => '',
        ];

        $listTh = [
            'id' => trans('order.admin.id'),
            'email' => trans('order.admin.email'),
            'subtotal' => trans('order.admin.subtotal'),
            'shipping' => trans('order.admin.shipping'),
            'discount' => trans('order.admin.discount'),
            'total' => trans('order.admin.total'),
            'payment_method' => trans('order.admin.payment_method_short'),
            'currency' => trans('order.admin.currency'),
            'status' => trans('order.admin.status'),
            'created_at' => trans('order.admin.created_at'),
            'action' => trans('order.admin.action'),
        ];
        $sort_order = request('sort_order') ?? 'id_desc';
        $keyword = request('keyword') ?? '';
        $order_status = request('order_status') ?? '';
        $arrSort = [
            'id__desc' => trans('order.admin.sort_order.id_desc'),
            'id__asc' => trans('order.admin.sort_order.id_asc'),
            'email__desc' => trans('order.admin.sort_order.email_desc'),
            'email__asc' => trans('order.admin.sort_order.email_asc'),
            'created_at__desc' => trans('order.admin.sort_order.date_desc'),
            'created_at__asc' => trans('order.admin.sort_order.date_asc'),
        ];
        $obj = new ShopOrder;
        if ($keyword) {
            $obj = $obj->whereRaw('(id = ' . (int) $keyword . ' OR email like "%' . $keyword . '%" )');
        }
        if ((int) $order_status) {
            $obj = $obj->where('status', (int) $order_status);
        }
        if ($sort_order && array_key_exists($sort_order, $arrSort)) {
            $field = explode('__', $sort_order)[0];
            $sort_field = explode('__', $sort_order)[1];
            $obj = $obj->orderBy($field, $sort_field);

        } else {
            $obj = $obj->orderBy('id', 'desc');
        }
        $dataTmp = $obj->paginate(20);

        $styleStatus = $this->statusOrder;
        array_walk($styleStatus, function (&$v, $k) {
            $v = '<span class="label label-' . (ShopOrder::$mapStyleStatus[$k] ?? 'light') . '">' . $v . '</span>';
        });
        $dataTr = [];
        foreach ($dataTmp as $key => $row) {
            $dataTr[] = [
                'id' => $row['id'],
                'email' => $row['email'] ?? 'N/A',
                'subtotal' => sc_currency_render_symbol($row['subtotal'] ?? 0, $row['currency']),
                'shipping' => sc_currency_render_symbol($row['shipping'] ?? 0, $row['currency']),
                'discount' => sc_currency_render_symbol($row['discount'] ?? 0, $row['currency']),
                'total' => sc_currency_render_symbol($row['total'] ?? 0, $row['currency']),
                'payment_method' => $row['payment_method'],
                'currency' => $row['currency'] . '/' . $row['exchange_rate'],
                'status' => $styleStatus[$row['status']],
                'created_at' => $row['created_at'],
                'action' => '
                                <a href="' . route('admin_order.detail', ['id' => $row['id']]) . '"><span title="' . trans('order.admin.edit') . '" type="button" class="btn btn-flat btn-primary"><i class="fa fa-edit"></i></span></a>&nbsp;

                                <span onclick="deleteItem(' . $row['id'] . ');"  title="' . trans('admin.delete') . '" class="btn btn-flat btn-danger"><i class="fa fa-trash"></i></span>'
                ,
            ];
        }

        $data['listTh'] = $listTh;
        $data['dataTr'] = $dataTr;
        $data['pagination'] = $dataTmp->appends(request()->except(['_token', '_pjax']))->links('admin.component.pagination');
        $data['resultItems'] = trans('order.admin.result_item', ['item_from' => $dataTmp->firstItem(), 'item_to' => $dataTmp->lastItem(), 'item_total' => $dataTmp->total()]);


//menuRight
        $data['menuRight'][] = '<a href="' . route('admin_order.create') . '" class="btn  btn-success  btn-flat" title="New" id="button_create_new">
                           <i class="fa fa-plus"></i><span class="hidden-xs">' . trans('admin.add_new') . '</span>
                           </a>';
//=menuRight

//menuSort        
        $optionSort = '';
        foreach ($arrSort as $key => $status) {
            $optionSort .= '<option  ' . (($sort_order == $key) ? "selected" : "") . ' value="' . $key . '">' . $status . '</option>';
        }

        $data['urlSort'] = route('admin_order.index');
        $data['optionSort'] = $optionSort;
//=menuSort

//menuSearch        
        $optionStatus = '';
        foreach ($this->statusOrder as $key => $status) {
            $optionStatus .= '<option  ' . (($order_status == $key) ? "selected" : "") . ' value="' . $key . '">' . $status . '</option>';
        }
        $data['topMenuRight'][] = '
                <form action="' . route('admin_order.index') . '" id="button_search">
                   <div onclick="$(this).submit();" class="btn-group pull-right">
                           <a class="btn btn-flat btn-primary" title="Refresh">
                              <i class="fa  fa-search"></i><span class="hidden-xs"> ' . trans('admin.search') . '</span>
                           </a>
                   </div>
                   <div class="btn-group pull-right">
                         <div class="form-group">
                           <input type="text" name="keyword" class="form-control" placeholder="' . trans('order.admin.search_place') . '" value="' . $keyword . '">
                         </div>
                   </div>

                   <div class="btn-group pull-right"  style="margin-right: 10px">
                        <div class="form-group">
                           <select class="form-control" name="order_status">
                             <option value="">' . trans('order.admin.search_order.status') . '</option>
                             ' . $optionStatus . '
                            </select>
                        </div>
                    </div>
                </form>';
//=menuSearch


        return view('admin.screen.list')
            ->with($data);
    }

/**
 * Form create new order in admin
 * @return [type] [description]
 */
    public function create()
    {
        $data = [
            'title' => trans('order.admin.add_new_title'),
            'subTitle' => '',
            'title_description' => trans('order.admin.add_new_des'),
            'icon' => 'fa fa-plus',
        ];
        $paymentMethodTmp = sc_get_plugin_installed('payment', $onlyActive = false);
        foreach ($paymentMethodTmp as $key => $value) {
            $paymentMethod[$key] = sc_language_render($value->detail);
        }
        $shippingMethodTmp = sc_get_plugin_installed('shipping', $onlyActive = false);
        foreach ($shippingMethodTmp as $key => $value) {
            $shippingMethod[$key] = trans($value->detail);
        }
        $orderStatus = $this->statusOrder;
        $currencies = $this->currency;
        $countries = $this->country;
        $currenciesRate = json_encode(ShopCurrency::getListRate());
        $users = ShopUser::getList();
        $data['users'] = $users;
        $data['currencies'] = $currencies;
        $data['countries'] = $countries;
        $data['orderStatus'] = $orderStatus;
        $data['currenciesRate'] = $currenciesRate;
        $data['paymentMethod'] = $paymentMethod;
        $data['shippingMethod'] = $shippingMethod;

        return view('admin.screen.order_add')
            ->with($data);
    }

/**
 * Post create new order in admin
 * @return [type] [description]
 */
    public function postCreate()
    {
        $users = ShopUser::getList();
        $data = request()->all();
        $dataOrigin = request()->all();
        $validator = Validator::make($dataOrigin, [
            'first_name' => 'required',
            'last_name' => 'required',
            'user_id' => 'required',
            'country' => 'required',
            'address1' => 'required',
            'address2' => 'required',
            'currency' => 'required',
            'exchange_rate' => 'required',
            'status' => 'required',
            'payment_method' => 'required',
            'shipping_method' => 'required',
            'phone' => 'required|regex:/^0[^0][0-9\-]{7,13}$/|max:20',
        ], [
            'first_name.required' => trans('validation.required'),
            'last_name.required' => trans('validation.required'),
            'user_id.required' => trans('validation.required'),
            'country.required' => trans('validation.required'),
            'address1.required' => trans('validation.required'),
            'address2.required' => trans('validation.required'),
            'currency.required' => trans('validation.required'),
            'exchange_rate.required' => trans('validation.required'),
            'status.required' => trans('validation.required'),
            'payment_method.required' => trans('validation.required'),
            'shipping_method.required' => trans('validation.required'),
            'phone.required' => trans('validation.required'),
            'phone.regex' => trans('validation.phone'),
        ]);

        if ($validator->fails()) {
            // dd($validator->messages());
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }
//Create new order
        $dataInsert = [
            'user_id' => $data['user_id'],
            'first_name' => $data['first_name'],
            'last_name' => $data['last_name'],
            'status' => $data['status'],
            'currency' => $data['currency'],
            'address1' => $data['address1'],
            'address2' => $data['address2'],
            'country' => $data['country'],
            'phone' => $data['phone'],
            'payment_method' => $data['payment_method'],
            'shipping_method' => $data['shipping_method'],
            'exchange_rate' => $data['exchange_rate'],
            'email' => $users[$data['user_id']]['email'],
            'comment' => $data['comment'],
        ];
        $order = ShopOrder::create($dataInsert);
        ShopOrderTotal::insert([
            ['code' => 'subtotal', 'value' => 0, 'title' => 'Subtotal', 'sort' => 1, 'order_id' => $order->id],
            ['code' => 'shipping', 'value' => 0, 'title' => 'Shipping', 'sort' => 10, 'order_id' => $order->id],
            ['code' => 'discount', 'value' => 0, 'title' => 'Discount', 'sort' => 20, 'order_id' => $order->id],
            ['code' => 'total', 'value' => 0, 'title' => 'Total', 'sort' => 100, 'order_id' => $order->id],
            ['code' => 'received', 'value' => 0, 'title' => 'Received', 'sort' => 200, 'order_id' => $order->id],
        ]);
//
        return redirect()->route('admin_order.index')->with('success', trans('order.admin.create_success'));

    }

/**
 * Order detail
 * @param  [type] $id [description]
 * @return [type]     [description]
 */
    public function detail($id)
    {

        $order = ShopOrder::find($id);
        if ($order === null) {
            return 'no data';
        }
        $products = ShopProduct::getArrayProductName();
        $paymentMethodTmp = sc_get_plugin_installed('payment', $onlyActive = false);
        foreach ($paymentMethodTmp as $key => $value) {
            $paymentMethod[$key] = sc_language_render($value->detail);
        }
        $shippingMethodTmp = sc_get_plugin_installed('shipping', $onlyActive = false);
        foreach ($shippingMethodTmp as $key => $value) {
            $shippingMethod[$key] = sc_language_render($value->detail);
        }
        return view('admin.screen.order_edit')->with(
            [
                "title" => trans('order.order_detail'),
                "subTitle" => '',
                'icon' => 'fa fa-file-text-o',
                "order" => $order,
                "products" => $products,
                "statusOrder" => $this->statusOrder,
                "statusPayment" => $this->statusPayment,
                "statusShipping" => $this->statusShipping,
                "statusOrderMap" => $this->statusOrderMap,
                "statusShippingMap" => $this->statusShippingMap,
                'dataTotal' => ShopOrderTotal::getTotal($id),
                'attributesGroup' => ShopAttributeGroup::pluck('name', 'id')->all(),
                'paymentMethod' => $paymentMethod,
                'shippingMethod' => $shippingMethod,
                'countryMap' => $this->countryMap,
            ]);
    }

/**
 * [getInfoUser description]
 * @param   [description]
 * @return [type]           [description]
 */
    public function getInfoUser()
    {
        $id = request('id');
        return ShopUser::find($id)->toJson();
    }
/**
 * [getInfoProduct description]
 * @param   [description]
 * @return [type]           [description]
 */
    public function getInfoProduct()
    {
        $id = request('id');
        $sku = request('sku');
        if ($id) {
            $product = (new ShopProduct)->getDetail($id);
        } else {
            $product = (new ShopProduct)->getDetail('sku', $type = 'sku');
        }
        $arrayReturn = $product->toArray();
        $arrayReturn['renderAttDetails'] = $product->renderAttributeDetailsAdmin();
        $arrayReturn['price_final'] = $product->getFinalPrice();
        return response()->json($arrayReturn);
    }

/**
 * [postOrderUpdate description]
 * @param   [description]
 * @return [type]           [description]
 */
    public function postOrderUpdate()
    {
        $id = request('pk');
        $field = request('name');
        $value = request('value');
        if ($field == 'shipping' || $field == 'discount' || $field == 'received') {
            $order_total_origin = ShopOrderTotal::find($id);
            $order_id = $order_total_origin->order_id;
            $oldValue = $order_total_origin->value;
            $order = ShopOrder::find($order_id);
            $fieldTotal = [
                'id' => $id,
                'code' => $field,
                'value' => $value,
                'text' => sc_currency_render_symbol($value, $order->currency),
            ];
            ShopOrderTotal::updateField($fieldTotal);
        } else {
            $arrFields = [
                $field => $value,
            ];
            $order_id = $id;
            $order = ShopOrder::find($order_id);
            $oldValue = $order->{$field};
            ShopOrder::updateInfo($arrFields, $order_id);
        }

        //Add history
        $dataHistory = [
            'order_id' => $order_id,
            'content' => 'Change <b>' . $field . '</b> from <span style="color:blue">\'' . $oldValue . '\'</span> to <span style="color:red">\'' . $value . '\'</span>',
            'admin_id' => Admin::user()->id,
            'order_status_id' => $order->status,
        ];
        (new ShopOrder)->addOrderHistory($dataHistory);

        if ($order_id) {
            $orderUpdated = ShopOrder::find($order_id);
            if ($orderUpdated->balance == 0 && $orderUpdated->total != 0) {
                $style = 'style="color:#0e9e33;font-weight:bold;"';
            } else
            if ($orderUpdated->balance < 0) {
                $style = 'style="color:#ff2f00;font-weight:bold;"';
            } else {
                $style = 'style="font-weight:bold;"';
            }
            $blance = '<tr ' . $style . ' class="data-balance"><td>' . trans('order.balance') . ':</td><td align="right">' . sc_currency_format($orderUpdated->balance) . '</td></tr>';
            return response()->json(['error' => 0, 'detail' => [
                'total' => sc_currency_format($orderUpdated->total),
                'subtotal' => sc_currency_format($orderUpdated->subtotal),
                'shipping' => sc_currency_format($orderUpdated->shipping),
                'discount' => sc_currency_format($orderUpdated->discount),
                'received' => sc_currency_format($orderUpdated->received),
                'balance' => $blance,
            ],'msg' => trans('order.admin.update_success')
            ]);
        } else {
            return response()->json(['error' => 1, 'msg' => 'Error ']);
        }
    }

/**
 * [postAddItem description]
 * @param   [description]
 * @return [type]           [description]
 */
    public function postAddItem()
    {
        $data = request()->all();
        $add_id = request('add_id');
        $add_price = request('add_price');
        $add_qty = request('add_qty');
        $add_att = request('add_att');
        $order_id = request('order_id');
        $items = [];
        $order = ShopOrder::find($order_id);
        foreach ($add_id as $key => $id) {
            //where exits id and qty > 0
            if ($id && $add_qty[$key]) {
                $product = (new ShopProduct)->getDetail($id);
                $attDetails = $product->attributes->pluck('name', 'id')->all();
                $pAttr = json_encode($add_att[$id] ?? []);
                $items[] = array(
                    'order_id' => $order_id,
                    'product_id' => $id,
                    'name' => $product->name,
                    'qty' => $add_qty[$key],
                    'price' => $add_price[$key],
                    'total_price' => $add_price[$key] * $add_qty[$key],
                    'sku' => $product->sku,
                    'attribute' => $pAttr,
                    'currency' => $order->currency,
                    'exchange_rate' => $order->exchange_rate,
                    'created_at' => date('Y-m-d H:i:s'),
                );
            }
        }
        if ($items) {
            try {
                (new ShopOrderDetail)->addNewDetail($items);
                //Add history
                $dataHistory = [
                    'order_id' => $order_id,
                    'content' => "Add product: <br>" . implode("<br>", array_column($items, 'name')),
                    'admin_id' => Admin::user()->id,
                    'order_status_id' => $order->status,
                ];
                (new ShopOrder)->addOrderHistory($dataHistory);

                //Update total price
                $subtotal = ShopOrderDetail::select(DB::raw('sum(total_price) as subtotal'))
                    ->where('order_id', $order_id)
                    ->first()->subtotal;
                $updateSubTotal = ShopOrderTotal::updateSubTotal($order_id, empty($subtotal) ? 0 : $subtotal);
                //end update total price
                return response()->json(['error' => 0, 'msg' => trans('order.admin.update_success')]);
            } catch (\Exception $e) {
                return response()->json(['error' => 1, 'msg' => 'Error: ' . $e->getMessage()]);
            }

        }
        return response()->json(['error' => 0, 'msg' => trans('order.admin.update_success')]);
    }

/**
 * [postEditItem description]
 * @param   [description]
 * @return [type]           [description]
 */
    public function postEditItem()
    {
        try {
            $id = request('pk');
            $field = request('name');
            $value = request('value');
            $item = ShopOrderDetail::find($id);
            $fieldOrg = $item->{$field};
            $orderID = $item->order_id;
            $item->{$field} = $value;
            $item->total_price = $value * (($field == 'qty') ? $item->price : $item->qty);
            $item->save();
            $item = $item->fresh();
            $order = ShopOrder::find($orderID);
            //Add history
            $dataHistory = [
                'order_id' => $orderID,
                'content' => trans('product.edit_product') . ' #' . $id . ': ' . $field . ' from ' . $fieldOrg . ' -> ' . $value,
                'admin_id' => Admin::user()->id,
                'order_status_id' => $order->status,
            ];
            (new ShopOrder)->addOrderHistory($dataHistory);

            //Update stock
            if ($field == 'qty') {
                $checkQty = $value - $fieldOrg;
                //Update stock, sold
                ShopProduct::updateStock($item->product_id, $checkQty);
            }

            //Update total price
            $subtotal = ShopOrderDetail::select(DB::raw('sum(total_price) as subtotal'))
                ->where('order_id', $orderID)
                ->first()->subtotal;
            ShopOrderTotal::updateSubTotal($orderID, $subtotal);
            //end update total price

            //refresh order info after update
            $orderUpdated = $order->fresh();

            if ($orderUpdated->balance == 0 && $orderUpdated->total != 0) {
                $style = 'style="color:#0e9e33;font-weight:bold;"';
            } else
            if ($orderUpdated->balance < 0) {
                $style = 'style="color:#ff2f00;font-weight:bold;"';
            } else {
                $style = 'style="font-weight:bold;"';
            }
            $blance = '<tr ' . $style . ' class="data-balance"><td>' . trans('order.balance') . ':</td><td align="right">' . sc_currency_format($orderUpdated->balance) . '</td></tr>';
            $arrayReturn = ['error' => 0, 'detail' => [
                'total' => sc_currency_format($orderUpdated->total),
                'subtotal' => sc_currency_format($orderUpdated->subtotal),
                'shipping' => sc_currency_format($orderUpdated->shipping),
                'discount' => sc_currency_format($orderUpdated->discount),
                'received' => sc_currency_format($orderUpdated->received),
                'item_total_price' => sc_currency_render_symbol($item->total_price, $item->currency),
                'item_id' => $id,
                'balance' => $blance,
            ],'msg' => trans('order.admin.update_success')
            ];
        } catch (\Exception $e) {
            $arrayReturn = ['error' => 1, 'msg' => $e->getMessage()];
        }
        return response()->json($arrayReturn);
    }

/**
 * [postDeleteItem description]
 * @param   [description]
 * @return [type]           [description]
 */
    public function postDeleteItem()
    {
        try {
            $data = request()->all();
            $pId = $data['pId'] ?? 0;
            $itemDetail = (new ShopOrderDetail)->where('id', $pId)->first();
            $order_id = $itemDetail->order_id;
            $product_id = $itemDetail->product_id;
            $qty = $itemDetail->qty;
            $itemDetail->delete(); //Remove item from shop order detail
            $order = ShopOrder::find($order_id);
            //Update total price
            $subtotal = ShopOrderDetail::select(DB::raw('sum(total_price) as subtotal'))
                ->where('order_id', $order_id)
                ->first()->subtotal;
            ShopOrderTotal::updateSubTotal($order_id, empty($subtotal) ? 0 : $subtotal);
            //Update stock, sold
            ShopProduct::updateStock($product_id, -$qty);

            //Add history
            $dataHistory = [
                'order_id' => $order_id,
                'content' => 'Remove item pID#' . $pId,
                'admin_id' => Admin::user()->id,
                'order_status_id' => $order->status,
            ];
            (new ShopOrder)->addOrderHistory($dataHistory);
            return response()->json(['error' => 0, 'msg' => trans('order.admin.update_success')]);
        } catch (\Exception $e) {
            return response()->json(['error' => 1, 'msg' => 'Error: ' . $e->getMessage()]);

        }
    }

/*
Delete list order ID
Need mothod destroy to boot deleting in model
 */
    public function deleteList()
    {
        if (!request()->ajax()) {
            return response()->json(['error' => 1, 'msg' => 'Method not allow!']);
        } else {
            $ids = request('ids');
            $arrID = explode(',', $ids);
            ShopOrder::destroy($arrID);
            return response()->json(['error' => 0, 'msg' => trans('order.admin.update_success')]);
        }
    }

/*
Export order detail order
 */
    public function exportDetail()
    {
        $type = request('type');
        $order_id = request('order_id') ?? 0;
        $order = ShopOrder::with(['details', 'orderTotal'])->find($order_id);
        if ($order) {
            $data = array();
            $data['name'] = $order['first_name'] . ' ' . $order['last_name'];
            $data['address'] = $order['address1'] . ', ' . $order['address2'] . ', ' . $order['country'];
            $data['phone'] = $order['phone'];
            $data['email'] = $order['email'];
            $data['comment'] = $order['comment'];
            $data['payment_method'] = $order['payment_method'];
            $data['shipping_method'] = $order['shipping_method'];
            $data['created_at'] = $order['created_at'];
            $data['currency'] = $order['currency'];
            $data['exchange_rate'] = $order['exchange_rate'];
            $data['subtotal'] = $order['subtotal'];
            $data['shipping'] = $order['shipping'];
            $data['discount'] = $order['discount'];
            $data['total'] = $order['total'];
            $data['received'] = $order['received'];
            $data['balance'] = $order['balance'];
            $data['id'] = $order->id;
            $data['details'] = [];
            if ($order->details) {
                foreach ($order->details as $key => $detail) {
                    $data['details'][] = [
                        $key + 1, $detail->sku, $detail->name, $detail->qty, $detail->price, $detail->total_price,
                    ];
                }
            }
            $options = ['filename' => 'Order ' . $order_id];
            return \Export::export($type, $data, $options);

        }
    }

}
