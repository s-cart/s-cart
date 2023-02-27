<?php

use App\Pmo\Front\Models\ShopLanguage;
use Illuminate\Support\Str;

if (!function_exists('sc_language_all') && !in_array('sc_language_all', config('helper_except', []))) {
    //Get all language
    function sc_language_all()
    {
        return ShopLanguage::getListActive();
    }
}

if (!function_exists('sc_languages') && !in_array('sc_languages', config('helper_except', []))) {
    /*
    Render language
    WARNING: Dont call this function (or functions that call it) in __construct or midleware, it may cause the display language to be incorrect
     */
    function sc_languages($locale)
    {
        $languages = \App\Pmo\Front\Models\Languages::getListAll($locale);
        return $languages;
    }
}

if (!function_exists('sc_language_replace') && !in_array('sc_language_replace', config('helper_except', []))) {
    /*
    Replace language
     */
    function sc_language_replace(string $line, array $replace)
    {
        foreach ($replace as $key => $value) {
            $line = str_replace(
                [':'.$key, ':'.Str::upper($key), ':'.Str::ucfirst($key)],
                [$value, Str::upper($value), Str::ucfirst($value)],
                $line
            );
        }
        return $line;
    }
}


if (!function_exists('sc_language_render') && !in_array('sc_language_render', config('helper_except', []))) {
    /*
    Render language
    WARNING: Dont call this function (or functions that call it) in __construct or midleware, it may cause the display language to be incorrect
     */
    function sc_language_render($string, array $replace = [], $locale = null)
    {
        $locale = $locale ? $locale : sc_get_locale();
        $languages = sc_languages($locale);
        return !empty($languages[$string]) ? sc_language_replace($languages[$string], $replace): trans($string, $replace);
    }
}


if (!function_exists('sc_language_quickly') && !in_array('sc_language_quickly', config('helper_except', []))) {
    /*
    Language quickly
     */
    function sc_language_quickly($string, $default = null)
    {
        $locale = sc_get_locale();
        $languages = sc_languages($locale);
        return !empty($languages[$string]) ? $languages[$string] : (\Lang::has($string) ? trans($string) : $default);
    }
}

if (!function_exists('sc_get_locale') && !in_array('sc_get_locale', config('helper_except', []))) {
    /*
    Get locale
    */
    function sc_get_locale()
    {
        return app()->getLocale();
    }
}


if (!function_exists('sc_lang_switch') && !in_array('sc_lang_switch', config('helper_except', []))) {
    /**
     * Switch language
     *
     * @param   [string]  $lang
     *
     * @return  [mix]
     */
    function sc_lang_switch($lang = null)
    {
        if (!$lang) {
            return ;
        }

        $languages = sc_language_all()->keys()->all();
        if (in_array($lang, $languages)) {
            app()->setLocale($lang);
            session(['locale' => $lang]);
        } else {
            return abort(404);
        }
    }
}
