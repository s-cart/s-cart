<?php
namespace App\Pmo\Front\Controllers;

use App\Pmo\Front\Controllers\RootFrontController;
use App\Pmo\Front\Models\ShopAttributeGroup;
use App\Pmo\Front\Models\ShopCountry;
use App\Pmo\Front\Models\ShopOrder;
use App\Pmo\Front\Models\ShopOrderTotal;
use App\Pmo\Front\Models\ShopProduct;
use App\Pmo\Front\Models\ShopCustomer;
use App\Pmo\Front\Models\ShopCustomerAddress;
use Cart;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ShopCartController extends RootFrontController
{
    const ORDER_STATUS_NEW = 1;
    const PAYMENT_UNPAID   = 1;
    const SHIPPING_NOTSEND = 1;

    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Process front get cart
     *
     * Step 01.1
     *
     * @param [type] ...$params
     * @return void
     */
    public function getCartFront(...$params)
    {
        if (config('app.seoLang')) {
            $lang = $params[0] ?? '';
            sc_lang_switch($lang);
        }
        return $this->_getCart();
    }

    /**
     * Get list cart: screen get cart
     * Step 01.2
     * @return [type] [description]
     */
    private function _getCart()
    {
        //Clear session
        $this->clearSession();
        
        $cart = Cart::content();

        sc_check_view($this->templatePath . '.screen.shop_cart');
        return view(
            $this->templatePath . '.screen.shop_cart',
            [
                'title'           => sc_language_render('cart.cart_title'),
                'description'     => '',
                'keyword'         => '',
                'cart'            => $cart,
                'attributesGroup' => ShopAttributeGroup::pluck('name', 'id')->all(),
                'layout_page'     => 'shop_cart',
                'breadcrumbs'  => [
                    ['url' => '', 'title' => sc_language_render('cart.cart_title')],
                ],
            ]
        );
    }


    /**
     * Prepare data checkout
     * Submit page cart
     * Step 02
     */
    public function prepareCheckout()
    {
        $customer = auth()->user();

        //Not allow for guest
        if (!sc_config('shop_allow_guest') && !$customer) {
            return redirect(sc_route('login'));
        }

        $data = request()->all();

        $storeId = $data['store_id'] ?? 0;

        //If not exist store Id
        if (!$storeId) {
            return redirect(sc_route('cart'))->with(['error' => sc_language_render('cart.cart_store_id_notfound')]);
        }

        $cartGroup = Cart::getItemsGroupByStore();

        //Check cart store empty
        if (empty($cartGroup[$storeId])) {
            return redirect(sc_route('cart'))->with(['error' => sc_language_render('cart.cart_store_empty')]);
        }

        //Check minimum
        $arrCheckQty = [];
        $cart = $cartGroup[$storeId];
        foreach ($cart as $key => $row) {
            $qtyUpdate = (int)$data['qty-'.$row->rowId];
            Cart::update($row->rowId, $qtyUpdate);
            
            $newQty = ($arrCheckQty[$row->row] ?? 0) + ($data['qty-'.$row->id] ?? 0);
            $arrCheckQty[$row->id] = $newQty;
        }
        $arrProductMinimum = ShopProduct::whereIn('id', array_keys($arrCheckQty))->pluck('minimum', 'id')->all();
        $arrErrorQty = [];
        foreach ($arrProductMinimum as $pId => $min) {
            if ($arrCheckQty[$pId] < $min) {
                $arrErrorQty[$pId] = $min;
            }
        }
        if (count($arrErrorQty)) {
            return redirect(sc_route('cart'))->with(['arrErrorQty' => $arrErrorQty, 'error'=> sc_language_render('cart.have_error')]);
        }
        //End check minimum

        //Set session
        session(['dataCheckout' => $cart]);
        session(['storeCheckout' => $storeId]);

        return redirect(sc_route('checkout'));
    }


    /**
     * Process front checkout screen
     *
     * Step 03.1
     *
     * @param [type] ...$params
     * @return void
     */
    public function getCheckoutFront(...$params)
    {
        if (config('app.seoLang')) {
            $lang = $params[0] ?? '';
            sc_lang_switch($lang);
        }
        return $this->_getCheckout();
    }


    /**
     * Screen checkout
     *
     * Step 03.2
     *
     * @return [type] [description]
     */
    private function _getCheckout()
    {
        $dataCheckout = session('dataCheckout') ?? '';
        $storeCheckout = session('storeCheckout') ?? '';
        //If cart info empty
        if (!$dataCheckout || !$storeCheckout) {
            return redirect(sc_route('cart'))->with(['error' => sc_language_render('cart.cart_empty')]);
        }

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
        $customer = auth()->user();
        if ($customer) {
            $address = $customer->getAddressDefault();
            if ($address) {
                $addressDefaul = [
                    'first_name'      => $address->first_name,
                    'last_name'       => $address->last_name,
                    'first_name_kana' => $address->first_name_kana,
                    'last_name_kana'  => $address->last_name_kana,
                    'email'           => $customer->email,
                    'address1'        => $address->address1,
                    'address2'        => $address->address2,
                    'address3'        => $address->address3,
                    'postcode'        => $address->postcode,
                    'company'         => $customer->company,
                    'country'         => $address->country,
                    'phone'           => $address->phone,
                    'comment'         => '',
                ];
            } else {
                $addressDefaul = [
                    'first_name'      => $customer->first_name,
                    'last_name'       => $customer->last_name,
                    'first_name_kana' => $customer->first_name_kana,
                    'last_name_kana'  => $customer->last_name_kana,
                    'email'           => $customer->email,
                    'address1'        => $customer->address1,
                    'address2'        => $customer->address2,
                    'address3'        => $customer->address3,
                    'postcode'        => $customer->postcode,
                    'company'         => $customer->company,
                    'country'         => $customer->country,
                    'phone'           => $customer->phone,
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
                'address3'        => '',
                'country'         => '',
                'phone'           => '',
                'comment'         => '',
            ];
        }
        $shippingAddress = session('shippingAddress') ?? $addressDefaul;
        $objects = ShopOrderTotal::getObjectOrderTotal();

        //Process captcha
        $viewCaptcha = '';
        if (sc_captcha_method() && in_array('checkout', sc_captcha_page())) {
            if (view()->exists(sc_captcha_method()->pathPlugin.'::render')) {
                $dataView = [
                    'titleButton' => sc_language_render('cart.checkout'),
                    'idForm' => 'sc_form-process',
                    'idButtonForm' => 'sc_button-form-process',
                ];
                $viewCaptcha = view(sc_captcha_method()->pathPlugin.'::render', $dataView)->render();
            }
        }

        //Check view
        sc_check_view($this->templatePath . '.screen.shop_checkout');

        return view(
            $this->templatePath . '.screen.shop_checkout',
            [
                'title'           => sc_language_render('cart.checkout'),
                'description'     => '',
                'keyword'         => '',
                'cartItem'        => $dataCheckout,
                'storeCheckout'   => $storeCheckout,
                'shippingMethod'  => $shippingMethod,
                'paymentMethod'   => $paymentMethod,
                'totalMethod'     => $totalMethod,
                'addressList'     => $customer ? $customer->addresses : [],
                'dataTotal'       => ShopOrderTotal::processDataTotal($objects),
                'shippingAddress' => $shippingAddress,
                'countries'       => ShopCountry::getCodeAll(),
                'attributesGroup' => ShopAttributeGroup::pluck('name', 'id')->all(),
                'viewCaptcha'     => $viewCaptcha,
                'layout_page'     => 'shop_checkout',
                'breadcrumbs'     => [
                    ['url'        => '', 'title' => sc_language_render('cart.checkout')],
                ],
            ]
        );
    }


    /**
     * Checkout process, from screen checkout to checkout confirm
     *
     * Step 04
     *
     */
    public function processCheckout()
    {
        $dataCheckout  = session('dataCheckout') ?? '';
        $storeCheckout = session('storeCheckout') ?? '';
        //If cart info empty
        if (!$dataCheckout || !$storeCheckout) {
            return redirect(sc_route('cart'))->with(['error' => sc_language_render('cart.cart_empty')]);
        }

        $customer = auth()->user();

        //Not allow for guest
        if (!sc_config('shop_allow_guest') && !$customer) {
            return redirect(sc_route('login'));
        }

        $data = request()->all();

        $dataMap = sc_order_mapping_validate();
        $validate = $dataMap['validate'];
        $messages = $dataMap['messages'];

        if (sc_captcha_method() && in_array('checkout', sc_captcha_page())) {
            $data['captcha_field'] = $data[sc_captcha_method()->getField()] ?? '';
            $validate['captcha_field'] = ['required', 'string', new \App\Pmo\Rules\CaptchaRule];
        }

        $v = Validator::make(
            $data,
            $validate,
            $messages
        );

        if ($v->fails()) {
            return redirect()->back()
                ->withInput()
                ->withErrors($v->errors());
        }

        //Set session shippingMethod
        if (!sc_config('shipping_off')) {
            session(['shippingMethod' => request('shippingMethod')]);
        }

        //Set session paymentMethod
        if (!sc_config('payment_off')) {
            session(['paymentMethod' => request('paymentMethod')]);
        }

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
                    'address3'        => request('address3'),
                    'phone'           => request('phone'),
                    'postcode'        => request('postcode'),
                    'company'         => request('company'),
                    'comment'         => request('comment'),
                ],
            ]
        );

        //Check minimum
        $arrCheckQty = [];
        $cart = $dataCheckout;
        foreach ($cart as $key => $row) {
            $arrCheckQty[$row->id] = ($arrCheckQty[$row->id] ?? 0) + $row->qty;
        }
        $arrProductMinimum = ShopProduct::whereIn('id', array_keys($arrCheckQty))->pluck('minimum', 'id')->all();
        $arrErrorQty = [];
        foreach ($arrProductMinimum as $pId => $min) {
            if ($arrCheckQty[$pId] < $min) {
                $arrErrorQty[$pId] = $min;
            }
        }
        if (count($arrErrorQty)) {
            return redirect(sc_route('cart'))->with('arrErrorQty', $arrErrorQty);
        }
        //End check minimum

        return redirect(sc_route('checkout.confirm'))->with('step', 'checkout.confirm');
    }



    /**
     * Process front checkout confirm screen
     *
     * Step 05.1
     *
     * @param [type] ...$params
     * @return void
     */
    public function getCheckoutConfirmFront(...$params)
    {
        if (config('app.seoLang')) {
            $lang = $params[0] ?? '';
            sc_lang_switch($lang);
        }
        return $this->_getCheckoutConfirm();
    }

    /**
     * Checkout screen
     *
     * Step 05.2
     *
     * @return [view]
     */
    private function _getCheckoutConfirm()
    {
        //Check shipping address
        if (
            !session('shippingAddress')
        ) {
            return redirect(sc_route('cart'));
        }
        $shippingAddress = session('shippingAddress');


        //Shipping method
        if (sc_config('shipping_off')) {
            $shippingMethodData = null;
        } else {
            if (!session('shippingMethod')) {
                return redirect(sc_route('cart'));
            }
            $shippingMethod = session('shippingMethod');
            $classShippingMethod = sc_get_class_plugin_config('Shipping', $shippingMethod);
            $shippingMethodData = (new $classShippingMethod)->getData();
        }

        //Payment method
        if (sc_config('payment_off')) {
            $paymentMethodData = null;
        } else {
            if (!session('paymentMethod')) {
                return redirect(sc_route('cart'));
            }
            $paymentMethod = session('paymentMethod');
            $classPaymentMethod = sc_get_class_plugin_config('Payment', $paymentMethod);
            $paymentMethodData = (new $classPaymentMethod)->getData();
        }

        //Check plugin invalid
        if (!sc_config(session('shippingMethod'))) {
            return redirect(sc_route('cart'))->with(['error' => 'Plugin shipping invalid!']);
        }
        if (!sc_config(session('paymentMethod'))) {
            return redirect(sc_route('cart'))->with(['error' => 'Plugin payment invalid!']);
        }
        //End check plugin invalid
        
        //Screen confirm only active if submit from screen checkout
        if (session('step', '') != 'checkout.confirm') {
            return redirect(sc_route('checkout'));
        }

        $objects = ShopOrderTotal::getObjectOrderTotal();
        $dataTotal = ShopOrderTotal::processDataTotal($objects);

        //Set session dataTotal
        session(['dataTotal' => $dataTotal]);

        sc_check_view($this->templatePath . '.screen.shop_checkout_confirm');
        return view(
            $this->templatePath . '.screen.shop_checkout_confirm',
            [
                'title'              => sc_language_render('checkout.page_title'),
                'cart'               => session('dataCheckout'),
                'dataTotal'          => $dataTotal,
                'paymentMethodData'  => $paymentMethodData,
                'shippingMethodData' => $shippingMethodData,
                'shippingAddress'    => $shippingAddress,
                'attributesGroup'    => ShopAttributeGroup::getListAll(),
                'layout_page'        => 'shop_checkout_confirm',
                'breadcrumbs'        => [
                    ['url'           => '', 'title' => sc_language_render('checkout.page_title')],
                ],
            ]
        );
    }

    /**
     * Create new order
     *
     * Step 06
     *
     * @return [redirect]
     */
    public function addOrder(Request $request)
    {
        $agent = new \Jenssegers\Agent\Agent();
        $customer = auth()->user();
        $uID = $customer->id ?? 0;

        //if cart empty
        if (count(session('dataCheckout', [])) == 0) {
            return redirect()->route('home');
        }
        //Not allow for guest
        if (!sc_config('shop_allow_guest') && !$customer) {
            return redirect(sc_route('login'));
        } //

        $data = request()->all();
        if (!$data) {
            return redirect(sc_route('cart'));
        } else {
            $dataTotal       = session('dataTotal') ?? [];
            $shippingAddress = session('shippingAddress') ?? [];
            $paymentMethod   = session('paymentMethod') ?? '';
            $shippingMethod  = session('shippingMethod') ?? '';
            $address_process = session('address_process') ?? '';
            $storeCheckout   = session('storeCheckout') ?? '';
            $dataCheckout    = session('dataCheckout') ?? '';
        }

        //Process total
        $subtotal = (new ShopOrderTotal)->sumValueTotal('subtotal', $dataTotal); //sum total
        $tax      = (new ShopOrderTotal)->sumValueTotal('tax', $dataTotal); //sum tax
        $shipping = (new ShopOrderTotal)->sumValueTotal('shipping', $dataTotal); //sum shipping
        $discount = (new ShopOrderTotal)->sumValueTotal('discount', $dataTotal); //sum discount
        $otherFee = (new ShopOrderTotal)->sumValueTotal('other_fee', $dataTotal); //sum other_fee
        $received = (new ShopOrderTotal)->sumValueTotal('received', $dataTotal); //sum received
        $total    = (new ShopOrderTotal)->sumValueTotal('total', $dataTotal);
        //end total

        $dataOrder['store_id']        = $storeCheckout;
        $dataOrder['customer_id']     = $uID;
        $dataOrder['subtotal']        = $subtotal;
        $dataOrder['shipping']        = $shipping;
        $dataOrder['discount']        = $discount;
        $dataOrder['other_fee']        = $otherFee;
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
        $dataOrder['device_type']      = $agent->deviceType();
        $dataOrder['ip']              = $request->ip();
        $dataOrder['created_at']      = sc_time_now();

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
        if (!empty($shippingAddress['address3'])) {
            $dataOrder['address3']       = $shippingAddress['address3'];
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
        foreach ($dataCheckout as $cartItem) {
            $arrDetail['product_id']  = $cartItem->id;
            $arrDetail['name']        = $cartItem->name;
            $arrDetail['price']       = sc_currency_value($cartItem->price);
            $arrDetail['qty']         = $cartItem->qty;
            $arrDetail['store_id']    = $cartItem->storeId;
            $arrDetail['attribute']   = ($cartItem->options) ? $cartItem->options->toArray() : null;
            $arrDetail['total_price'] = sc_currency_value($cartItem->price) * $cartItem->qty;
            $arrCartDetail[]          = $arrDetail;
        }

        //Set session info order
        session(['dataOrder' => $dataOrder]);
        session(['arrCartDetail' => $arrCartDetail]);

        //Create new order
        $newOrder = (new ShopOrder)->createOrder($dataOrder, $dataTotal, $arrCartDetail);

        if ($newOrder['error'] == 1) {
            sc_report($newOrder['msg']);
            return redirect(sc_route('cart'))->with(['error' => $newOrder['msg']]);
        }
        //Set session orderID
        session(['orderID' => $newOrder['orderID']]);

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
                'address3'        => $shippingAddress['address3'] ?? '',
                'country'         => $shippingAddress['country'] ?? '',
                'phone'           => $shippingAddress['phone'] ?? '',
            ];

            //Process escape
            $addressNew = sc_clean($addressNew);

            ShopCustomer::find($uID)->addresses()->save(new ShopCustomerAddress($addressNew));
            session()->forget('address_process'); //destroy address_process
        }

        $paymentMethod = sc_get_class_plugin_controller('Payment', session('paymentMethod'));

        if ($paymentMethod) {
            // Check payment method
            return (new $paymentMethod)->processOrder();
        } else {
            return (new ShopCartController)->completeOrder();
        }
    }


    /**
     * Add to cart by method post, always use in the product page detail
     *
     * @return [redirect]
     */
    public function addToCart()
    {
        $data      = request()->all();

        //Process escape
        $data      = sc_clean($data);

        $productId = $data['product_id'];
        $qty       = $data['qty'] ?? 0;
        $storeId   = $data['storeId'] ?? config('app.storeId');

        //Process attribute price
        $formAttr = $data['form_attr'] ?? [];
        $optionPrice  = 0;
        if ($formAttr) {
            foreach ($formAttr as $key => $attr) {
                $optionPrice += explode('__', $attr)[1] ??0;
            }
        }
        //End attribute price

        $product = (new ShopProduct)->getDetail($productId, null, $storeId);

        if (!$product) {
            return response()->json(
                [
                    'error' => 1,
                    'msg' => sc_language_render('front.data_notfound'),
                ]
            );
        }
        

        if ($product->allowSale()) {
            $options = $formAttr;
            $dataCart = array(
                'id'      => $productId,
                'name'    => $product->name,
                'qty'     => $qty,
                'price'   => $product->getFinalPrice() + $optionPrice,
                'tax'     => $product->getTaxValue(),
                'storeId' => $storeId,
            );
            $dataCart['options'] = $options;
            Cart::add($dataCart);
            return redirect(sc_route('cart'))
                ->with(
                    ['success' => sc_language_render('cart.add_to_cart_success', ['instance' => 'cart'])]
                );
        } else {
            return redirect(sc_route('cart'))
                ->with(
                    ['error' => sc_language_render('product.dont_allow_sale', ['sku' => $product->sku])]
                );
        }
    }


    /**
     * Add product to cart
     * @param Request $request [description]
     * @return [json]
     */
    public function addToCartAjax(Request $request)
    {
        if (!$request->ajax()) {
            return redirect(sc_route('cart'));
        }
        $data     = request()->all();
        $instance = $data['instance'] ?? 'default';
        $id       = $data['id'] ?? '';
        $storeId  = $data['storeId'] ?? config('app.storeId');
        $cart     = Cart::instance($instance);

        $product = (new ShopProduct)->getDetail($id, null, $storeId);
        if (!$product) {
            return response()->json(
                [
                    'error' => 1,
                    'msg' => sc_language_render('front.data_notfound'),
                ]
            );
        }
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
                            'id'      => $id,
                            'name'    => $product->name,
                            'qty'     => 1,
                            'price'   => $product->getFinalPrice(),
                            'tax'     => $product->getTaxValue(),
                            'storeId' => $storeId,
                        )
                    );
                } else {
                    return response()->json(
                        [
                            'error' => 1,
                            'msg' => sc_language_render('product.dont_allow_sale', ['sku' => $product->sku]),
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
                                'id'      => $id,
                                'name'    => $product->name,
                                'qty'     => 1,
                                'price'   => $product->getFinalPrice(),
                                'tax'     => $product->getTaxValue(),
                                'storeId' => $storeId,
                            )
                        );
                    } catch (\Throwable $e) {
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
                            'msg' => sc_language_render('cart.item_exist_in_cart', ['instance' => $instance]),
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
                'msg'        => sc_language_render('cart.add_to_cart_success', ['instance' => ($instance == 'default') ? 'cart' : $instance]),
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
            return redirect(sc_route('cart'));
        }
        $data    = request()->all();
        $id      = $data['id'] ?? '';
        $rowId   = $data['rowId'] ?? '';
        $new_qty = $data['new_qty'] ?? 0;
        $storeId = $data['storeId'] ?? config('app.storeId');
        $product = (new ShopProduct)->getDetail($id, null, $storeId);
        
        if (!$product) {
            return response()->json(
                [
                    'error' => 1,
                    'msg' => sc_language_render('front.data_notfound'),
                ]
            );
        }
        
        if ($product->stock < $new_qty && !sc_config('product_buy_out_of_stock', $product->store_id)) {
            return response()->json(
                [
                    'error' => 1,
                    'msg' => sc_language_render('cart.item_over_qty', ['sku' => $product->sku, 'qty' => $new_qty]),
                ]
            );
        } else {
            Cart::update($rowId, ($new_qty) ? $new_qty : 0);
            return response()->json(
                [
                    'error' => 0,
                ]
            );
        }
    }

    /**
     * Process front wishlist
     *
     * @param [type] ...$params
     * @return void
     */
    public function wishlistProcessFront(...$params)
    {
        if (config('app.seoLang')) {
            $lang = $params[0] ?? '';
            sc_lang_switch($lang);
        }
        return $this->_wishlist();
    }

    /**
     * Get product in wishlist
     * @return [view]
     */
    private function _wishlist()
    {
        $wishlist = Cart::instance('wishlist')->content();
        sc_check_view($this->templatePath . '.screen.shop_wishlist');
        return view(
            $this->templatePath . '.screen.shop_wishlist',
            array(
                'title'       => sc_language_render('cart.page_wishlist_title'),
                'description' => '',
                'keyword'     => '',
                'wishlist'    => $wishlist,
                'layout_page' => 'shop_wishlist',
                'breadcrumbs' => [
                    ['url'    => '', 'title' => sc_language_render('cart.page_wishlist_title')],
                ],
            )
        );
    }

    /**
     * Process front compare
     *
     * @param [type] ...$params
     * @return void
     */
    public function compareProcessFront(...$params)
    {
        if (config('app.seoLang')) {
            $lang = $params[0] ?? '';
            sc_lang_switch($lang);
        }
        return $this->_compare();
    }

    /**
     * Get product in compare
     * @return [view]
     */
    private function _compare()
    {
        $compare = Cart::instance('compare')->content();

        sc_check_view($this->templatePath . '.screen.shop_compare');
        return view(
            $this->templatePath . '.screen.shop_compare',
            array(
                'title'       => sc_language_render('cart.page_compare_title'),
                'description' => '',
                'keyword'     => '',
                'compare'     => $compare,
                'layout_page' => 'shop_compare',
                'breadcrumbs' => [
                    ['url'    => '', 'title' => sc_language_render('cart.page_compare_title')],
                ],
            )
        );
    }


    /**
     * Process front compare
     *
     * @param [type] ...$params
     * @return void
     */
    public function clearCartProcessFront(...$params)
    {
        if (config('app.seoLang')) {
            $lang = $params[0] ?? '';
            $instance = $params[1] ?? 'cart';
            sc_lang_switch($lang);
        } else {
            $instance = $params[0] ?? 'cart';
        }
        return $this->_clearCart($instance);
    }


    /**
     * Clear all cart
     * @return [redirect]
     */
    private function _clearCart($instance = 'cart')
    {
        Cart::instance($instance)->destroy();
        return redirect(sc_route($instance));
    }

    /**
     * Process front remove item cart
     *
     * @param [type] ...$params
     * @return void
     */
    public function removeItemProcessFront(...$params)
    {
        if (config('app.seoLang')) {
            $lang = $params[0] ?? '';
            $instance = $params[1] ?? 'cart';
            $id = $params[2] ?? '';
            sc_lang_switch($lang);
        } else {
            $instance = $params[0] ?? 'cart';
            $id = $params[1] ?? '';
        }
        return $this->_removeItem($instance, $id);
    }


    /**
     * Remove item from cart
     * @return [redirect]
     */
    private function _removeItem($instance = 'cart', $id = null)
    {
        if ($id === null) {
            return redirect(sc_route($instance));
        }
        if (array_key_exists($id, Cart::instance($instance)->content()->toArray())) {
            Cart::instance($instance)->remove($id);
        }
        return redirect(sc_route($instance));
    }

    
    /**
     * Complete order
     *
     * Step 07
     *
     * @return [redirect]
     */
    public function completeOrder()
    {
        //Clear cart store
        $this->clearCartStore();

        $orderID = session('orderID') ?? 0;
        $paymentMethod  = session('paymentMethod');
        $shippingMethod = session('shippingMethod');
        $totalMethod    = session('totalMethod', []);

        if ($orderID == 0) {
            return redirect()->route('home', ['error' => 'Error Order ID!']);
        }

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
        
        // Process event success
        sc_event_order_success($order = ShopOrder::find($orderID));

        // Process after order compled: send mail, data response ...
        $dataResponse = $this->processAfterOrderSuccess($orderID);

        return redirect(sc_route('order.success'))->with($dataResponse);
    }


    /**
     * Process front page order success
     *
     * Step 08.1
     *
     * @param [type] ...$params
     * @return void
     */
    public function orderSuccessProcessFront(...$params)
    {
        if (config('app.seoLang')) {
            $lang = $params[0] ?? '';
            sc_lang_switch($lang);
        }
        return $this->_orderSuccess();
    }

    /**
     * Page order success
     *
     * Step 08.2
     *
     * @return  [view]
     */
    private function _orderSuccess()
    {
        if (!session('orderID')) {
            return redirect()->route('home');
        }
        sc_check_view($this->templatePath . '.screen.shop_order_success');
        $orderInfo = ShopOrder::with('details')->find(session('orderID'))->toArray();
        return view(
            $this->templatePath . '.screen.shop_order_success',
            [
                'title'       => sc_language_render('checkout.success_title'),
                'orderInfo'   => $orderInfo,
                'layout_page' => 'shop_order_success',
                'breadcrumbs' => [
                    ['url'    => '', 'title' => sc_language_render('checkout.success_title')],
                ],
            ]
        );
    }

    /**
     * Remove cart store ordered
     */
    private function clearCartStore()
    {
        $dataCheckout = session('dataCheckout') ?? '';
        if ($dataCheckout) {
            foreach ($dataCheckout as $key => $row) {
                Cart::remove($row->rowId);
            }
        }
    }

    /**
     * Clear session
     */
    private function clearSession()
    {
        session()->forget('paymentMethod'); //destroy paymentMethod
        session()->forget('shippingMethod'); //destroy shippingMethod
        session()->forget('totalMethod'); //destroy totalMethod
        session()->forget('otherMethod'); //destroy otherMethod
        session()->forget('dataTotal'); //destroy dataTotal
        session()->forget('dataCheckout'); //destroy dataCheckout
        session()->forget('storeCheckout'); //destroy storeCheckout
        session()->forget('dataOrder'); //destroy dataOrder
        session()->forget('arrCartDetail'); //destroy arrCartDetail
        session()->forget('orderID'); //destroy orderID
    }

    /**
     * [processAfterOrderSuccess description]
     *
     * @param   string  $orderID  [$orderID description]
     *
     * @return  array            [return description]
     */
    private function processAfterOrderSuccess (string $orderID)
    {
        //Clear session
        $this->clearSession();
        return sc_order_process_after_success($orderID);
    }
}
