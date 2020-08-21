<?php
#app/Http/Admin/Controllers/AdminBannerController.php
namespace App\Admin\Controllers;

use App\Http\Controllers\Controller;
use App\Models\ShopBanner;
use Illuminate\Http\Request;
use Validator;
use App\Models\AdminStore;
use App\Models\ShopBannerStore;
class AdminBannerController extends Controller
{
    protected $arrTarget;
    protected $dataType;
    public $stories;
    public function __construct()
    {
        $this->arrTarget = ['_blank' => '_blank', '_self' => '_self'];
        $this->dataType = ['0' => 'Banner', '1' => 'Background', '2' => 'Breadcrumbs', '3' => 'Other'];
        $this->stories = AdminStore::getListAll();
    }

    public function index()
    {

        $data = [
            'title' => trans('banner.admin.list'),
            'subTitle' => '',
            'icon' => 'fa fa-indent',
            'urlDeleteItem' => sc_route('admin_banner.delete'),
            'removeList' => 0, // 1 - Enable function delete list item
            'buttonRefresh' => 0, // 1 - Enable button refresh
            'buttonSort' => 1, // 1 - Enable button sort
            'css' => '', 
            'js' => '',
        ];
        //Process add content
        $data['menuRight'] = sc_config_group('menuRight', \Request::route()->getName());
        $data['menuLeft'] = sc_config_group('menuLeft', \Request::route()->getName());
        $data['topMenuRight'] = sc_config_group('topMenuRight', \Request::route()->getName());
        $data['topMenuLeft'] = sc_config_group('topMenuLeft', \Request::route()->getName());
        $data['blockBottom'] = sc_config_group('blockBottom', \Request::route()->getName());

        $data['stories'] = $this->stories;

        $listTh = [
            'image' => trans('banner.image'),
            'url' => trans('banner.url'),
            'sort' => trans('banner.sort'),
            'status' => trans('banner.status'),
            'click' => trans('banner.click'),
            'target' => trans('banner.target'),
            'type' => trans('banner.type'),
            'action' => trans('banner.admin.action'),
        ];

        $sort_order = request('sort_order') ?? 'id_desc';
        $keyword = request('keyword') ?? '';
        $arrSort = [
            'id__desc' => trans('banner.admin.sort_order.id_desc'),
            'id__asc' => trans('banner.admin.sort_order.id_asc'),
        ];
        $obj = new ShopBanner;
        if ($keyword) {
            $obj = $obj->whereRaw('(email like "%' . $keyword . '%" OR name like "%' . $keyword . '%" )');
        }

        if ($sort_order && array_key_exists($sort_order, $arrSort)) {
            $field = explode('__', $sort_order)[0];
            $sort_field = explode('__', $sort_order)[1];
            $obj = $obj->orderBy($field, $sort_field);

        } else {
            $obj = $obj->orderBy('id', 'desc');
        }
        $dataTmp = $obj->paginate(20);

        $dataTr = [];
        foreach ($dataTmp as $key => $row) {
            $dataTr[] = [
                'image' => sc_image_render($row->getThumb(), '', '50px', 'Banner'),
                'url' => $row['url'],
                'sort' => $row['sort'],
                'status' => $row['status'] ? '<span class="badge badge-success">ON</span>' : '<span class="badge badge-danger">OFF</span>',
                'click' => number_format($row['click']),
                'target' => $row['target'],
                'type' => $this->dataType[$row['type']]??'N/A',
                'action' => '
                    <a href="' . sc_route('admin_banner.edit', ['id' => $row['id']]) . '"><span title="' . trans('banner.admin.edit') . '" type="button" class="btn btn-flat btn-primary"><i class="fa fa-edit"></i></span></a>&nbsp;

                  <span onclick="deleteItem(' . $row['id'] . ');"  title="' . trans('banner.admin.delete') . '" class="btn btn-flat btn-danger"><i class="fas fa-trash-alt"></i></span>
                  ',
            ];
        }

        $data['listTh'] = $listTh;
        $data['dataTr'] = $dataTr;
        $data['pagination'] = $dataTmp->appends(request()->except(['_token', '_pjax']))->links('admin.component.pagination');
        $data['resultItems'] = trans('banner.admin.result_item', ['item_from' => $dataTmp->firstItem(), 'item_to' => $dataTmp->lastItem(), 'item_total' => $dataTmp->total()]);

//menuRight
        $data['menuRight'][] = '<a href="' . sc_route('admin_banner.create') . '" class="btn  btn-success  btn-flat" title="New" id="button_create_new">
        <i class="fa fa-plus" title="'.trans('admin.add_new').'"></i>
                           </a>';
//=menuRight

//menuSearch        
        $optionSort = '';
        foreach ($arrSort as $key => $status) {
            $optionSort .= '<option  ' . (($sort_order == $key) ? "selected" : "") . ' value="' . $key . '">' . $status . '</option>';
        }

        $data['urlSort'] = sc_route('admin_banner.index');
        $data['optionSort'] = $optionSort;
//=menuSort

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
            'title' => trans('banner.admin.add_new_title'),
            'subTitle' => '',
            'title_description' => trans('banner.admin.add_new_des'),
            'icon' => 'fa fa-plus',
            'banner' => [],
            'arrTarget' => $this->arrTarget,
            'dataType' => $this->dataType,
            'url_action' => sc_route('admin_banner.create'),
            'stories' => $this->stories,
        ];
        return view('admin.screen.banner')
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
            'sort' => 'numeric|min:0',
            'email' => 'email|nullable',
            'store' => 'required',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }
        $store = $data['store'] ?? [];
        $dataInsert = [
            'image' => $data['image'],
            'url' => $data['url'],
            'html' => $data['html'],
            'type' => $data['type'] ?? 0,
            'target' => $data['target'],
            'status' => empty($data['status']) ? 0 : 1,
            'sort' => (int) $data['sort'],
        ];
        $banner = ShopBanner::create($dataInsert);

        //Insert store
        if ($store) {
            $banner->stories()->attach($store);
        }
        return redirect()->route('admin_banner.index')->with('success', trans('banner.admin.create_success'));

    }

