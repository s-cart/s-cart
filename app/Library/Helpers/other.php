<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Str;
use Illuminate\Support\Arr;

/*
String to Url
 */
if (!function_exists('sc_word_format_url') && !in_array('sc_word_format_url', config('helper_except', []))) {
    function sc_word_format_url(string $str = null):string
    {
        $unicode = array(
            'a' => 'á|à|ả|ã|ạ|ă|ắ|ặ|ằ|ẳ|ẵ|â|ấ|ầ|ẩ|ẫ|ậ',
            'd' => 'đ',
            'e' => 'é|è|ẻ|ẽ|ẹ|ê|ế|ề|ể|ễ|ệ',
            'i' => 'í|ì|ỉ|ĩ|ị',
            'o' => 'ó|ò|ỏ|õ|ọ|ô|ố|ồ|ổ|ỗ|ộ|ơ|ớ|ờ|ở|ỡ|ợ',
            'u' => 'ú|ù|ủ|ũ|ụ|ư|ứ|ừ|ử|ữ|ự',
            'y' => 'ý|ỳ|ỷ|ỹ|ỵ',
            'A' => 'Á|À|Ả|Ã|Ạ|Ă|Ắ|Ặ|Ằ|Ẳ|Ẵ|Â|Ấ|Ầ|Ẩ|Ẫ|Ậ',
            'D' => 'Đ',
            'E' => 'É|È|Ẻ|Ẽ|Ẹ|Ê|Ế|Ề|Ể|Ễ|Ệ',
            'I' => 'Í|Ì|Ỉ|Ĩ|Ị',
            'O' => 'Ó|Ò|Ỏ|Õ|Ọ|Ô|Ố|Ồ|Ổ|Ỗ|Ộ|Ơ|Ớ|Ờ|Ở|Ỡ|Ợ',
            'U' => 'Ú|Ù|Ủ|Ũ|Ụ|Ư|Ứ|Ừ|Ử|Ữ|Ự',
            'Y' => 'Ý|Ỳ|Ỷ|Ỹ|Ỵ',
        );

        foreach ($unicode as $nonUnicode => $uni) {
            $str = preg_replace("/($uni)/i", $nonUnicode, $str);
        }
        return strtolower(preg_replace(
            array('/[\s\-\/\\\?\(\)\~\.\[\]\%\*\#\@\$\^\&\!\'\"\`\;\:]+/'),
            array('-'),
            strtolower($str)
        ));
    }
}


if (!function_exists('sc_url_render') && !in_array('sc_url_render', config('helper_except', []))) {
    /*
    url render
     */
    function sc_url_render(string $string = null):string
    {
        $arrCheckRoute = explode('route::', $string);
        $arrCheckUrl = explode('admin::', $string);

        if (count($arrCheckRoute) == 2) {
            $arrRoute = explode('::', $string);
            if (Str::startsWith($string, 'route::admin')) {
                if (isset($arrRoute[2])) {
                    return sc_route_admin($arrRoute[1], explode(',', $arrRoute[2]));
                } else {
                    return sc_route_admin($arrRoute[1]);
                }
            } else {
                if (isset($arrRoute[2])) {
                    return sc_route($arrRoute[1], explode(',', $arrRoute[2]));
                } else {
                    return sc_route($arrRoute[1]);
                }
            }
        }

        if (count($arrCheckUrl) == 2) {
            $string = Str::start($arrCheckUrl[1], '/');
            $string = SC_ADMIN_PREFIX . $string;
            return url($string);
        }
        return url($string);
    }
}


if (!function_exists('sc_html_render') && !in_array('sc_html_render', config('helper_except', []))) {
    /*
    Html render
     */
    function sc_html_render(string $string = null):string
    {
        $string = htmlspecialchars_decode($string);
        return $string;
    }
}

if (!function_exists('sc_word_format_class') && !in_array('sc_word_format_class', config('helper_except', []))) {
    /*
    Format class name
     */
    function sc_word_format_class(string $word = null):string
    {
        $word = Str::camel($word);
        $word = ucfirst($word);
        return $word;
    }
}

if (!function_exists('sc_word_limit') && !in_array('sc_word_limit', config('helper_except', []))) {
    /*
    Truncates words
     */
    function sc_word_limit(string $word = null, int $limit = 20, string $arg = ''):string
    {
        $word = Str::limit($word, $limit, $arg);
        return $word;
    }
}

if (!function_exists('sc_token') && !in_array('sc_token', config('helper_except', []))) {
    /*
    Create random token
     */
    function sc_token(int $length = 32)
    {
        $token = Str::random($length);
        return $token;
    }
}

