<?php
/**
 * File function process currency
 * @author Lanh Le <lanhktc@gmail.com>
 * From version: S-cart 3.0
 */
use App\Models\ShopCurrency;

//Render currency
if (!function_exists('sc_currency_render')) {
    function sc_currency_render(float $money, $currency = null, $rate = null, $space_between_symbol = false, $useSymbol = true)
    {
        return ShopCurrency::render($money, $currency, $rate, $space_between_symbol, $useSymbol);
    }
}

//Only render symbol, dont change value of mount
if (!function_exists('sc_currency_render_symbol')) {
    function sc_currency_render_symbol(float $money, $currency, $space_between_symbol = false, $include_symbol = true)
    {
        return ShopCurrency::onlyRender($money, $currency, $space_between_symbol, $include_symbol);
    }
}


//Get value after apply currency
if (!function_exists('sc_currency_value')) {
    function sc_currency_value(float $money, $rate = null)
    {
        return ShopCurrency::getValue($money, $rate);
    }
}

//Get code currency
if (!function_exists('sc_currency_code')) {
    function sc_currency_code()
    {
        return ShopCurrency::getCode();
    }
}

//Get rate currency
if (!function_exists('sc_currency_rate')) {
    function sc_currency_rate()
    {
        return ShopCurrency::getRate();
    }
}

//Format value without symbol
if (!function_exists('sc_currency_format')) {
    function sc_currency_format(float $money)
    {
        return ShopCurrency::format($money);
    }
}

//Get currency info
if (!function_exists('sc_currency_info')) {
    function sc_currency_info()
    {
        return ShopCurrency::getCurrency();
    }
}

//Get all currencies
if (!function_exists('sc_currency_all')) {
    function sc_currency_all()
    {
        return ShopCurrency::getAll();
    }
}

//Get all currencies active
if (!function_exists('sc_currency_all_active')) {
    function sc_currency_all_active()
    {
        return ShopCurrency::getCodeActive();
    }
}