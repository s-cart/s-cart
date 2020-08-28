<?php
#app/Http/Admin/Controllers/AdminEmailController.php
namespace App\Admin\Controllers;

use App\Http\Controllers\Controller;
use App\Models\AdminConfig;
use Illuminate\Http\Request;
class AdminEmailController extends Controller
{
    public function index()
    {

        $data = [
            'title' => trans('email.admin.list'),
            'subTitle' => '',
            'icon' => 'fa fa-indent',        
        ];

        $obj = (new AdminConfig)
            ->whereIn('code', ['email_action', 'smtp_config'])
            ->orderBy('sort', 'asc')
            ->get()->groupBy('code');
        $data['configs'] = $obj;
        $data['smtp_method'] = ['' => 'None Secirity', 'TLS' => 'TLS', 'SSL' => 'SSL'];

        return view('admin.screen.email_config')
            ->with($data);
    }

}
