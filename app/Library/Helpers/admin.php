<?php 

if (!function_exists('sc_admin_can_config')) {
    /**
     * Get value config from table sc_admin_can_config
     *
     * @return  [type]          [return description]
     */
    function sc_admin_can_config()
    {
        return \App\Admin\Admin::user()->checkPermissionconfig();
    }
}