<?php
#app/Http/Admin/Controllers/AdminOrderController.php
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

class AdminOrderController extends Controller
{
    public $statusPayment, 
    $statusOrder, 
    $statusShipping, 
    $statusOrderMap, 
    $statusShippingMap, 
    $statusPaymentMap, 
    $currency, 
    $country, 
    $countryMap;

    public function __construct()
    {
        $this->statusOrder = ShopOrderStatus::getIdAll();
        $this->currency = ShopCurrency::getListActive();
        $this->country = ShopCountry::getCodeAll();
        $this->statusPayment = ShopPaymentStatus::getIdAll();
        $this->statusShipping = ShopShippingStatus::getIdAll();

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
            'urlDeleteItem' => sc_route('admin_order.delete'),
            'removeList' => 1, // 1 - Enable function delete list item
            'buttonRefresh' => 1, // 1 - Enable button refresh
            'buttonSort' => 1, // 1 - Enable button sort
            'css' => '', 
            'js' => '',
        ];
        //Process add content
        $data['menuRight'] = sc_config_group('menuRight', \Request::route()->getName());
        $data['menuLeft'] = sc_config_group('menuLeft', \Request::route()->getName());
        $data['topMenuRight'] = sc_config_group('topMenuRight', \Request::route()->getName());
        $data['topMenuLeft'] = sc_config_group('topMenuLeft', \Request::route()->getName());
        $data['blockBottom'] = sc_config_group('blockBottom', \Request::route()->getName());

        $listTh = [
            'id' => trans('order.admin.id'),
            'email' => trans('order.admin.email'),
            'store_id' => trans('order.admin.store'),
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
            $v = '<span class="badge badge-' . (ShopOrder::$mapStyleStatus[$k] ?? 'light') . '">' . $v . '</span>';
        });
        $dataTr = [];
        foreach ($dataTmp as $key => $row) {
            $dataTr[] = [
                'id'             => $row['id'],
                'email'          => $row['email'] ?? 'N/A',
                'store_id'       => $row['store_id'],
                'subtotal'       => sc_currency_render_symbol($row['subtotal'] ?? 0, $row['currency']),
                'shipping'       => sc_currency_render_symbol($row['shipping'] ?? 0, $row['currency']),
                'discount'       => sc_currency_render_symbol($row['discount'] ?? 0, $row['currency']),
                'total'          => sc_currency_render_symbol($row['total'] ?? 0, $row['currency']),
                'payment_method' => $row['payment_method'],
                'currency'       => $row['currency'] . '/' . $row['exchange_rate'],
                'status'         => $styleStatus[$row['status']],
                'created_at'     => $row['created_at'],
                'action' => '
                                <a href="' . sc_route('admin_order.detail', ['id' => $row['id']]) . '"><span title="' . trans('order.admin.edit') . '" type="button" class="btn btn-flat btn-primary"><i class="fa fa-edit"></i></span></a>&nbsp;

                                <span onclick="deleteItem(' . $row['id'] . ');"  title="' . trans('admin.delete') . '" class="btn btn-flat btn-danger"><i class="fas fa-trash-alt"></i></span>'
                ,
            ];
        }

        $data['listTh'] = $listTh;
        $data['dataTr'] = $dataTr;
        $data['pagination'] = $dataTmp->appends(request()->except(['_token', '_pjax']))->links('admin.component.pagination');
        $data['resultItems'] = trans('order.admin.result_item', ['item_from' => $dataTmp->firstItem(), 'item_to' => $dataTmp->lastItem(), 'item_total' => $dataTmp->total()]);


//menuRight
        $data['menuRight'][] = '<a href="' . sc_route('admin_order.create') . '" class="btn  btn-success  btn-flat" title="New" id="button_create_new">
                           <i class="fa fa-plus" title="'.trans('admin.add_new').'"></i>
                           </a>';
//=menuRight

//menuSort        
        $optionSort = '';
        foreach ($arrSort as $key => $status) {
            $optionSort .= '<option  ' . (($sort_order == $key) ? "selected" : "") . ' value="' . $key . '">' . $status . '</option>';
        }

        $data['urlSort'] = sc_route('admin_order.index');
        $data['optionSort'] = $optionSort;
//=menuSort

