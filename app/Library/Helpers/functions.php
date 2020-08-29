<?php

use App\Models\AdminConfig;
use App\Models\AdminStore;
use App\Models\ShopBlockContent;
use App\Models\ShopLanguage;
use App\Models\ShopLink;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Str;
/*
Get all block content
 */
if (!function_exists('sc_link')) {
    function sc_link()
    {
        return ShopLink::getGroup();
    }
}

/*
Get all layouts
 */
if (!function_exists('sc_block_content')) {
    function sc_block_content()
    {
        return ShopBlockContent::getLayout();
    }
}

/*
String to Url
 */
if (!function_exists('sc_word_format_url')) {
    function sc_word_format_url($str)
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
            array('/[\'\/~`\!@#\$%\^&\*\(\)\+=\{\}\[\]\|;:"\<\>,\.\?\\\]/', '/[\s-]+|[-\s]+|[--]+/', '/^[-\s_]|[-_\s]$/'),
            array('', '-', ''),
            strtolower($str)
        ));
    }
}

if (!function_exists('sc_config')) {
    /**
     * Get value config from table sc_config
     *
     * @param   [string|array] $key      [$key description]
     * @param   [null|int]  $store    Store id.
     *
     * @return  [type]          [return description]
     */
    function sc_config($key = null, $storeId = null)
    {
        $storeId = ($storeId === null) ? config('app.storeId') : $storeId;
        //Update config
        if (is_array($key)) {
            if (count($key) == 1) {
                foreach ($key as $k => $v) {
                    return AdminConfig::where('store_id', $storeId)->where('key', $k)->update(['value' => $v]);
                }
            } else {
                return false;
            }
        }
        //End update

        $allConfig = AdminConfig::getAllStore($storeId);

        if ($key === null) {
            return $allConfig;
        }
        return $allConfig[$key] ?? (sc_config_global()[$key] ?? null);
    }
}


if (!function_exists('sc_config_global')) {
    /**
     * Get value config from table sc_config for store_id 0
     *
     * @param   [string|array] $key      [$key description]
     * @param   [null|int]  $store    Store id.
     *
     * @return  [type]          [return description]
     */
    function sc_config_global($key = null)
    {
        //Update config
        if (is_array($key)) {
            if (count($key) == 1) {
                foreach ($key as $k => $v) {
                    return AdminConfig::where('store_id', 0)->where('key', $k)->update(['value' => $v]);
                }
            } else {
                return false;
            }
        }
        //End update
        
        $allConfig = [];
        try {
            $allConfig = AdminConfig::getAllGlobal();
        } catch(\Throwable $e) {
            //
        }
        if ($key === null) {
            return $allConfig;
        }
        if (!array_key_exists($key, $allConfig)) {
            return null;
        } else {
            return trim($allConfig[$key]);
        }
    }
}

if (!function_exists('sc_config_group')) {
    /*
    Group Config info
     */
    function sc_config_group($group = null, $suffix = null)
    {
        $groupData = AdminConfig::getGroup($group, $suffix);
        return $groupData;
    }
}


if (!function_exists('sc_store')) {
    /**
     * Get info store
     *
     * @param   [string] $key      [$key description]
     * @param   [null|int]  $store    store id
     *
     * @return  [mix] 
     */
    function sc_store($key = null, $store = null)
    {
        $store = ($store == null) ? config('app.storeId') : $store;

        //Update store info
        if (is_array($key)) {
            if (count($key) == 1) {
                foreach ($key as $k => $v) {
                    return AdminStore::where('store_id', $store)->update([$k => $v]);
                }
            } else {
                return false;
            }
        }
        //End update

        $allStoreInfo = [];
        try {
            $allStoreInfo = AdminStore::getListAll()[$store]->toArray() ?? [];
        } catch(\Throwable $e) {
            //
        }

        $lang = app()->getLocale();
        $descriptions = $allStoreInfo['descriptions'] ?? [];
        foreach ($descriptions as $row) {
            if ($lang == $row['lang']) {
                $allStoreInfo += $row;
            }
        }
        if ($key == null) {
            return $allStoreInfo;
        }
        return $allStoreInfo[$key] ?? null;
    }
}

