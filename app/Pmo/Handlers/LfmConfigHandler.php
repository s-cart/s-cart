<?php

namespace App\Pmo\Handlers;

class LfmConfigHandler extends \UniSharp\LaravelFilemanager\Handlers\ConfigHandler
{
    public function userField()
    {
        // If domain is root, dont split folder
        if (session('adminStoreId') == SC_ID_ROOT) {
            return ;
        }

        if (sc_check_multi_vendor_installed()) {
            return session('adminStoreId');
        } else {
            return;
        }
    }
}