//menuSearch        
        $optionStatus = '';
        foreach ($this->statusOrder as $key => $status) {
            $optionStatus .= '<option  ' . (($order_status == $key) ? "selected" : "") . ' value="' . $key . '">' . $status . '</option>';
        }
        $data['topMenuRight'][] = '
                <form action="' . sc_route('admin_order.index') . '" id="button_search">
                    <div class="input-group input-group float-left">
                        <div class="btn-group">
                        <select class="form-control" name="order_status" id="order_sort">
                        ' . $optionStatus . '
                        </select>
                    </div>
                    <input type="text" name="keyword" class="form-control float-right" placeholder="' . trans('order.admin.search_place') . '" value="' . $keyword . '">
                    <div class="input-group-append">
                        <button type="submit" class="btn btn-primary"><i class="fas fa-search"></i></button>
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
        $users = ShopUser::getListAll();
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
        $users = ShopUser::getListAll();
        $data = request()->all();
        $validate = [
            'first_name' => 'required|max:100',
            'address1' => 'required|max:100',
            'exchange_rate' => 'required',
            'currency' => 'required',
            'status' => 'required',
            'payment_method' => 'required',
            'shipping_method' => 'required',
        ];
        if(sc_config('customer_lastname')) {
            $validate['last_name'] = 'required|max:100';
        }
        if(sc_config('customer_address2')) {
            $validate['address2'] = 'required|max:100';
        }
        if(sc_config('customer_phone')) {
            $validate['phone'] = 'required|regex:/^0[^0][0-9\-]{7,13}$/';
        }
        if(sc_config('customer_country')) {
            $validate['country'] = 'required|min:2';
        }
        if(sc_config('customer_postcode')) {
            $validate['postcode'] = 'required|min:5';
        }
        if(sc_config('customer_company')) {
            $validate['company'] = 'required|min:3';
        }
        $messages = [
            'last_name.required' => trans('validation.required',['attribute'=> trans('cart.last_name')]),
            'first_name.required' => trans('validation.required',['attribute'=> trans('cart.first_name')]),
            'email.required' => trans('validation.required',['attribute'=> trans('cart.email')]),
            'address1.required' => trans('validation.required',['attribute'=> trans('cart.address1')]),
            'address2.required' => trans('validation.required',['attribute'=> trans('cart.address2')]),
            'phone.required' => trans('validation.required',['attribute'=> trans('cart.phone')]),
            'country.required' => trans('validation.required',['attribute'=> trans('cart.country')]),
            'postcode.required' => trans('validation.required',['attribute'=> trans('cart.postcode')]),
            'company.required' => trans('validation.required',['attribute'=> trans('cart.company')]),
            'sex.required' => trans('validation.required',['attribute'=> trans('cart.sex')]),
            'birthday.required' => trans('validation.required',['attribute'=> trans('cart.birthday')]),
            'email.email' => trans('validation.email',['attribute'=> trans('cart.email')]),
            'phone.regex' => trans('validation.regex',['attribute'=> trans('cart.phone')]),
            'postcode.min' => trans('validation.min',['attribute'=> trans('cart.postcode')]),
            'country.min' => trans('validation.min',['attribute'=> trans('cart.country')]),
            'first_name.max' => trans('validation.max',['attribute'=> trans('cart.first_name')]),
            'email.max' => trans('validation.max',['attribute'=> trans('cart.email')]),
            'address1.max' => trans('validation.max',['attribute'=> trans('cart.address1')]),
            'address2.max' => trans('validation.max',['attribute'=> trans('cart.address2')]),
            'last_name.max' => trans('validation.max',['attribute'=> trans('cart.last_name')]),
            'birthday.date' => trans('validation.date',['attribute'=> trans('cart.birthday')]),
            'birthday.date_format' => trans('validation.date_format',['attribute'=> trans('cart.birthday')]),
            'shipping_method.required' => trans('cart.validation.shippingMethod_required'),
            'payment_method.required' => trans('cart.validation.paymentMethod_required'),
        ];


        $validator = Validator::make($data, $validate, $messages);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }
        //Create new order
        $dataInsert = [
            'user_id' => $data['user_id'],
            'first_name' => $data['first_name'],
            'last_name' => $data['last_name'] ?? '',
            'status' => $data['status'],
            'currency' => $data['currency'],
            'address1' => $data['address1'],
            'address2' => $data['address2'] ?? '',
            'country' => $data['country'] ?? '',
            'company' => $data['company'] ?? '',
            'postcode' => $data['postcode'] ?? '',
            'phone' => $data['phone'] ?? '',
            'payment_method' => $data['payment_method'],
            'shipping_method' => $data['shipping_method'],
            'exchange_rate' => $data['exchange_rate'],
            'email' => $users[$data['user_id']]['email'],
            'comment' => $data['comment'],
        ];
        $order = ShopOrder::create($dataInsert);
        ShopOrderTotal::insert([
            ['code' => 'subtotal', 'value' => 0, 'title' => 'Subtotal', 'sort' => 1, 'order_id' => $order->id],
            ['code' => 'tax', 'value' => 0, 'title' => 'Tax', 'sort' => 2, 'order_id' => $order->id],
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
                'dataTotal' => ShopOrderTotal::getTotal($id),
                'attributesGroup' => ShopAttributeGroup::pluck('name', 'id')->all(),
                'paymentMethod' => $paymentMethod,
                'shippingMethod' => $shippingMethod,
                'country' => $this->country,
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
        $order_id = request('order_id');
        $oder = ShopOrder::find($order_id);
        if ($id) {
            $product = (new ShopProduct)->getDetail($id);
        } else {
            $product = (new ShopProduct)->getDetail('sku', $type = 'sku');
        }
        $arrayReturn = $product->toArray();
        $arrayReturn['renderAttDetails'] = $product->renderAttributeDetailsAdmin($oder->currency, $oder->exchange_rate);
        $arrayReturn['price_final'] = $product->getFinalPrice();
        return response()->json($arrayReturn);
    }

    /**
     * process update order
     * @return [json]           [description]
     */
    public function postOrderUpdate()
    {
        $id = request('pk');
        $code = request('name');
        $value = request('value');
        if ($code == 'shipping' || $code == 'discount' || $code == 'received') {
            $order_total_origin = ShopOrderTotal::find($id);
            $order_id = $order_total_origin->order_id;
            $oldValue = $order_total_origin->value;
            $order = ShopOrder::find($order_id);
            $rowTotal = [
                'id' => $id,
                'code' => $code,
                'value' => $value,
                'text' => sc_currency_render_symbol($value, $order->currency),
            ];
            ShopOrderTotal::updateRowTotal($rowTotal);
        } else {
            $order_id = $id;
            $order = ShopOrder::find($order_id);
            $oldValue = $order->{$code};
            $order->update([$code => $value]);
        }

        //Add history
        $dataHistory = [
            'order_id' => $order_id,
            'content' => 'Change <b>' . $code . '</b> from <span style="color:blue">\'' . $oldValue . '\'</span> to <span style="color:red">\'' . $value . '\'</span>',
            'admin_id' => Admin::user()->id,
            'order_status_id' => $order->status,
        ];
        (new ShopOrder)->addOrderHistory($dataHistory);

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
        return response()->json(['error' => 0, 'detail' => 
            [
                'total' => sc_currency_format($orderUpdated->total),
                'subtotal' => sc_currency_format($orderUpdated->subtotal),
                'tax' => sc_currency_format($orderUpdated->tax),
                'shipping' => sc_currency_format($orderUpdated->shipping),
                'discount' => sc_currency_format($orderUpdated->discount),
                'received' => sc_currency_format($orderUpdated->received),
                'balance' => $blance,
            ],
            'msg' => trans('order.admin.update_success')
        ]);
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
        $add_tax = request('add_tax');
        $order_id = request('order_id');
        $items = [];
        $order = ShopOrder::find($order_id);
        foreach ($add_id as $key => $id) {
            //where exits id and qty > 0
            if ($id && $add_qty[$key]) {
                $product = (new ShopProduct)->getDetail($id);
                $pAttr = json_encode($add_att[$id] ?? []);
                $items[] = array(
                    'order_id' => $order_id,
                    'product_id' => $id,
                    'name' => $product->name,
                    'qty' => $add_qty[$key],
                    'price' => $add_price[$key],
                    'total_price' => $add_price[$key] * $add_qty[$key],
                    'sku' => $product->sku,
                    'tax' => $add_tax[$key],
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

                ShopOrderTotal::updateSubTotal($order_id);
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
            ShopOrderTotal::updateSubTotal($orderID);
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
                'tax' => sc_currency_format($orderUpdated->tax),
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
            ShopOrderTotal::updateSubTotal($order_id);
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
            $data['tax'] = $order['tax'];
            $data['shipping'] = $order['shipping'];
            $data['discount'] = $order['discount'];
            $data['total'] = $order['total'];
            $data['received'] = $order['received'];
            $data['balance'] = $order['balance'];
            $data['id'] = $order->id;
            $data['details'] = [];

            $attributesGroup =  ShopAttributeGroup::pluck('name', 'id')->all();

            if ($order->details) {
                foreach ($order->details as $key => $detail) {
                    $arrAtt = json_decode($detail->attribute, true);
                    if($arrAtt) {
                        $htmlAtt = '';
                        foreach ($arrAtt as $groupAtt => $att) {
                            $htmlAtt .= $attributesGroup[$groupAtt] .':'.sc_render_option_price($att, $order['currency'], $order['exchange_rate']);
                        }
                        $name = $detail->name.'('.strip_tags($htmlAtt).')';
                    } else {
                        $name = $detail->name;
                    }
                    $data['details'][] = [
                        $key + 1, $detail->sku, $name, $detail->qty, $detail->price, $detail->total_price,
                    ];
                }
            }
            $options = ['filename' => 'Order ' . $order_id];
            return \Export::export($type, $data, $options);

        }
    }

}
