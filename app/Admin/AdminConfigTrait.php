<?php

namespace App\Admin;

use App\Models\AdminConfig;

/**
 * Trait Admin.
 */
trait AdminConfigTrait
{

    /*
    Update value config
    */
    public function updateInfo()
    {
        
        $data = request()->all();
        $name = $data['name'];
        $value = $data['value'];
        try {
            AdminConfig::where('key', $name)
                ->update(['value' => $value]);
            $error = 0;
            $msg = trans('admin.update_success');
        } catch (\Exception $e) {
            $error = 1;
            $msg = $e->getMessage();
        }
        return response()->json([
            'error' => $error,
            'field' => $name,
            'value' => $value,
            'msg' => $msg,
        ]);

    }

    /*
    Delete list item
    Need mothod destroy to boot deleting in model
    */
    public function deleteList()
    {
        if (!request()->ajax()) {
            $error = 1;
            $msg = 'Method not allow!';
        } else {
            $ids = request('ids');
            $arrID = explode(',', $ids);
            try {
                AdminConfig::destroy($arrID);
                $error = 0;
                $msg = '';
            } catch (\Exception $e) {
                $error = 1;
                $msg = $e->getMessage();
            }
            return response()->json(['error' => $error, 'msg' => $msg]);
        }
    }
}