if (!function_exists('sc_report') && !in_array('sc_report', config('helper_except', []))) {
    /*
    Handle report
     */
    function sc_report(string $msg = null, array $ext = [])
    {
        $msg = sc_time_now(config('app.timezone')).' ('.config('app.timezone').'):'.PHP_EOL.$msg.PHP_EOL;
        if (!in_array('slack', $ext)) {
            if (config('logging.channels.slack.url')) {
                try {
                    \Log::channel('slack')->emergency($msg);
                } catch (\Throwable $e) {
                    $msg .= $e->getFile().'- Line: '.$e->getLine().PHP_EOL.$e->getMessage().PHP_EOL;
                }
            }
        }
        \Log::error($msg);
    }
}


if (!function_exists('sc_handle_exception') && !in_array('sc_handle_exception', config('helper_except', []))) {
    /*
    Process msg exception
     */
    function sc_handle_exception(\Throwable $exception)
    {
        $msg = "```". $exception->getMessage().'```'.PHP_EOL;
        $msg .= "```IP:```".request()->ip().PHP_EOL;
        $msg .= "*File* `".$exception->getFile()."`, *Line:* ".$exception->getLine().", *Code:* ".$exception->getCode().PHP_EOL.'URL= '.url()->current();
        if (function_exists('sc_report') && $msg) {
            sc_report($msg);
        }
    }
}


if (!function_exists('sc_push_include_view') && !in_array('sc_push_include_view', config('helper_except', []))) {
    /**
     * Push view
     *
     * @param   [string]  $position
     * @param   [string]  $pathView
     *
     */
    function sc_push_include_view(string $position = null, string $pathView = null)
    {
        $includePathView = config('sc_include_view.'.$position, []);
        $includePathView[] = $pathView;
        config(['sc_include_view.'.$position => $includePathView]);
    }
}


if (!function_exists('sc_push_include_script') && !in_array('sc_push_include_script', config('helper_except', []))) {
    /**
     * Push script
     *
     * @param   [string]  $position
     * @param   [string]  $pathScript
     *
     */
    function sc_push_include_script($position, $pathScript)
    {
        $includePathScript = config('sc_include_script.'.$position, []);
        $includePathScript[] = $pathScript;
        config(['sc_include_script.'.$position => $includePathScript]);
    }
}


/**
 * convert datetime to date
 */
if (!function_exists('sc_datetime_to_date') && !in_array('sc_datetime_to_date', config('helper_except', []))) {
    function sc_datetime_to_date($datetime, $format = 'Y-m-d')
    {
        if (empty($datetime)) {
            return null;
        }
        return  date($format, strtotime($datetime));
    }
}


if (!function_exists('admin') && !in_array('admin', config('helper_except', []))) {
    /**
     * Admin login information
     */
    function admin()
    {
        return auth()->guard('admin');
    }
}

if (!function_exists('sc_sync_cart') && !in_array('sc_sync_cart', config('helper_except', []))) {
    /**
     * Sync data cart
     */
    function sc_sync_cart($userId)
    {
        //Process sync cart data and session
        $cartDB = \App\Pmo\Library\ShoppingCart\CartModel::where('identifier', $userId)
            ->where('store_id', config('app.storeId'))
            ->get()->keyBy('instance');
        $arrayInstance = ['default', 'wishlist', 'compare'];
        if ($cartDB) {
            foreach ($cartDB as $instance => $cartInstance) {
                $arrayInstance = array_diff($arrayInstance, [$instance]);
                $content = json_decode($cartInstance->content, true);
                if ($content) {
                    foreach ($content as $key => $dataItem) {
                        \Cart::instance($instance)->add($dataItem);
                    }
                }
            }
        }

        if ($arrayInstance) {
            foreach ($arrayInstance as  $instance) {
                if (\Cart::instance($instance)->content()->count()) {
                    \Cart::instance($instance)->saveDatabase($userId);
                }
            }
        }
    }
}

if (!function_exists('sc_time_now') && !in_array('sc_time_now', config('helper_except', []))) {
    /**
     * Return object carbon
     */
    function sc_time_now($timezone = null)
    {
        return (new \Carbon\Carbon)->now($timezone);
    }
}

if (!function_exists('sc_request') && !in_array('sc_request', config('helper_except', []))) {
    /**
     * Return object carbon
     */
    function sc_request($key = null, $default = null, string $type = null)
    {

        if ($type == 'string') {
            if (is_array(request($key, $default))) {
                return 'array';
            }
        }

        if ($type == 'array') {
            if (is_string(request($key, $default))) {
                return [request($key, $default)];
            }
        }

        return request($key, $default);
    }
}
