<?php
/**
 * File function process currency
 * @author Lanh Le <lanhktc@gmail.com>
 */
use App\Pmo\Front\Models\ShopCurrency;

if (!function_exists('sc_currency_render') && !in_array('sc_currency_render', config('helper_except', []))) {
    /**
     * Render currency: format number, change amount, add symbol
     *
     * @param   float  $money                 [$money description]
     * @param   [type] $currency              [$currency description]
     * @param   null   $rate                  [$rate description]
     * @param   null   $space_between_symbol  [$space_between_symbol description]
     * @param   false  $useSymbol             [$useSymbol description]
     * @param   true                          [ description]
     *
     * @return  [type]                        [return description]
     */
    function sc_currency_render(float $money, $currency = null, $rate = null, $space_between_symbol = false, $useSymbol = true)
    {
        return ShopCurrency::render($money, $currency, $rate, $space_between_symbol, $useSymbol);
    }
}

if (!function_exists('sc_currency_render_symbol') && !in_array('sc_currency_render_symbol', config('helper_except', []))) {
    /**
     * Only render symbol, dont change amount
     *
     * @param   float  $money                 [$money description]
     * @param   [type] $currency              [$currency description]
     * @param   null   $space_between_symbol  [$space_between_symbol description]
     * @param   false  $include_symbol        [$include_symbol description]
     * @param   true                          [ description]
     *
     * @return  [type]                        [return description]
     */
    function sc_currency_render_symbol(float $money, $currency = null, $space_between_symbol = false, $include_symbol = true)
    {
        $currency = $currency ? $currency : sc_currency_code();
        return ShopCurrency::onlyRender($money, $currency, $space_between_symbol, $include_symbol);
    }
}


if (!function_exists('sc_currency_value') && !in_array('sc_currency_value', config('helper_except', []))) {
    /**
     * Get value of amount with specify exchange rate
     * if dont specify rate, will use exchange rate default
     *
     * @param   float  $money  [$money description]
     * @param   float  $rate   [$rate description]
     * @param   null           [ description]
     *
     * @return  [type]         [return description]
     */
    function sc_currency_value(float $money, float $rate = null)
    {
        return ShopCurrency::getValue($money, $rate);
    }
}

//Get code currency
if (!function_exists('sc_currency_code') && !in_array('sc_currency_code', config('helper_except', []))) {
    function sc_currency_code()
    {
        return ShopCurrency::getCode();
    }
}

//Get rate currency
if (!function_exists('sc_currency_rate') && !in_array('sc_currency_rate', config('helper_except', []))) {
    function sc_currency_rate()
    {
        return ShopCurrency::getRate();
    }
}

//Format value without symbol
if (!function_exists('sc_currency_format') && !in_array('sc_currency_format', config('helper_except', []))) {
    function sc_currency_format(float $money)
    {
        return ShopCurrency::format($money);
    }
}

//Get currency info
if (!function_exists('sc_currency_info') && !in_array('sc_currency_info', config('helper_except', []))) {
    function sc_currency_info()
    {
        return ShopCurrency::getCurrency();
    }
}

//Get all currencies
if (!function_exists('sc_currency_all') && !in_array('sc_currency_all', config('helper_except', []))) {
    function sc_currency_all()
    {
        return ShopCurrency::getListActive();
    }
}

//Get array code, name of currencies active
if (!function_exists('sc_currency_all_active') && !in_array('sc_currency_all_active', config('helper_except', []))) {
    function sc_currency_all_active()
    {
        return ShopCurrency::getCodeActive();
    }
}

/*
    Return price with tax
*/
if (!function_exists('sc_tax_price') && !in_array('sc_tax_price', config('helper_except', []))) {
    function sc_tax_price($price, $tax)
    {
        return round($price * (100 + $tax) /100, 2);
    }
}

/**
 * Render html option price
 *
 * @param   string $arrtribute  format: attribute-name__value-option-price
 * @param   string $currency    code currency
 * @param   string  $rate        rate exchange
 * @param   string               [ description]
 *
 * @return  [type]             [return description]
 */
if (!function_exists('sc_render_option_price') && !in_array('sc_render_option_price', config('helper_except', []))) {
    function sc_render_option_price($arrtribute, $currency = null, $rate = null, $format = '%s<span class="option_price">%s</span>')
    {
        $html = '';
        $tmpAtt = explode('__', $arrtribute);
        $add_price = $tmpAtt[1] ?? 0;
        if ($add_price) {
            $html = sprintf($format, $tmpAtt[0], "(+".sc_currency_render($add_price, $currency, $rate).")");
        } else {
            $html = sprintf($format, $tmpAtt[0], "");
        }
        return $html;
    }
}