if (!function_exists('sc_url_render')) {
    /*
    url render
     */
    function sc_url_render($string)
    {
        $arrCheckRoute = explode('route::', $string);
        $arrCheckUrl = explode('admin::', $string);

        if (count($arrCheckRoute) == 2) {
            $arrRoute = explode('::', $string);
            if (isset($arrRoute[2])) {
                try {
                    return sc_route($arrRoute[1], $arrRoute[2]);
                } catch(\Throwable $e) {
                    sc_report($e->getMessage());
                    return false;
                }  
            } else {
                try {
                    return sc_route($arrRoute[1]);
                } catch(\Throwable $e) {
                    sc_report($e->getMessage());
                    return false;
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

if (!function_exists('sc_language_all')) {
    //Get all language
    function sc_language_all()
    {
        return ShopLanguage::getListActive();
    }
}

if (!function_exists('sc_language_render')) {
    /*
    Render language
     */
    function sc_language_render($string)
    {
        $arrCheck = explode('lang::', $string);
        if (count($arrCheck) == 2) {
            return trans($arrCheck[1]);
        } else {
            return trans($string);
        }
    }
}

if (!function_exists('sc_html_render')) {
    /*
    Html render
     */
    function sc_html_render($string)
    {
        $string = htmlspecialchars_decode($string);
        return $string;
    }
}

if (!function_exists('sc_word_format_class')) {
    /*
    Format class name
     */
    function sc_word_format_class($word)
    {
        $word = Str::camel($word);
        $word = ucfirst($word);
        return $word;
    }
}

if (!function_exists('sc_word_limit')) {
    /*
    Truncates words
     */
    function sc_word_limit($word, $limit = 20, $arg = '')
    {
        $word = Str::limit($word, $limit, $arg);
        return $word;
    }
}

if (!function_exists('sc_clean')) {
    /**
     * Clear data
     */
    function sc_clean($data = null, $exclude = [], $level_hight = null)
    {
        if ($level_hight) {
            if (is_array($data)) {
                $data = array_map(function ($v) {
                    return strip_tags($v);
                }, $data);
            } else {
                $data = strip_tags($data);
            }
        }
        if (is_array($data)) {
            array_walk($data, function (&$v, $k) use ($exclude, $level_hight) {
                if (is_array($v)) {
                    $v = sc_clean($v, $exclude, $level_hight);
                } else {
                    if ((is_array($exclude) && in_array($k, $exclude)) || (!is_array($exclude) && $k == $exclude)) {
                        $v = $v;
                    } else {
                        $v = htmlspecialchars_decode($v);
                        $v = htmlspecialchars($v, ENT_COMPAT, 'UTF-8');
                    }
                }
            });
        } else {
            $data = htmlspecialchars_decode($data);
            $data = htmlspecialchars($data, ENT_COMPAT, 'UTF-8');
        }
        return $data;
    }
}

if (!function_exists('sc_token')) {
    /*
    Create random token
     */
    function sc_token($length = 32)
    {
        $token = Str::random($length);
        return $token;
    }
}

if (!function_exists('sc_report')) {
    /*
    Handle report
     */
    function sc_report($msg)
    {
        $msg = date('Y-m-d H:i:s').':'.PHP_EOL.$msg.PHP_EOL;       
        if (config('logging.channels.slack.url')) {
            \Log::channel('slack')->error($msg);
        }
        \Log::channel('handle')->error($msg);
    }
}


if (!function_exists('sc_zip')) {
    /*
    Zip file or folder
     */
    function sc_zip(string $source, string $destination)
    {
        if (extension_loaded('zip')) {
            if (file_exists($source)) {
                $zip = new \ZipArchive();
                if ($zip->open($destination, \ZIPARCHIVE::CREATE)) {
                    $source = str_replace('\\', '/', realpath($source));
                    if (is_dir($source)) {
                        $iterator = new \RecursiveDirectoryIterator($source);
                        // skip dot files while iterating 
                        $iterator->setFlags(\RecursiveDirectoryIterator::SKIP_DOTS);
                        $files = new \RecursiveIteratorIterator($iterator, \RecursiveIteratorIterator::SELF_FIRST);
                        foreach ($files as $file) {
                            $file = str_replace('\\', '/', realpath($file));
                            if (is_dir($file)) {
                                $zip->addEmptyDir(str_replace($source . '/', '', $file . '/'));
                            } else if (is_file($file)) {
                                $zip->addFromString(str_replace($source . '/', '', $file), file_get_contents($file));
                            }
                        }
                    } else if (is_file($source)) {
                        $zip->addFromString(basename($source), file_get_contents($source));
                    }
                }
                return $zip->close();
            }
        }
        return false;
    }
}


if (!function_exists('sc_unzip')) {
    /**
     * Unzip file to folder
     *
     * @return  [type]  [return description]
     */
    function sc_unzip(string $source, string $destination)
    {
        $zip = new \ZipArchive();
        if ($zip->open(str_replace("//", "/", $source)) === true) {
            $zip->extractTo($destination);
            return $zip->close();
        }
        return false;
    }
}


if (!function_exists('sc_get_locale')) {
    /*
    Get locale
    */
    function sc_get_locale()
    {
        return app()->getLocale();
    }
}


if (!function_exists('sc_get_all_template')) {
    /*
    Get all template
    */
    function sc_get_all_template()
    {
        $arrTemplates = [];
        foreach (glob(resource_path() . "/views/templates/*") as $template) {
            if (is_dir($template)) {
                $infoTemlate['code'] = explode('templates/', $template)[1];
                $config = ['name' => '', 'auth' => '', 'email' => '', 'website' => ''];
                if (file_exists($template . '/config.json')) {
                    $config = json_decode(file_get_contents($template . '/config.json'), true);
                }
                $infoTemlate['config'] = $config;
                $arrTemplates[$infoTemlate['code']] = $infoTemlate;
            }
        }
        return $arrTemplates;
    }
}


if (!function_exists('sc_route')) {
    /**
     * Render route
     *
     * @param   [string]  $name
     *
     * @return  [type]         [return description]
     */
    function sc_route($name, $param = null)
    {
        if (Route::has($name)) {
            return route($name, $param);
        } else {
            return url('#'.$name);
        }
    }
}
