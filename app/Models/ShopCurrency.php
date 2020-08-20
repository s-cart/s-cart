<?php
#app/Models/ShopCurrency.php
/**
 * @author Lanh Le <lanhktc@gmail.com>
 */
namespace App\Models;

use Cart;
use Illuminate\Database\Eloquent\Model;

class ShopCurrency extends Model
{
    public $table = SC_DB_PREFIX.'shop_currency';
    public $timestamps                  = false;
    protected static $code              = '';
    protected static $name              = '';
    protected static $symbol            = '';
    protected static $exchange_rate     = 1;
    protected static $precision         = 0;
    protected static $symbol_first      = 0;
    protected static $thousands         = ',';
    protected static $decimal           = '.';
    protected static $list              = null;
    protected static $getArray          = null;
    protected static $getCodeActive     = null;
    protected static $checkListCurrency = [];
    protected $guarded                  = [];
    protected $connection = SC_CONNECTION;

    public static function getListAll()
    {
        if (!self::$list) {
            self::$list = self::get()
                ->keyBy('code');
        }
        return self::$list;
    }

    public static function getCodeActive()
    {
        if (self::$getCodeActive === null) {
            self::$getCodeActive = self::where('status', 1)
                ->pluck('name', 'code')
                ->all();
        }
        return self::$getCodeActive;
    }


    public static function getCodeAll()
    {
        if (self::$getArray === null) {
            self::$getArray = self::pluck('name', 'code')->all();
        }
        return self::$getArray;
    }

    /**
     * [setCode description]
     * @param [type] $code [description]
     */
    public static function setCode($code)
    {
        self::$code = $code;
        if (empty(self::$checkListCurrency[$code])) {
            self::$checkListCurrency[$code] = self::where('code', $code)->first();
        }
        $checkCurrency = self::$checkListCurrency[$code];
        if ($checkCurrency) {
            self::$name          = $checkCurrency->name;
            self::$symbol        = $checkCurrency->symbol;
            self::$exchange_rate = $checkCurrency->exchange_rate;
            self::$precision     = $checkCurrency->precision;
            self::$symbol_first  = $checkCurrency->symbol_first;
            self::$thousands     = $checkCurrency->thousands;
            self::$decimal       = ($checkCurrency->thousands == '.') ? ',' : '.';
        }
    }

    /**
     * [getCurrency description]
     * @return [type] [description]
     */
    public static function getCurrency()
    {
        return [
            'code'          => self::$code,
            'name'          => self::$name,
            'symbol'        => self::$symbol,
            'exchange_rate' => self::$exchange_rate,
            'precision'     => self::$precision,
            'symbol_first'  => self::$symbol_first,
            'thousands'     => self::$thousands,
            'decimal'       => self::$decimal,
        ];
    }

    /*
     * [getCode description]
     * @return [type] [description]
     */
    public static function getCode()
    {
        return self::$code;
    }

    /**
     * [getRate description]
     * @return [type] [description]
     */
    public static function getRate()
    {
        return self::$exchange_rate;
    }

    /**
     * [getValue description]
     * @param  float  $money [description]
     * @param  [type] $rate  [description]
     * @return [type]        [description]
     */
    public static function getValue(float $money, $rate = null)
    {
        if ($rate) {
            return $money * $rate;
        } else {
            return $money * self::$exchange_rate;
        }

    }

    /**
     * [format description]
     * @param  float  $money [description]
     * @return [type]        [description]
     */
    public static function format(float $money)
    {
        return number_format($money, self::$precision, self::$decimal, self::$thousands);
    }

    /**
     * [render description]
     * @param  float   $money                [description]
     * @param  [type]  $currency             [description]
     * @param  [type]  $rate                 [description]
     * @param  boolean $space_between_symbol [description]
     * @param  boolean $include_symbol       [description]
     * @return [type]                        [description]
     */
    public static function render(float $money, $currency = null, $rate = null, $space_between_symbol = false, $include_symbol = true)
    {
        $space_symbol = ($space_between_symbol) ? ' ' : '';
        $dataCurrency = self::getCurrency();
        if ($currency) {
            if (empty(self::$checkListCurrency[$currency])) {
                self::$checkListCurrency[$currency] = self::where('code', $currency)->first();
            }
            $checkCurrency = self::$checkListCurrency[$currency];
            if ($checkCurrency) {
                $dataCurrency = $checkCurrency;
            }
        }
        //Get currently value
        $value = self::getValue($money, $rate);

        $symbol = ($include_symbol) ? $dataCurrency['symbol'] : '';

        if ($dataCurrency['symbol_first']) {
            if ($money < 0) {
                return '-' . $symbol . $space_symbol . self::format(abs($value));
            } else {
                return $symbol . $space_symbol . self::format($value);
            }
        } else {
            return self::format($value) . $space_symbol . $symbol;
        }
    }

    /**
     * [onlyRender description]
     * @param  float   $money                [description]
     * @param  [type]  $currency             [description]
     * @param  boolean $space_between_symbol [description]
     * @param  boolean $include_symbol       [description]
     * @return [type]                        [description]
     */
    public static function onlyRender(float $money, $currency, $space_between_symbol = false, $include_symbol = true)
    {
        if (empty(self::$checkListCurrency[$currency])) {
            self::$checkListCurrency[$currency] = self::where('code', $currency)->first();
        }
        $checkCurrency = self::$checkListCurrency[$currency];
        $space_symbol  = ($space_between_symbol) ? ' ' : '';
        $symbol        = ($include_symbol) ? $checkCurrency['symbol'] : '';
        if ($checkCurrency['symbol_first']) {
            if ($money < 0) {
                return '-' . $symbol . $space_symbol . self::format(abs($money));
            } else {
                return $symbol . $space_symbol . self::format($money);
            }

        } else {
            return self::format($money) . $space_symbol . $symbol;
        }
    }
    
    /**
     * Sum value of cart
     *
     * @param   [\App\Library\ShoppingCart\CartItem] $details  [$details description]
     * @param   float  $rate     [$rate description]
     *
     * @return  [array]
     */
    public static function sumCart($details, float $rate = null)
    {
        $sumSubtotal  = 0;
        $sumSubtotalWithTax  = 0;
        $rate = ($rate) ? $rate : self::$exchange_rate;
        foreach ($details as $detail) {
            $sumSubtotal += $detail->qty * self::getValue($detail->price, $rate);
            $sumSubtotalWithTax += $detail->qty * self::getValue(sc_tax_price($detail->price, $detail->tax), $rate);
        }
        return 
            [
                'subTotal' => $sumSubtotal,
                'subTotalWithTax' => $sumSubtotalWithTax,
            ];
    }

    public static function getListRate()
    {
        return self::pluck('exchange_rate', 'code')->all();
    }

    public static function getListActive()
    {
        return self::where('status', 1)
            ->sort()
            ->get();
    }
    //Scort
    public function scopeSort($query, $sortBy = null, $sortOrder = 'desc')
    {
        $sortBy = $sortBy ?? 'sort';
        return $query->orderBy($sortBy, $sortOrder);
    }

    protected static function boot() {
        parent::boot();
        static::deleting(function ($model) {
            if(in_array($model->id, SC_GUARD_CURRENCY)){
                return false;
            }
        });
    }

}
