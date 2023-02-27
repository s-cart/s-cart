<?php

namespace App\Pmo\Library\ShoppingCart;

use App\Pmo\Library\ShoppingCart\Exceptions\CartAlreadyStoredException;
use App\Pmo\Library\ShoppingCart\Exceptions\UnknownModelException;
use Closure;
use Illuminate\Contracts\Events\Dispatcher;
use Illuminate\Session\SessionManager;
use Illuminate\Support\Collection;
use Carbon\Carbon;

class Cart
{
    const DEFAULT_INSTANCE = 'default';

    /**
     * Instance of the session manager.
     *
     * @var \Illuminate\Session\SessionManager
     */
    private $session;

    /**
     * Instance of the event dispatcher.
     *
     * @var \Illuminate\Contracts\Events\Dispatcher
     */
    private $events;

    /**
     * Holds the current cart instance.
     *
     * @var string
     */
    private $instance;

    /**
     * Cart constructor.
     *
     * @param \Illuminate\Session\SessionManager      $session
     * @param \Illuminate\Contracts\Events\Dispatcher $events
     */
    public function __construct(SessionManager $session, Dispatcher $events)
    {
        $this->session = $session;
        $this->events = $events;

        $this->instance(self::DEFAULT_INSTANCE);
    }

    /**
     * Set the current cart instance.
     *
     * @param string|null $instance
     * @return \App\Pmo\Library\ShoppingCart\Cart
     */
    public function instance($instance = null)
    {
        $instance = $instance ?: self::DEFAULT_INSTANCE;
        $instance = ($instance == 'cart') ? self::DEFAULT_INSTANCE : $instance;

        $this->instance = sprintf('%s.%s', 'cart', $instance);

        return $this;
    }

    /**
     * Get the current cart instance.
     *
     * @return string
     */
    public function currentInstance()
    {
        return str_replace('cart.', '', $this->instance);
    }

    /**
     * Add an item to the cart.
     *
     * @param array     $dataCart
     * @return \App\Pmo\Library\ShoppingCart\CartItem
     */
    public function add($dataCart)
    {
        $cartItem = $this->createCartItem($dataCart);

        $content = $this->getContent();

        if ($content->has($cartItem->rowId)) {
            $cartItem->qty += $content->get($cartItem->rowId)->qty;
        }

        $content->put($cartItem->rowId, $cartItem);

        $this->events->dispatch('cart.added', $cartItem);

        $this->session->put($this->instance, $content);

        if (auth()->user()) {
            $userId = auth()->user()->id;
            $this->_updateDatabase($userId);
        }

        return $cartItem;
    }

    /**
     * Update the cart item with the given rowId.
     *
     * @param string $rowId
     * @param mixed  $qty
     * @return \App\Pmo\Library\ShoppingCart\CartItem
     */
    public function update($rowId, $qty)
    {
        $cartItem = $this->get($rowId);
        if (!$cartItem) {
            return;
        }
        
        $cartItem->qty = $qty;

        $content = $this->getContent();

        if ($rowId !== $cartItem->rowId) {
            $content->pull($rowId);

            if ($content->has($cartItem->rowId)) {
                $existingCartItem = $this->get($cartItem->rowId);
                $cartItem->setQuantity($existingCartItem->qty + $cartItem->qty);
            }
        }

        if ($cartItem->qty <= 0) {
            $this->remove($cartItem->rowId);
            return;
        } else {
            $content->put($cartItem->rowId, $cartItem);
        }

        $this->events->dispatch('cart.updated', $cartItem);

        $this->session->put($this->instance, $content);

        if (auth()->user()) {
            $userId = auth()->user()->id;
            $this->_updateDatabase($userId);
        }

        return $cartItem;
    }

    /**
     * Remove the cart item with the given rowId from the cart.
     *
     * @param string $rowId
     * @return void
     */
    public function remove($rowId)
    {
        $cartItem = $this->get($rowId);

        $content = $this->getContent();

        $content->pull($cartItem->rowId);

        $this->events->dispatch('cart.removed', $cartItem);

        $this->session->put($this->instance, $content);

        if (auth()->user()) {
            $userId = auth()->user()->id;
            $this->_updateDatabase($userId);
        }
    }

    /**
     * Get a cart item from the cart by its rowId.
     *
     * @param string $rowId
     * @return \App\Pmo\Library\ShoppingCart\CartItem
     */
    public function get($rowId)
    {
        $content = $this->getContent();

        if (!$content->has($rowId)) {
            return;
        }

        return $content->get($rowId);
    }

    /**
     * Destroy the current cart instance.
     *
     * @return void
     */
    public function destroy()
    {
        $this->session->remove($this->instance);
        if (auth()->user()) {
            $userId = auth()->user()->id;
            $this->_updateDatabase($userId);
        }
    }

    /**
     * Get the content of the cart.
     *
     * @return \Illuminate\Support\Collection
     */
    public function content()
    {
        if (is_null($this->session->get($this->instance))) {
            return new Collection([]);
        }
        //Check products in cart
        $content = $this->session->get($this->instance);
        foreach ($content as $key => $item) {
            $product = \App\Pmo\Front\Models\ShopProduct::where('id', $item->id)
                ->where('status', 1) //Active
                ->where('approve', 1) //Approve
                ->first();
            if (!$product) {
                $this->remove($key);
            }
        }
        return $this->session->get($this->instance);
    }

    /**
     * Get items in cart group by storeId
     *
     * @return  [type]  [return description]
     */
    public function getItemsGroupByStore()
    {
        return $this->content()->groupBy('storeId');
    }

