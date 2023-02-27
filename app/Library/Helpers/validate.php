<?php

if (!function_exists('sc_check_view') && !in_array('sc_check_view', config('helper_except', []))) {
    /**
     * Check view exist
     *
     * @param   [string]  $view path view
     *
     * @return  [string]         [$domain]
     */
    function sc_check_view($view)
    {
        if (!view()->exists($view)) {
            sc_report('View not found '.$view);
            echo  sc_language_render('front.view_not_exist', ['view' => $view]);
            exit();
        }
    }
}


if (!function_exists('sc_clean') && !in_array('sc_clean', config('helper_except', []))) {
    /**
     * Clear data
     */
    function sc_clean($data = null, $exclude = [], $level_high = false)
    {
        if (is_array($data)) {
            array_walk($data, function (&$v, $k) use ($exclude, $level_high) {
                if (is_array($v)) {
                    $v = sc_clean($v, $exclude, $level_high);
                } 
                if (is_string($v)) {
                    if (in_array($k, $exclude)) {
                        $v = $v;
                    } else {
                        if ($level_high) {
                            $v = strip_tags($v);
                        }
                        $v = htmlspecialchars_decode($v);
                        $v = htmlspecialchars($v, ENT_COMPAT, 'UTF-8');
                    }
                }
            });
        }
        if (is_string($data)) {
            if ($level_high) {
                $data = strip_tags($data);
            }
            $data = htmlspecialchars_decode($data);
            $data = htmlspecialchars($data, ENT_COMPAT, 'UTF-8');
        }
        return $data;
    }
}
