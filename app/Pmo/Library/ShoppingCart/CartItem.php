<?php

namespace App\Pmo\Library\ShoppingCart;

use Illuminate\Contracts\Support\Arrayable;
use Illuminate\Contracts\Support\Jsonable;

class CartItem implements Arrayable, Jsonable
{
    /**
     * The rowID of the cart item.
     *
     * @var string
     */
    public $rowId;

    /**
     * The ID of the cart item.
     *
     * @var int|string
     */
    public $id;

    /**
     * The quantity for this cart item.
     *
     * @var int|float
     */
    public $qty;

    /**
     * The name of the cart item.
     *
     * @var string
     */
    public $name;

    /**
     * The price without TAX of the cart item.
     *
     * @var float
     */
    public $price;

    /**
     * The value of tax (%).
     *
     * @var int
     */
    public $tax;

    /**
     * The options for this cart item.
     *
     * @var array
     */
    public $options;

    /**
     * The id store.
     *
     * @var int
     */
    public $storeId;

    /**
     * The FQN of the associated model.
     *
     * @var string|null
     */
    private $associatedModel = null;

    /**
     * CartItem constructor.
     *
     * @param int|string $id
     * @param string     $name
     * @param float      $price
     * @param array      $options
     * @param int        $tax
     * @param int        $storeId
     */
    public function __construct($id, $name, $price, array $options = [], $tax = 0, $storeId = null)
    {
        $storeId = empty($storeId) ? config('app.storeId') : $storeId;

        if (empty($id)) {
            throw new \InvalidArgumentException('Please supply a valid identifier.');
        }
        if (empty($name)) {
            throw new \InvalidArgumentException('Please supply a valid name.');
        }
        if (strlen($price) < 0 || ! is_numeric($price)) {
            throw new \InvalidArgumentException('Please supply a valid price.');
        }

        $this->id      = $id;
        $this->name    = $name;
        $this->price   = floatval($price);
        $this->tax     = floatval($tax);
        $this->options = new CartItemOptions($options);
        $this->rowId   = $this->generateRowId($id, $options);
        $this->storeId = $storeId;
    }

    /**
     * Returns the formatted price without TAX.
     *
     * @return string
     */
    public function price()
    {
        return $this->price;
    }

    /**
     * Returns the value of tax (%).
     *
     * @return string
     */
    public function tax()
    {
        return $this->tax;
    }

    /**
     * Returns the formatted subtotal.
     * Subtotal is price for whole CartItem without TAX
     *
     * @return string
     */
    public function subtotal()
    {
        return $this->subtotal;
    }
    
    /**
     * Returns the formatted total.
     * Total is price for whole CartItem with TAX
     *
     * @return string
     */
    public function total()
    {
        return $this->total;
    }


    /**
     * Set the quantity for this cart item.
     *
     * @param int|float $qty
     */
    public function setQuantity($qty)
    {
        if (empty($qty) || ! is_numeric($qty)) {
            throw new \InvalidArgumentException('Please supply a valid quantity.');
        }

        $this->qty = $qty;
    }


    /**
     * Associate the cart item with the given model.
     *
     * @param mixed $model
     * @return \App\Pmo\Library\ShoppingCart\CartItem
     */
    public function associate($model)
    {
        $this->associatedModel = is_string($model) ? $model : get_class($model);
        
        return $this;
    }


    /**
     * Get an attribute from the cart item or get the associated model.
     *
     * @param string $attribute
     * @return mixed
     */
    public function __get($attribute)
    {
        if (property_exists($this, $attribute)) {
            return $this->{$attribute};
        }
        if ($attribute === 'subtotal') {
            return $this->qty * $this->price;
        }
        
        if ($attribute === 'total') {
            return sc_tax_price($this->qty * $this->price, $this->tax);
        }
        

        if ($attribute === 'model' && isset($this->associatedModel)) {
            return with(new $this->associatedModel)->find($this->id);
        }

        return null;
    }


    /**
     * Create a new instance from the given array.
     *
     * @param array $attributes
     * @return \App\Pmo\Library\ShoppingCart\CartItem
     */
    public static function fromArray(array $attributes)
    {
        $options = array_get($attributes, 'options', []);

        return new self($attributes['id'], $attributes['name'], $attributes['price'], $options, $attributes['tax'], $attributes['storeId']);
    }

    /**
     * Generate a unique id for the cart item.
     *
     * @param string $id
     * @param array  $options
     * @return string
     */
    protected function generateRowId($id, array $options)
    {
        ksort($options);

        return md5($id . serialize($options));
    }

    /**
     * Get the instance as an array.
     *
     * @return array
     */
    public function toArray()
    {
        return [
            'rowId'    => $this->rowId,
            'id'       => $this->id,
            'name'     => $this->name,
            'qty'      => $this->qty,
            'price'    => $this->price,
            'tax'      => $this->tax,
            'storeId'  => $this->storeId,
            'options'  => $this->options->toArray(),
            'subtotal' => $this->subtotal,
            'total'    => $this->total
        ];
    }

    /**
     * Convert the object to its JSON representation.
     *
     * @param int $options
     * @return string
     */
    public function toJson($options = 0)
    {
        return json_encode($this->toArray(), $options);
    }
}