/**
 * Form edit
 */
    public function edit($id)
    {
        $banner = ShopBanner::find($id);
        if ($banner === null) {
            return 'no data';
        }
        $data = [
            'title' => trans('banner.admin.edit'),
            'subTitle' => '',
            'title_description' => '',
            'icon' => 'fa fa-edit',
            'arrTarget' => $this->arrTarget,
            'dataType' => $this->dataType,
            'banner' => $banner,
            'url_action' => sc_route('admin_banner.edit', ['id' => $banner['id']]),
            'stories' => $this->stories,
            'storiesPivot' => ShopBannerStore::where('banner_id', $id)->pluck('store_id')->all(),
        ];
        return view('admin.screen.banner')
            ->with($data);
    }

    /*
     * update status
     */
    public function postEdit($id)
    {
        $data = request()->all();
        $dataOrigin = request()->all();
        $validator = Validator::make($dataOrigin, [
            'sort' => 'numeric|min:0',
            'email' => 'email|nullable',
            'store' => 'required',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }
//Edit
        $store = $data['store'] ?? [];
        $dataUpdate = [
            'image' => $data['image'],
            'url' => $data['url'],
            'html' => $data['html'],
            'type' => $data['type'] ?? 0,
            'target' => $data['target'],
            'status' => empty($data['status']) ? 0 : 1,
            'sort' => (int) $data['sort'],

        ];
        $banner = ShopBanner::find($id);
        $banner->update($dataUpdate);

        //Update store
        $banner->stories()->detach();
        if (count($store)) {
            $banner->stories()->attach($store);
        }

//
        return redirect()->route('admin_banner.index')->with('success', trans('banner.admin.edit_success'));

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
            ShopBanner::destroy($arrID);
            return response()->json(['error' => 0, 'msg' => '']);
        }
    }

}
