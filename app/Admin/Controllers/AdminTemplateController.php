<?php
#app/Http/Admin/Controllers/AdminTemplateController.php
namespace App\Admin\Controllers;

use App\Http\Controllers\Controller;
use App\Models\AdminStore;
use Illuminate\Support\Facades\File;

class AdminTemplateController extends Controller
{
    public function index()
    {

        $data = [
            'title' => trans('template.admin.list'),
            'subTitle' => '',
            'icon' => 'fa fa-indent',
        ];

        $data["templates"] = sc_get_all_template();
        $data["templateCurrent"] = sc_store('template');
        return view('admin.screen.template')
            ->with($data);
    }

    public function changeTemplate()
    {
        $key = request('key');
        $process = AdminStore::first()->update(['template' => $key]);
        if ($process) {
            $return = ['error' => 0, 'msg' => 'Change template success!'];
        } else {
            $return = ['error' => 1, 'msg' => 'Have an error!'];
        }
        return response()->json($return);
    }

    public function remove()
    {
        $key = request('key');
        try {
            File::deleteDirectory(public_path('templates/'.$key));
            File::deleteDirectory(resource_path('views/templates/'.$key));
            $response = ['error' => 0, 'msg' => 'Remove template success'];
        } catch(\Exception $e) {
            $response = ['error' => 0, 'msg' => $e->getMessage()];
        }
        return response()->json($response);
    }

}