    /**
     * Get the number of items in the cart.
     *
     * @return int|float
     */
    public function count()
    {
        $content = $this->getContent();

        return $content->sum('qty');
    }

    /**
     * Get the total price of the items in the cart.
     *
     * @return string
     */
    public function total()
    {
        $content = $this->getContent();

        $total = $content->reduce(function ($total, CartItem $cartItem) {
            return $total + ($cartItem->qty * sc_tax_price($cartItem->price, $cartItem->tax));
        }, 0);
        return $total;
    }

    /**
     * Get the subtotal of the items in the cart.
     *
     * @return float
     */
    public function subtotal()
    {
        $content = $this->getContent();

        $subTotal = $content->reduce(function ($subTotal, CartItem $cartItem) {
            return $subTotal + ($cartItem->qty * $cartItem->price);
        }, 0);
        return $subTotal;
    }

    /**
     * Search the cart content for a cart item matching the given search closure.
     *
     * @param \Closure $search
     * @return \Illuminate\Support\Collection
     */
    public function search(Closure $search)
    {
        $content = $this->getContent();

        return $content->filter($search);
    }

    /**
     * Associate the cart item with the given rowId with the given model.
     *
     * @param string $rowId
     * @param mixed  $model
     * @return void
     */
    public function associate($rowId, $model)
    {
        if (is_string($model) && !class_exists($model)) {
            throw new UnknownModelException("The supplied model {$model} does not exist.");
        }

        $cartItem = $this->get($rowId);

        $cartItem->associate($model);

        $content = $this->getContent();

        $content->put($cartItem->rowId, $cartItem);

        $this->session->put($this->instance, $content);
    }

    /**
     * Store an the current instance of the cart.
     *
     * @param mixed $identifier
     * @return void
     */
    public function saveDatabase($identifier)
    {
        $content = $this->getContent();
        $currentInstance = $this->currentInstance();

        if ($this->storedCartWithIdentifierExists($identifier, $currentInstance)) {
            throw new CartAlreadyStoredException("A cart with identifier {$identifier}_{$currentInstance} was already stored.");
        }

        $storeId = config('app.storeId');

        CartModel::insert(
            [
                'identifier' => $identifier,
                'instance' => $currentInstance,
                'content' => $content->toJson(),
                'store_id' => $storeId,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ]
        );

        $this->events->dispatch('cart.stored');
    }

    /**
     * Restore the cart with the given identifier.
     *
     * @param mixed $identifier
     * @return void
     */
    public function removeDatabase($identifier)
    {
        $currentInstance = $this->currentInstance();
        return (new CartModel)
            ->where('identifier', $identifier)
            ->where('instance', $currentInstance)
            ->where('store_id', config('app.storeId'))
            ->delete();
    }

    /**
     * Magic method to make accessing the total, tax and subtotal properties possible.
     *
     * @param string $attribute
     * @return float|null
     */
    public function __get($attribute)
    {
        if ($attribute === 'total') {
            return $this->total();
        }

        if ($attribute === 'subtotal') {
            return $this->subtotal();
        }

        return null;
    }

    /**
     * Get the carts content, if there is no cart content set yet, return a new empty Collection
     *
     * @return \Illuminate\Support\Collection
     */
    protected function getContent()
    {
        $content = $this->session->has($this->instance)
        ? $this->session->get($this->instance)
        : new Collection;

        return $content;
    }

    /**
     * Create a new CartItem from the supplied attributes.
     *
     * @param array     $dataCart
     * @return \App\Pmo\Library\ShoppingCart\CartItem
     */
    private function createCartItem($dataCart)
    {
        $cartItem = CartItem::fromArray($dataCart);
        $cartItem->setQuantity($dataCart['qty']);

        return $cartItem;
    }

    /**
     * @param $identifier
     * @param $instance
     * @return bool
     */
    private function storedCartWithIdentifierExists($identifier, $instance)
    {
        return (new CartModel)
            ->where('identifier', $identifier)
            ->where('instance', $instance)
            ->where('store_id', config('app.storeId'))
            ->exists();
    }

    /*
    Get list Cart
    */
    public static function getListCart($instance = self::DEFAULT_INSTANCE)
    {
        $cart = \Cart::instance($instance);
        $arrCart['count'] = $cart->count();
        $arrCart['subtotal'] = sc_currency_render($cart->subtotal());
        $arrCart['items'] = [];
        if ($cart->count()) {
            foreach ($cart->content() as $key => $item) {
                $product = \App\Pmo\Front\Models\ShopProduct::find($item->id);
                if ($product) {
                    $arrCart['items'][] = [
                        'id'        => $item->id,
                        'rowId'     => $item->rowId,
                        'name'      => $product->getName(),
                        'qty'       => $item->qty,
                        'image'     => sc_file($product->getThumb()),
                        'price'     => $product->getFinalPrice(),
                        'showPrice' => $product->showPrice(),
                        'url'       => $product->getUrl(),
                        'storeId'   => $item->storeId,
                    ];
                }
            }
        }

        return $arrCart;
    }

    /**
     * Get subtotal group by store
     */
    public function getSubtotalGroupByStore()
    {
        $arraySubtotal = [];
        $carts = $this->getItemsGroupByStore();
        foreach ($carts as $storeId => $cart) {
            $subTotal = $cart->reduce(function ($subTotal, $item) {
                return $subTotal + ($item->qty * $item->price);
            }, 0);
            $arraySubtotal[$storeId] = $subTotal;
        }
        return $arraySubtotal;
    }

    /**
     * Update database cart
     *
     * @param [type] $identifier
     * @return void
     */
    private function _updateDatabase($identifier)
    {
        $this->removeDatabase($identifier);
        $this->saveDatabase($identifier);
    }
}
