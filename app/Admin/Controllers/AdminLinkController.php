<?php
#app/Http/Admin/Controllers/AdminLinkController.php
namespace App\Admin\Controllers;

use App\Http\Controllers\Controller;
use App\Models\ShopLink;
use Illuminate\Http\Request;
use Validator;

class AdminLinkController extends Controller
{

    protected $arrTarget;
    protected $arrGroup;

    public function __construct()
    {
        $this->arrTarget = ['_blank' => '_blank', '_self' => '_self'];
        $this->arrGroup = [
            'menu' => trans('link.link_position.menu'), 
            'menu_left' => trans('link.link_position.menu_left'), 
            'menu_right' => trans('link.link_position.menu_right'),
            'footer' => trans('link.link_position.footer'),
            'footer_right' => trans('link.link_position.footer_right'),
            'footer_left' => trans('link.link_position.footer_left'),
            'sidebar' => trans('link.link_position.sidebar'),
        ];
    }
    public function index()
    {

        $data = [
            'title' => trans('link.admin.list'),
            'subTitle' => '',
            'icon' => 'fa fa-indent',
            'urlDeleteItem' => sc_route('admin_link.delete'),
            'removeList' => 0, // 1 - Enable function delete list item
            'buttonRefresh' => 1, // 1 - Enable button refresh
            'buttonSort' => 0, // 1 - Enable button sort
            'css' => '', 
            'js' => '',
        ];
        //Process add content
        $data['menuRight'] = sc_config_group('menuRight', \Request::route()->getName());
        $data['menuLeft'] = sc_config_group('menuLeft', \Request::route()->getName());
        $data['topMenuRight'] = sc_config_group('topMenuRight', \Request::route()->getName());
        $data['topMenuLeft'] = sc_config_group('topMenuLeft', \Request::route()->getName());
        $data['blockBottom'] = sc_config_group('blockBottom', \Request::route()->getName());

        $listTh = [
            'name' => trans('link.name'),
            'url' => trans('link.url'),
            'target' => trans('link.target'),
            'group' => trans('link.group'),
            'sort' => trans('link.sort'),
            'status' => trans('link.status'),
            'action' => trans('link.admin.action'),
        ];
        $objOrder = new ShopLink;
        $objOrder = $objOrder->orderBy('id', 'desc');
        $dataTmp = $objOrder->paginate(20);

        $dataTr = [];
        foreach ($dataTmp as $key => $row) {
            $dataTr[] = [
                'name' => sc_language_render($row['name']),
                'url' => $row['url'],
                'target' => $this->arrTarget[$row['target']] ?? '',
                'group' => $this->arrGroup[$row['group']] ?? '',
                'sort' => $row['sort'],
                'status' => $row['status'] ? '<span class="badge badge-success">ON</span>' : '<span class="badge badge-danger">OFF</span>',
                'action' => '
                    <a href="' . sc_route('admin_link.edit', ['id' => $row['id']]) . '"><span title="' . trans('link.admin.edit') . '" type="button" class="btn btn-flat btn-primary"><i class="fa fa-edit"></i></span></a>&nbsp;

                  <span onclick="deleteItem(' . $row['id'] . ');"  title="' . trans('link.admin.delete') . '" class="btn btn-flat btn-danger"><i class="fas fa-trash-alt"></i></span>
                  ',
            ];
        }

        $data['listTh'] = $listTh;
        $data['dataTr'] = $dataTr;
        $data['pagination'] = $dataTmp->appends(request()->except(['_token', '_pjax']))->links('admin.component.pagination');
        $data['resultItems'] = trans('link.admin.result_item', ['item_from' => $dataTmp->firstItem(), 'item_to' => $dataTmp->lastItem(), 'item_total' => $dataTmp->total()]);

//menuRight
        $data['menuRight'][] = '<a href="' . sc_route('admin_link.create') . '" class="btn  btn-success  btn-flat" title="New" id="button_create_new">
                           <i class="fa fa-plus" title="' . trans('link.admin.add_new') . '"></i>
                           </a>';
//=menuRight

        return view('admin.screen.list')
            ->with($data);
    }

/**
 * Form create new order in admin
 * @return [type] [description]
 */
    public function create()
    {
        $data = [
            'title' => trans('link.admin.add_new_title'),
            'subTitle' => '',
            'title_description' => trans('link.admin.add_new_des'),
            'icon' => 'fa fa-plus',
            'link' => [],
            'arrTarget' => $this->arrTarget,
            'arrGroup' => $this->arrGroup,
            'url_action' => sc_route('admin_link.create'),
        ];
        return view('admin.screen.link')
            ->with($data);
    }

/**
 * Post create new order in admin
 * @return [type] [description]
 */
    public function postCreate()
    {
        $data = request()->all();
        $dataOrigin = request()->all();
        $validator = Validator::make($dataOrigin, [
            'name' => 'required',
            'url' => 'required',
            'group' => 'required',
            'target' => 'required',
        ]);

        if ($validator->fails()) {
            // dd($validator->messages());
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }
        $dataInsert = [
            'name' => $data['name'],
            'url' => $data['url'],
            'target' => $data['target'],
            'group' => $data['group'],
            'sort' => $data['sort'],
            'status' => empty($data['status']) ? 0 : 1,
        ];
        ShopLink::create($dataInsert);
//
        return redirect()->route('admin_link.index')->with('success', trans('link.admin.create_success'));

    }

/**
 * Form edit
 */
    public function edit($id)
    {
        $link = ShopLink::find($id);
        if ($link === null) {
            return 'no data';
        }
        $data = [
            'title' => trans('link.admin.edit'),
            'subTitle' => '',
            'title_description' => '',
            'icon' => 'fa fa-edit',
            'link' => $link,
            'arrTarget' => $this->arrTarget,
            'arrGroup' => $this->arrGroup,
            'url_action' => sc_route('admin_link.edit', ['id' => $link['id']]),
        ];
        return view('admin.screen.link')
            ->with($data);
    }

/**
 * update status
 */
    public function postEdit($id)
    {
        $data = request()->all();
        $dataOrigin = request()->all();
        $validator = Validator::make($dataOrigin, [
            'name' => 'required',
            'url' => 'required',
            'group' => 'required',
            'target' => 'required',
        ]);

        if ($validator->fails()) {
            // dd($validator->messages());
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }
//Edit
        $dataUpdate = [
            'name' => $data['name'],
            'url' => $data['url'],
            'target' => $data['target'],
            'group' => $data['group'],
            'sort' => $data['sort'],
            'status' => empty($data['status']) ? 0 : 1,
        ];
        $obj = ShopLink::find($id);
        $obj->update($dataUpdate);
//
        return redirect()->route('admin_link.index')->with('success', trans('link.admin.edit_success'));

    }

/*
Delete list item
Need mothod destroy to boot deleting in model
 */
    public function deleteList()
    {
        if (!request()->ajax()) {
            return response()->json(['error' => 1, 'msg' => 'Method not allow!']);
        } else {
            $ids = request('ids');
            $arrID = explode(',', $ids);
            ShopLink::destroy($arrID);
            return response()->json(['error' => 0, 'msg' => '']);
        }
    }

}
