<?php
#app/Http/Controller/ShopCart.php
namespace App\Http\Controllers;

use App\Models\ShopEmailTemplate;
use App\Models\ShopAttributeGroup;
use App\Models\ShopCountry;
use App\Models\ShopOrder;
use App\Models\ShopOrderTotal;
use App\Models\ShopProduct;
use App\Models\ShopUserAddress;
use Cart;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ShopCart extends GeneralController
{
    const ORDER_STATUS_NEW = 1;
    const PAYMENT_UNPAID = 1;
    const SHIPPING_NOTSEND = 1;

    public function __construct()
    {
        parent::__construct();

    }
    /**
     * Get list cart: screen get cart
     * @return [type] [description]
     */
    public function getCart()
    {
        session()->forget('paymentMethod'); //destroy paymentMethod
        session()->forget('shippingMethod'); //destroy shippingMethod
        session()->forget('orderID'); //destroy orderID
        
        //Shipping
        $moduleShipping = sc_get_plugin_installed('shipping');
        $sourcesShipping = sc_get_all_plugin('shipping');
        $shippingMethod = array();
        foreach ($moduleShipping as $module) {
            if (array_key_exists($module['key'], $sourcesShipping)) {
                $moduleClass = sc_get_class_plugin_config('shipping', $module['key']);
                $shippingMethod[$module['key']] = (new $moduleClass)->getData();
            }
        }

        //Payment
        $modulePayment = sc_get_plugin_installed('payment');
        $sourcesPayment = sc_get_all_plugin('payment');
        $paymentMethod = array();
        foreach ($modulePayment as $module) {
            if (array_key_exists($module['key'], $sourcesPayment)) {
                $moduleClass = $sourcesPayment[$module['key']].'\AppConfig';
                $paymentMethod[$module['key']] = (new $moduleClass)->getData();
            }
        }        

        //Total
        $moduleTotal = sc_get_plugin_installed('total');
        $sourcesTotal = sc_get_all_plugin('total');
        $totalMethod = array();
        foreach ($moduleTotal as $module) {
            if (array_key_exists($module['key'], $sourcesTotal)) {
                $moduleClass = $sourcesTotal[$module['key']].'\AppConfig';
                $totalMethod[$module['key']] = (new $moduleClass)->getData();
            }
        } 

        // Shipping address
        $user = auth()->user();
        if ($user) {
            $address = $user->getAddressDefault();
            if ($address) {
                $addressDefaul = [
                    'first_name'      => $address->first_name,
                    'last_name'       => $address->last_name,
                    'first_name_kana' => $address->first_name_kana,
                    'last_name_kana'  => $address->last_name_kana,
                    'email'           => $user->email,
                    'address1'        => $address->address1,
                    'address2'        => $address->address2,
                    'postcode'        => $address->postcode,
                    'company'         => $user->company,
                    'country'         => $address->country,
                    'phone'           => $address->phone,
                    'comment'         => '',
                ];
            } else {
                $addressDefaul = [
                    'first_name'      => $user->first_name,
                    'last_name'       => $user->last_name,
                    'first_name_kana' => $user->first_name_kana,
                    'last_name_kana'  => $user->last_name_kana,
                    'email'           => $user->email,
                    'address1'        => $user->address1,
                    'address2'        => $user->address2,
                    'postcode'        => $user->postcode,
                    'company'         => $user->company,
                    'country'         => $user->country,
                    'phone'           => $user->phone,
                    'comment'         => '',
                ];
            }

        } else {
            $addressDefaul = [
                'first_name'      => '',
                'last_name'       => '',
                'first_name_kana' => '',
                'last_name_kana'  => '',
                'postcode'        => '',
                'company'         => '',
                'email'           => '',
                'address1'        => '',
                'address2'        => '',
                'country'         => '',
                'phone'           => '',
                'comment'         => '',
            ];
        }
        $shippingAddress = session('shippingAddress') ?? $addressDefaul;
        $objects = ShopOrderTotal::getObjectOrderTotal();
        return view(
            $this->templatePath . '.screen.shop_cart',
            [
                'title'           => trans('front.cart_title'),
                'description'     => '',
                'keyword'         => '',
                'cart'            => Cart::instance('default')->content(),
                'shippingMethod'  => $shippingMethod,
                'paymentMethod'   => $paymentMethod,
                'totalMethod'     => $totalMethod,
                'addressList'     => auth()->user() ? auth()->user()->addresses : [],
                'dataTotal'       => ShopOrderTotal::processDataTotal($objects),
                'shippingAddress' => $shippingAddress,
                'layout_page'     => 'shop_cart',
                'countries'       => ShopCountry::getCodeAll(),
                'attributesGroup' => ShopAttributeGroup::pluck('name', 'id')->all(),
            ]
        );
    }

    /**
     * Process Cart, prepare for the checkout screen
     */
    public function processCart()
    {
        if (Cart::instance('default')->count() == 0) {
            return redirect()->route('cart');
        }

        //Not allow for guest
        if (!sc_config('shop_allow_guest') && !auth()->user()) {
            return redirect()->route('login');
        }


        $validate = [
            'first_name'     => 'required|max:100',
            'email'          => 'required|string|email|max:255',
            'shippingMethod' => 'required',
            'paymentMethod'  => 'required',
        ];
        if (sc_config('customer_lastname')) {
            if (sc_config('customer_lastname_required')) {
                $validate['last_name'] = 'required|string|max:100';
            } else {
                $validate['last_name'] = 'nullable|string|max:100';
            }
        }
        if (sc_config('customer_address1')) {
            if (sc_config('customer_address1_required')) {
                $validate['address1'] = 'required|string|max:100';
            } else {
                $validate['address1'] = 'nullable|string|max:100';
            }
        }

        if (sc_config('customer_address2')) {
            if (sc_config('customer_address2_required')) {
                $validate['address2'] = 'required|string|max:100';
            } else {
                $validate['address2'] = 'nullable|string|max:100';
            }
        }
        if (sc_config('customer_phone')) {
            if (sc_config('customer_phone_required')) {
                $validate['phone'] = 'required|regex:/^0[^0][0-9\-]{7,13}$/';
            } else {
                $validate['phone'] = 'nullable|regex:/^0[^0][0-9\-]{7,13}$/';
            }
        }
        if (sc_config('customer_country')) {
            $arraycountry = (new ShopCountry)->pluck('code')->toArray();
            if (sc_config('customer_country_required')) {
                $validate['country'] = 'required|string|min:2|in:'. implode(',', $arraycountry);
            } else {
                $validate['country'] = 'nullable|string|min:2|in:'. implode(',', $arraycountry);
            }
        }

        if (sc_config('customer_postcode')) {
            if (sc_config('customer_postcode_required')) {
                $validate['postcode'] = 'required|min:5';
            } else {
                $validate['postcode'] = 'nullable|min:5';
            }
        }
        if (sc_config('customer_company')) {
            if (sc_config('customer_company_required')) {
                $validate['company'] = 'required|string|max:100';
            } else {
                $validate['company'] = 'nullable|string|max:100';
            }
        } 

        if (sc_config('customer_name_kana')) {
            if (sc_config('customer_name_kana_required')) {
                $validate['first_name_kana'] = 'required|string|max:100';
                $validate['last_name_kana'] = 'required|string|max:100';
            } else {
                $validate['first_name_kana'] = 'nullable|string|max:100';
                $validate['last_name_kana'] = 'nullable|string|max:100';
            }
        }

        $messages = [
            'last_name.required'      => trans('validation.required',['attribute'=> trans('cart.last_name')]),
            'first_name.required'     => trans('validation.required',['attribute'=> trans('cart.first_name')]),
            'email.required'          => trans('validation.required',['attribute'=> trans('cart.email')]),
            'address1.required'       => trans('validation.required',['attribute'=> trans('cart.address1')]),
            'address2.required'       => trans('validation.required',['attribute'=> trans('cart.address2')]),
            'phone.required'          => trans('validation.required',['attribute'=> trans('cart.phone')]),
            'country.required'        => trans('validation.required',['attribute'=> trans('cart.country')]),
            'postcode.required'       => trans('validation.required',['attribute'=> trans('cart.postcode')]),
            'company.required'        => trans('validation.required',['attribute'=> trans('cart.company')]),
            'sex.required'            => trans('validation.required',['attribute'=> trans('cart.sex')]),
            'birthday.required'       => trans('validation.required',['attribute'=> trans('cart.birthday')]),
            'email.email'             => trans('validation.email',['attribute'=> trans('cart.email')]),
            'phone.regex'             => trans('validation.regex',['attribute'=> trans('cart.phone')]),
            'postcode.min'            => trans('validation.min',['attribute'=> trans('cart.postcode')]),
            'country.min'             => trans('validation.min',['attribute'=> trans('cart.country')]),
            'first_name.max'          => trans('validation.max',['attribute'=> trans('cart.first_name')]),
            'email.max'               => trans('validation.max',['attribute'=> trans('cart.email')]),
            'address1.max'            => trans('validation.max',['attribute'=> trans('cart.address1')]),
            'address2.max'            => trans('validation.max',['attribute'=> trans('cart.address2')]),
            'last_name.max'           => trans('validation.max',['attribute'=> trans('cart.last_name')]),
            'birthday.date'           => trans('validation.date',['attribute'=> trans('cart.birthday')]),
            'birthday.date_format'    => trans('validation.date_format',['attribute'=> trans('cart.birthday')]),
            'shippingMethod.required' => trans('cart.validation.shippingMethod_required'),
            'paymentMethod.required'  => trans('cart.validation.paymentMethod_required'),
        ];

        $v = Validator::make(
            request()->all(), 
            $validate, 
            $messages
        );
        if ($v->fails()) {
            return redirect()->back()
                ->withInput()
                ->withErrors($v->errors());
        }

        //Set session shippingMethod
        session(['shippingMethod' => request('shippingMethod')]);
        //Set session paymentMethod
        session(['paymentMethod' => request('paymentMethod')]);
        //Set session address process
        session(['address_process' => request('address_process')]);
        //Set session shippingAddressshippingAddress
        session(
            [
                'shippingAddress' => [
                    'first_name'      => request('first_name'),
                    'last_name'       => request('last_name'),
                    'first_name_kana' => request('first_name_kana'),
                    'last_name_kana'  => request('last_name_kana'),
                    'email'           => request('email'),
                    'country'         => request('country'),
                    'address1'        => request('address1'),
                    'address2'        => request('address2'),
                    'phone'           => request('phone'),
                    'postcode'        => request('postcode'),
                    'company'         => request('company'),
                    'comment'         => request('comment'),
                ],
            ]
        );

        //Check minimum
        $arrCheckQty = [];
        $cart = Cart::instance('default')->content()->toArray();
        foreach ($cart as $key => $row) {
            $arrCheckQty[$row['id']] = ($arrCheckQty[$row['id']] ?? 0) + $row['qty'];
        }
        $arrProductMinimum = ShopProduct::whereIn('id', array_keys($arrCheckQty))->pluck('minimum', 'id')->all();
        $arrErrorQty = [];
        foreach ($arrProductMinimum as $pId => $min) {
            if ($arrCheckQty[$pId] < $min) {
                $arrErrorQty[$pId] = $min;
            }
        }
        if (count($arrErrorQty)) {
            return redirect()->route('cart')->with('arrErrorQty', $arrErrorQty);
        }
        //End check minimum

        return redirect()->route('checkout');
    }

    /**
     * Checkout screen
     * @return [view]
     */
    public function getCheckout()
    {
        if (
            !session('shippingMethod') ||
            !session('paymentMethod') ||
            !session('shippingAddress')
        ) {
            return redirect()->route('cart');
        }

        $paymentMethod = session('paymentMethod');
        $shippingMethod = session('shippingMethod');
        $shippingAddress = session('shippingAddress');

        //Shipping
        $classShippingMethod = sc_get_class_plugin_config('Shipping', $shippingMethod);
        $shippingMethodData = (new $classShippingMethod)->getData();

        //Payment
        $classPaymentMethod = sc_get_class_plugin_config('Payment', $paymentMethod);
        $paymentMethodData = (new $classPaymentMethod)->getData();

        $objects = ShopOrderTotal::getObjectOrderTotal();
        $dataTotal = ShopOrderTotal::processDataTotal($objects);

        //Set session dataTotal
        session(['dataTotal' => $dataTotal]);

        return view(
            $this->templatePath . '.screen.shop_checkout',
            [
                'title'              => trans('front.checkout_title'),
                'cart'               => Cart::instance('default')->content(),
                'dataTotal'          => $dataTotal,
                'paymentMethodData'  => $paymentMethodData,
                'shippingMethodData' => $shippingMethodData,
                'shippingAddress'    => $shippingAddress,
                'attributesGroup'    => ShopAttributeGroup::getListAll(),
                'layout_page'        => 'shop_cart',
            ]
        );
    }

    /**
     * Add to cart by method post, always use in the product page detail
     * 
     * @return [redirect]
     */
    public function addToCart()
    {
        $data = request()->all();
        $productId = $data['product_id'];

        //Process attribute price
        $formAttr = $data['form_attr'] ?? null;
        $optionPrice  = 0;
        if ($formAttr) {
            foreach ($formAttr as $key => $attr) {
                $optionPrice += explode('__', $attr)[1] ??0;
            }
        }
        //End addtribute price

        $qty = $data['qty'];
        $product = (new ShopProduct)->getDetail($productId);
        if ($product->allowSale()) {
            $options = array();
            $options = $formAttr;
            $dataCart = array(
                'id'    => $productId,
                'name'  => $product->name,
                'qty'   => $qty,
                'price' => $product->getFinalPrice() + $optionPrice,
                'tax'   => $product->getTaxValue(),
            );
            if ($options) {
                $dataCart['options'] = $options;
            }
            Cart::instance('default')->add($dataCart);
            return redirect()->route('cart')
                ->with(
                    ['success' => trans('cart.success', ['instance' => 'cart'])]
                );
        } else {
            return redirect()->route('cart')
                ->with(
                    ['error' => trans('cart.dont_allow_sale')]
                );
        }

    }

    /**
     * Create new order
     * @return [redirect]
     */
    public function addOrder(Request $request)
    {
        $user = auth()->user();
        if (Cart::instance('default')->count() == 0) {
            return redirect()->route('home');
        }
        //Not allow for guest
        if (!sc_config('shop_allow_guest') && !$user) {
            return redirect()->route('login');
        } //

        $data = request()->all();
        if (!$data) {
            return redirect()->route('cart');
        } else {
            $dataTotal       = session('dataTotal') ?? [];
            $shippingAddress = session('shippingAddress') ?? [];
            $paymentMethod   = session('paymentMethod') ?? '';
            $shippingMethod  = session('shippingMethod') ?? '';
            $address_process = session('address_process') ?? '';
        }
        $uID = $user->id ?? 0;
        //Process total
        $subtotal = (new ShopOrderTotal)->sumValueTotal('subtotal', $dataTotal); //sum total
        $tax      = (new ShopOrderTotal)->sumValueTotal('tax', $dataTotal); //sum tax
        $shipping = (new ShopOrderTotal)->sumValueTotal('shipping', $dataTotal); //sum shipping
        $discount = (new ShopOrderTotal)->sumValueTotal('discount', $dataTotal); //sum discount
        $received = (new ShopOrderTotal)->sumValueTotal('received', $dataTotal); //sum received
        $total    = (new ShopOrderTotal)->sumValueTotal('total', $dataTotal);
        //end total

        $dataOrder['user_id']         = $uID;
        $dataOrder['subtotal']        = $subtotal;
        $dataOrder['shipping']        = $shipping;
        $dataOrder['discount']        = $discount;
        $dataOrder['received']        = $received;
        $dataOrder['tax']             = $tax;
        $dataOrder['payment_status']  = self::PAYMENT_UNPAID;
        $dataOrder['shipping_status'] = self::SHIPPING_NOTSEND;
        $dataOrder['status']          = self::ORDER_STATUS_NEW;
        $dataOrder['currency']        = sc_currency_code();
        $dataOrder['exchange_rate']   = sc_currency_rate();
        $dataOrder['total']           = $total;
        $dataOrder['balance']         = $total + $received;
        $dataOrder['email']           = $shippingAddress['email'];
        $dataOrder['first_name']      = $shippingAddress['first_name'];
        $dataOrder['payment_method']  = $paymentMethod;
        $dataOrder['shipping_method'] = $shippingMethod;
        $dataOrder['user_agent']      = $request->header('User-Agent');
        $dataOrder['ip']              = $request->ip();
        $dataOrder['created_at']      = date('Y-m-d H:i:s');

        if (!empty($shippingAddress['last_name'])) {
            $dataOrder['last_name']       = $shippingAddress['last_name'];
        }
        if (!empty($shippingAddress['first_name_kana'])) {
            $dataOrder['first_name_kana']       = $shippingAddress['first_name_kana'];
        }
        if (!empty($shippingAddress['last_name_kana'])) {
            $dataOrder['last_name_kana']       = $shippingAddress['last_name_kana'];
        }
        if (!empty($shippingAddress['address1'])) {
            $dataOrder['address1']       = $shippingAddress['address1'];
        }
        if (!empty($shippingAddress['address2'])) {
            $dataOrder['address2']       = $shippingAddress['address2'];
        }
        if (!empty($shippingAddress['country'])) {
            $dataOrder['country']       = $shippingAddress['country'];
        }
        if (!empty($shippingAddress['phone'])) {
            $dataOrder['phone']       = $shippingAddress['phone'];
        }
        if (!empty($shippingAddress['postcode'])) {
            $dataOrder['postcode']       = $shippingAddress['postcode'];
        }
        if (!empty($shippingAddress['company'])) {
            $dataOrder['company']       = $shippingAddress['company'];
        }
        if (!empty($shippingAddress['comment'])) {
            $dataOrder['comment']       = $shippingAddress['comment'];
        }

        $arrCartDetail = [];
        foreach (Cart::instance('default')->content() as $cartItem) {
            $arrDetail['product_id']  = $cartItem->id;
            $arrDetail['name']        = $cartItem->name;
            $arrDetail['price']       = sc_currency_value($cartItem->price);
            $arrDetail['qty']         = $cartItem->qty;
            $arrDetail['attribute']   = ($cartItem->options) ? json_encode($cartItem->options) : null;
            $arrDetail['total_price'] = sc_currency_value($cartItem->price) * $cartItem->qty;
            $arrCartDetail[]          = $arrDetail;
        }

        //Set session info order
        session(['dataOrder' => $dataOrder]);
        session(['arrCartDetail' => $arrCartDetail]);

        //Create new order
        $createOrder = (new ShopOrder)->createOrder($dataOrder, $dataTotal, $arrCartDetail);

        if ($createOrder['error'] == 1) {
            return redirect()->route('cart')->with(['error' => $createOrder['msg']]);
        }
        //Set session orderID
        session(['orderID' => $createOrder['orderID']]);

        //Create new address
        if ($address_process == 'new') {
            $addressNew = [
                'first_name'      => $shippingAddress['first_name'] ?? '',
                'last_name'       => $shippingAddress['last_name'] ?? '',
                'first_name_kana' => $shippingAddress['first_name_kana'] ?? '',
                'last_name_kana'  => $shippingAddress['last_name_kana'] ?? '',
                'postcode'        => $shippingAddress['postcode'] ?? '',
                'address1'        => $shippingAddress['address1'] ?? '',
                'address2'        => $shippingAddress['address2'] ?? '',
                'country'         => $shippingAddress['country'] ?? '',
                'phone'           => $shippingAddress['phone'] ?? '',
            ];
            $user->addresses()->save(new ShopUserAddress(sc_clean($addressNew)));
            session()->forget('address_process'); //destroy address_process
        }

        $paymentMethod = sc_get_class_plugin_controller('Payment', session('paymentMethod'));

        return (new $paymentMethod)->processOrder();

    }

    /**
     * Add product to cart
     * @param Request $request [description]
     * @return [json]
     */
    public function addToCartAjax(Request $request)
    {
        if (!$request->ajax()) {
            return redirect()->route('cart');
        }
        $instance = request('instance') ?? 'default';
        $cart = Cart::instance($instance);
        $id = request('id');
        $product = (new ShopProduct)->getDetail($id);
        switch ($instance) {
            case 'default':
                if ($product->attributes->count() || $product->kind == SC_PRODUCT_GROUP) {
                    //Products have attributes or kind is group,
                    //need to select properties before adding to the cart
                    return response()->json(
                        [
                            'error' => 1,
                            'redirect' => $product->getUrl(),
                            'msg' => '',
                        ]
                    );
                }

                //Check product allow for sale
                if ($product->allowSale()) {
                    $cart->add(
                        array(
                            'id'    => $id,
                            'name'  => $product->name,
                            'qty'   => 1,
                            'price' => $product->getFinalPrice(),
                            'tax'   => $product->getTaxValue(),
                        )
                    );
                } else {
                    return response()->json(
                        [
                            'error' => 1,
                            'msg' => trans('cart.dont_allow_sale'),
                        ]
                    );
                }
                break;

            default:
                //Wishlist or Compare...
                ${'arrID' . $instance} = array_keys($cart->content()->groupBy('id')->toArray());
                if (!in_array($id, ${'arrID' . $instance})) {
                    try {
                        $cart->add(
                            array(
                                'id'    => $id,
                                'name'  => $product->name,
                                'qty'   => 1,
                                'price' => $product->getFinalPrice(),
                                'tax'   => $product->getTaxValue(),
                            )
                        );
                    } catch (\Exception $e) {
                        return response()->json(
                            [
                                'error' => 1,
                                'msg' => $e->getMessage(),
                            ]
                        );
                    }

                } else {
                    return response()->json(
                        [
                            'error' => 1,
                            'msg' => trans('cart.exist', ['instance' => $instance]),
                        ]
                    );
                }
                break;
        }

        $carts = Cart::getListCart($instance);
        
        return response()->json(
            [
                'error'      => 0,
                'count_cart' => $carts['count'],
                'instance'   => $instance,
                'subtotal'   => $carts['subtotal'],
                'msg'        => trans('cart.success', ['instance' => ($instance == 'default') ? 'cart' : $instance]),
            ]
        );

    }

    /**
     * Update product to cart
     * @param  Request $request [description]
     * @return [json]
     */
    public function updateToCart(Request $request)
    {
        if (!$request->ajax()) {
            return redirect()->route('cart');
        }
        $id = request('id');
        $rowId = request('rowId');
        $product = (new ShopProduct)->getDetail($id);
        $new_qty = request('new_qty');
        if ($product->stock < $new_qty && !sc_config('product_buy_out_of_stock')) {
            return response()->json(
                [
                    'error' => 1,
                    'msg' => trans('cart.over', ['item' => $product->sku]),
                ]
            );
        } else {
            Cart::instance('default')->update($rowId, ($new_qty) ? $new_qty : 0);
            return response()->json(
                [
                    'error' => 0,
                ]
            );
        }

    }

    /**
     * Get product in wishlist
     * @return [view]
     */
    public function wishlist()
    {

        $wishlist = Cart::instance('wishlist')->content();
        return view($this->templatePath . '.screen.shop_wishlist',
            array(
                'title'       => trans('front.wishlist'),
                'description' => '',
                'keyword'     => '',
                'wishlist'    => $wishlist,
                'layout_page' => 'shop_cart',
            )
        );
    }

    /**
     * Get product in compare
     * @return [view]
     */
    public function compare()
    {
        $compare = Cart::instance('compare')->content();

        return view($this->templatePath . '.screen.shop_compare',
            array(
                'title'       => trans('front.compare'),
                'description' => '',
                'keyword'     => '',
                'compare'     => $compare,
                'layout_page' => 'shop_cart',
            )
        );
    }

    /**
     * Clear all cart
     * @return [redirect]
     */
    public function clearCart($instance = 'default')
    {
        Cart::instance($instance)->destroy();
        return redirect()->route('cart');
    }

    /**
     * Remove item from cart
     * @return [redirect]
     */
    public function removeItem($id = null)
    {
        if ($id === null) {
            return redirect()->route('cart');
        }

        if (array_key_exists($id, Cart::instance('default')->content()->toArray())) {
            Cart::instance('default')->remove($id);
        }
        return redirect()->route('cart');
    }

    /**
     * Remove item from wishlist
     * @param  [string | null] $id
     * @return [redirect]
     */
    public function removeItemWishlist($id = null)
    {
        if ($id === null) {
            return redirect()->route('wishlist');
        }

        if (array_key_exists($id, Cart::instance('wishlist')->content()->toArray())) {
            Cart::instance('wishlist')->remove($id);
        }
        return redirect()->route('wishlist');
    }

    /**
     * Remove item from compare
     * @param  [string | null] $id
     * @return [redirect]
     */
    public function removeItemCompare($id = null)
    {
        if ($id === null) {
            return redirect()->route('compare');
        }

        if (array_key_exists($id, Cart::instance('compare')->content()->toArray())) {
            Cart::instance('compare')->remove($id);
        }
        return redirect()->route('compare');
    }

    /**
     * Complete order
     *
     * @return [redirect]
     */
    public function completeOrder()
    {
        $orderID = session('orderID') ??0;
        if ($orderID == 0){
            return redirect()->route('home', ['error' => 'Error Order ID!']);
        }
        Cart::destroy(); // destroy cart

        $paymentMethod = session('paymentMethod');
        $shippingMethod = session('shippingMethod');
        $totalMethod = session('totalMethod', []);

        $classPaymentConfig = sc_get_class_plugin_config('Payment', $paymentMethod);
        if (method_exists($classPaymentConfig, 'endApp')) {
            (new $classPaymentConfig)->endApp();
        }

        $classShippingConfig = sc_get_class_plugin_config('Shipping', $shippingMethod);
        if (method_exists($classShippingConfig, 'endApp')) {
            (new $classShippingConfig)->endApp();
        }

        if ($totalMethod && is_array($totalMethod)) {
            foreach ($totalMethod as $keyMethod => $valueMethod) {
                $classTotalConfig = sc_get_class_plugin_config('Total', $keyMethod);
                if (method_exists($classTotalConfig, 'endApp')) {
                    (new $classTotalConfig)->endApp(['orderID' => $orderID, 'code' => $valueMethod]);
                }
            }
        }

        session()->forget('paymentMethod'); //destroy paymentMethod
        session()->forget('shippingMethod'); //destroy shippingMethod
        session()->forget('totalMethod'); //destroy totalMethod
        session()->forget('otherMethod'); //destroy otherMethod
        session()->forget('dataTotal'); //destroy dataTotal
        session()->forget('dataOrder'); //destroy dataOrder
        session()->forget('arrCartDetail'); //destroy arrCartDetail
        session()->forget('orderID'); //destroy orderID

        if (sc_config('order_success_to_admin') || sc_config('order_success_to_customer')) {
            $data = ShopOrder::with('details')->find($orderID)->toArray();
            $checkContent = (new ShopEmailTemplate)->where('group', 'order_success_to_admin')->where('status', 1)->first();
            $checkContentCustomer = (new ShopEmailTemplate)->where('group', 'order_success_to_customer')->where('status', 1)->first();
            if ($checkContent || $checkContentCustomer) {

                $orderDetail = '';
                $orderDetail .= '<tr>
                                    <td>' . trans('email.order.sort') . '</td>
                                    <td>' . trans('email.order.sku') . '</td>
                                    <td>' . trans('email.order.name') . '</td>
                                    <td>' . trans('email.order.price') . '</td>
                                    <td>' . trans('email.order.qty') . '</td>
                                    <td>' . trans('email.order.total') . '</td>
                                </tr>';
                foreach ($data['details'] as $key => $detail) {
                    $orderDetail .= '<tr>
                                    <td>' . ($key + 1) . '</td>
                                    <td>' . $detail['sku'] . '</td>
                                    <td>' . $detail['name'] . '</td>
                                    <td>' . sc_currency_render($detail['price'], '', '', '', false) . '</td>
                                    <td>' . number_format($detail['qty']) . '</td>
                                    <td align="right">' . sc_currency_render($detail['total_price'], '', '', '', false) . '</td>
                                </tr>';
                }
                $dataFind = [
                    '/\{\{\$title\}\}/',
                    '/\{\{\$orderID\}\}/',
                    '/\{\{\$firstName\}\}/',
                    '/\{\{\$lastName\}\}/',
                    '/\{\{\$toname\}\}/',
                    '/\{\{\$address\}\}/',
                    '/\{\{\$address1\}\}/',
                    '/\{\{\$address2\}\}/',
                    '/\{\{\$email\}\}/',
                    '/\{\{\$phone\}\}/',
                    '/\{\{\$comment\}\}/',
                    '/\{\{\$orderDetail\}\}/',
                    '/\{\{\$subtotal\}\}/',
                    '/\{\{\$shipping\}\}/',
                    '/\{\{\$discount\}\}/',
                    '/\{\{\$total\}\}/',
                ];
                $dataReplace = [
                    trans('order.send_mail.new_title') . '#' . $orderID,
                    $orderID,
                    $data['first_name'],
                    $data['last_name'],
                    $data['first_name'].' '.$data['last_name'],
                    $data['address1'] . ' ' . $data['address2'],
                    $data['address1'],
                    $data['address2'],
                    $data['email'],
                    $data['phone'],
                    $data['comment'],
                    $orderDetail,
                    sc_currency_render($data['subtotal'], '', '', '', false),
                    sc_currency_render($data['shipping'], '', '', '', false),
                    sc_currency_render($data['discount'], '', '', '', false),
                    sc_currency_render($data['total'], '', '', '', false),
                ];

                if (sc_config('order_success_to_admin') && $checkContent) {
                    $content = $checkContent->text;
                    $content = preg_replace($dataFind, $dataReplace, $content);
                    $dataView = [
                        'content' => $content,
                    ];
                    $config = [
                        'to' => sc_store('email'),
                        'subject' => trans('order.send_mail.new_title') . '#' . $orderID,
                    ];
                    sc_send_mail($this->templatePath . '.mail.order_success_to_admin', $dataView, $config, []);
                }
                if (sc_config('order_success_to_customer') && $checkContentCustomer) {
                    $contentCustomer = $checkContentCustomer->text;
                    $contentCustomer = preg_replace($dataFind, $dataReplace, $contentCustomer);
                    $dataView = [
                        'content' => $contentCustomer,
                    ];
                    $config = [
                        'to' => $data['email'],
                        'replyTo' => sc_store('email'),
                        'subject' => trans('order.send_mail.new_title'),
                    ];
                    sc_send_mail($this->templatePath . '.mail.order_success_to_customer', $dataView, $config, []);
                }
            }

        }

        return redirect()->route('order.success')->with('orderID', $orderID);
    }

    /**
     * Page order success
     *
     * @return  [view]
     */
    public function orderSuccess(){

        if (!session('orderID')) {
            return redirect()->route('home');
        }
        return view(
            $this->templatePath . '.screen.shop_order_success',
            [
                'title' => trans('order.success.title'),
                'layout_page' =>'shop_cart',
            ]
        );
    }

}
