<?php
namespace App\Pmo\Admin\Controllers;

use App\Pmo\Admin\Controllers\RootAdminController;
use App\Pmo\Admin\Models\AdminStoreBlockContent;
use App\Pmo\Admin\Models\AdminStore;
use App\Pmo\Admin\Models\AdminPage;
use App\Pmo\Front\Models\ShopLayoutPage;
use App\Pmo\Front\Models\ShopLayoutPosition;
use Validator;

class AdminStoreBlockController extends RootAdminController
{
    public $layoutType;
    public $layoutPage;
    public $layoutPosition;
    public function __construct()
    {
        parent::__construct();
        $this->layoutPage = ShopLayoutPage::getPages();
        $this->layoutType = ['html'=>'Html', 'view' => 'View', 'page' => 'Page'];
        $this->layoutPosition = ShopLayoutPosition::getPositions();
    }

    public function index()
    {
        $data = [
            'title'         => sc_language_render('admin.store_block.list'),
            'subTitle'      => '',
            'icon'          => 'fa fa-indent',
            'urlDeleteItem' => sc_route_admin('admin_store_block.delete'),
            'removeList'    => 0, // 1 - Enable function delete list item
            'buttonRefresh' => 0, // 1 - Enable button refresh
            'buttonSort'    => 0, // 1 - Enable button sort
            'css'           => '',
            'js'            => '',
        ];
        //Process add content
        $data['menuRight'] = sc_config_group('menuRight', \Request::route()->getName());
        $data['menuLeft'] = sc_config_group('menuLeft', \Request::route()->getName());
        $data['topMenuRight'] = sc_config_group('topMenuRight', \Request::route()->getName());
        $data['topMenuLeft'] = sc_config_group('topMenuLeft', \Request::route()->getName());
        $data['blockBottom'] = sc_config_group('blockBottom', \Request::route()->getName());

        $listTh = [
            'name'     => sc_language_render('admin.store_block.name'),
            'type'     => sc_language_render('admin.store_block.type'),
            'position' => sc_language_render('admin.store_block.position'),
            'page'     => sc_language_render('admin.store_block.page'),
            'text'     => sc_language_render('admin.store_block.text'),
            'sort'     => sc_language_render('admin.store_block.sort'),
            'status'   => sc_language_render('admin.store_block.status'),
            'template'   => 'Template',
        ];
        if (sc_check_multi_shop_installed() && session('adminStoreId') == SC_ID_ROOT) {
            // Only show store info if store is root
            $listTh['shop_store'] = sc_language_render('front.store_list');
        }
        $listTh['action'] = sc_language_render('action.title');

        $dataTmp = (new AdminStoreBlockContent)->getStoreBlockContentListAdmin();

        $dataTr = [];
        foreach ($dataTmp as $key => $row) {
            $htmlPage = '';
            if (!$row['page']) {
                $htmlPage .= '';
            } elseif (strpos($row['page'], '*') !== false) {
                $htmlPage .= sc_language_render('admin.layout_page_position.all');
            } else {
                $arrPage = explode(',', $row['page']);
                foreach ($arrPage as $key => $value) {
                    $htmlPage .= '+' . $value . '<br>';
                }
            }

            $type_name = $this->layoutType[$row['type']] ?? '';
            if ($row['type'] == 'view') {
                $type_name = '<span class="badge badge-warning">' . $type_name . '</span>';
            } elseif ($row['type'] == 'html') {
                $type_name = '<span class="badge badge-primary">' . $type_name . '</span>';
            }        

            $storeTmp = [
                'name' => $row['name'],
                'type' => $type_name,
                'position' => htmlspecialchars(sc_language_render($this->layoutPosition[$row['position']]) ?? ''),
                'page' => $htmlPage,
                'text' => htmlspecialchars($row['text']),
                'sort' => $row['sort'],
                'status' => $row['status'] ? '<span class="badge badge-success">ON</span>' : '<span class="badge badge-danger">OFF</span>',
                'template' => $row['template'],
            ];

            if (sc_check_multi_shop_installed() && session('adminStoreId') == SC_ID_ROOT) {
                $storeCode = sc_get_list_code_store()[$row['store_id']] ?? '';
                // Only show store info if store is root
                $storeTmp['shop_store'] = '<i class="nav-icon fab fa-shopify"></i><a target=_new href="'.sc_get_domain_from_code($storeCode).'">'.$storeCode.'</a>';
            }

            $storeTmp['action'] = '
                <a href="' . sc_route_admin('admin_store_block.edit', ['id' => $row['id'] ? $row['id'] : 'not-found-id']) . '"><span title="' . sc_language_render('action.edit') . '" type="button" class="btn btn-flat btn-sm btn-primary"><i class="fa fa-edit"></i></span></a>&nbsp;
            <span onclick="deleteItem(\'' . $row['id'] . '\');"  title="' . sc_language_render('action.delete') . '" class="btn btn-flat btn-sm btn-danger"><i class="fas fa-trash-alt"></i></span>
            ';
            $dataTr[$row['id']] = $storeTmp;

        }

        $data['listTh'] = $listTh;
        $data['dataTr'] = $dataTr;
        $data['pagination'] = $dataTmp->appends(request()->except(['_token', '_pjax']))->links($this->templatePathAdmin.'component.pagination');
        $data['resultItems'] = sc_language_render('admin.result_item', ['item_from' => $dataTmp->firstItem(), 'item_to' => $dataTmp->lastItem(), 'total' =>  $dataTmp->total()]);

        //menuRight
        $data['menuRight'][] = '
                           <a href="' . sc_route_admin('admin_store_block.create') . '" class="btn  btn-success  btn-flat" title="New" id="button_create_new">
                           <i class="fa fa-plus" title="'.sc_language_render('action.add').'"></i>
                           </a>';
        //=menuRight

        return view($this->templatePathAdmin.'screen.list')
            ->with($data);
    }

    /**
     * Form create new item in admin
     * @return [type] [description]
     */
    public function create()
    {
        $listViewBlock = $this->getListViewBlock();
        $listViewPage = $this->getListPageBlock();
        $data = [
            'title'             => sc_language_render('admin.store_block.add_new_title'),
            'subTitle'          => '',
            'title_description' => sc_language_render('admin.store_block.add_new_des'),
            'icon'              => 'fa fa-plus',
            'layoutPosition'    => $this->layoutPosition,
            'layoutPage'        => $this->layoutPage,
            'layoutType'        => $this->layoutType,
            'listViewBlock'     => $listViewBlock,
            'listViewPage'     => $listViewPage,
            'layout'            => [],
            'url_action'        => sc_route_admin('admin_store_block.create'),
        ];
        return view($this->templatePathAdmin.'screen.store_block')
            ->with($data);
    }

    /**
     * Post create new item in admin
     * @return [type] [description]
     */
    public function postCreate()
    {
        $storeId = $data['store_id'] ?? session('adminStoreId');
        $store = AdminStore::find($storeId);
        $data = request()->all();
        $dataOrigin = request()->all();
        $validator = Validator::make($dataOrigin, [
            'name' => 'required',
            'page' => 'required',
            'position' => 'required',
            'text' => 'required',
            'type' => 'required',
        ]);

        if ($validator->fails()) {

            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        $dataCreate = [
            'id'       => sc_uuid(),
            'name'     => $data['name'],
            'position' => $data['position'],
            'page'     => in_array('*', $data['page'] ?? []) ? '*' : implode(',', $data['page'] ?? []),
            'text'     => $data['text'],
            'type'     => $data['type'],
            'sort'     => (int) $data['sort'],
            'template' => $store->template,
            'status'   => (empty($data['status']) ? 0 : 1),
            'store_id' => $storeId,
        ];
        $dataCreate = sc_clean($dataCreate, ['text'], true);
        AdminStoreBlockContent::createStoreBlockContentAdmin($dataCreate);
        
        return redirect()->route('admin_store_block.index')->with('success', sc_language_render('action.create_success'));
    }

    /**
     * Form edit
     */
    public function edit($id)
    {
        $layout = (new AdminStoreBlockContent)->getStoreBlockContentAdmin($id);
        if (!$layout) {
            return redirect()->route('admin.data_not_found')->with(['url' => url()->full()]);
        }

        $listViewBlock = $this->getListViewBlock($layout->store_id);
        $listViewPage = $this->getListPageBlock($layout->store_id);

        $data = [
            'title' => sc_language_render('action.edit'),
            'subTitle' => '',
            'title_description' => '',
            'icon' => 'fa fa-edit',
            'layoutPosition' => $this->layoutPosition,
            'layoutPage' => $this->layoutPage,
            'layoutType' => $this->layoutType,
            'listViewBlock' => $listViewBlock,
            'listViewPage' => $listViewPage,
            'layout' => $layout,
            'storeId' => $layout->store_id,
            'url_action' => sc_route_admin('admin_store_block.edit', ['id' => $layout['id']]),
        ];
        return view($this->templatePathAdmin.'screen.store_block')
            ->with($data);
    }

    /**
     * update status
     */
    public function postEdit($id)
    {
        $storeId = $data['store_id'] ?? session('adminStoreId');
        $store = AdminStore::find($storeId);

        $layout = (new AdminStoreBlockContent)->getStoreBlockContentAdmin($id);
        if (!$layout) {
            return redirect()->route('admin.data_not_found')->with(['url' => url()->full()]);
        }
        $data = request()->all();
        $dataOrigin = request()->all();
        $validator = Validator::make($dataOrigin, [
            'name' => 'required',
        ], [
            'name.required' => sc_language_render('validation.required'),
        ]);

        if ($validator->fails()) {

            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }
        //Edit
        $dataUpdate = [
            'name' => $data['name'],
            'position' => $data['position'],
            'page' => in_array('*', $data['page'] ?? []) ? '*' : implode(',', $data['page'] ?? []),
            'text' => $data['text'],
            'type' => $data['type'],
            'sort' => (int) $data['sort'],
            'template' => $store->template,
            'status' => (empty($data['status']) ? 0 : 1),
            'store_id' => $storeId,
        ];
        $dataUpdate = sc_clean($dataUpdate, ['text'], true);
        $layout->update($dataUpdate);
        
        return redirect()->route('admin_store_block.index')->with('success', sc_language_render('action.edit_success'));
    }

    /*
    Delete list item
    Need mothod destroy to boot deleting in model
    */
    public function deleteList()
    {
        if (!request()->ajax()) {
            return response()->json(['error' => 1, 'msg' => sc_language_render('admin.method_not_allow')]);
        } else {
            $ids = request('ids');
            $arrID = explode(',', $ids);
            $arrDontPermission = [];
            foreach ($arrID as $key => $id) {
                if (!$this->checkPermisisonItem($id)) {
                    $arrDontPermission[] = $id;
                }
            }
            if (count($arrDontPermission)) {
                return response()->json(['error' => 1, 'msg' => sc_language_render('admin.remove_dont_permisison') . ': ' . json_encode($arrDontPermission)]);
            }
            AdminStoreBlockContent::destroy($arrID);
            return response()->json(['error' => 0, 'msg' => '']);
        }
    }

    /**
     * Get view block
     *
     * @return  [type]  [return description]
     */
    public function getListViewBlock($storeId = null)
    {
        $arrView = [];
        foreach (glob(base_path() . "/resources/views/templates/".sc_store('template', $storeId)."/block/*.blade.php") as $file) {
            if (file_exists($file)) {
                $arr = explode('/', $file);
                $arrView[substr(end($arr), 0, -10)] = substr(end($arr), 0, -10);
            }
        }
        return $arrView;
    }

    /**
     * Get list alias page
     *
     * @return  [type]  [return description]
     */
    public function getListPageBlock($storeId = null)
    {
        $arrPage = (new AdminPage)->getListPageAlias($storeId);
        return $arrPage;
    }

    
    /**
     * Check permisison item
     */
    public function checkPermisisonItem($id)
    {
        return (new AdminStoreBlockContent)->getStoreBlockContentAdmin($id);
    }

    /**
     * Get json list view block
     *
     * @return void
     */
    public function getListViewBlockHtml() {
        if (!request()->ajax()) {
            $html =  '';
        } else {
            $html = '<select name="text" class="form-control text">';
            $storeId = request('store_id');
            $arrView = [];
            foreach (glob(base_path() . "/resources/views/templates/".sc_store('template', $storeId)."/block/*.blade.php") as $file) {
                if (file_exists($file)) {
                    $arr = explode('/', $file);
                    $arrView[substr(end($arr), 0, -10)] = substr(end($arr), 0, -10);
                    $html .='<option value="'.substr(end($arr), 0, -10).'">'.substr(end($arr), 0, -10);
                    $html .='</option>';
                }
            }
            $html .='</select>';
            $html .='<span class="form-text"><i class="fa fa-info-circle"></i>';
            $html .= sc_language_render('admin.store_block.helper_view', ['template' => sc_store('template', $storeId)]);
            $html .='</span>';
        }
        return $html;
    }

    /**
     * Get json list page block html
     *
     * @return void
     */
    public function getListPageBlockHtml() {
        if (!request()->ajax()) {
            $html =  '';
        } else {
            $html = '<select name="text" class="form-control text">';
            $storeId = request('store_id');
            $arrPage = (new AdminPage)->getListPageAlias($storeId);
            foreach ($arrPage as $value) {
                $html .='<option value="'.$value.'">'.$value;
                $html .='</option>';
            }
            $html .='</select>';
        }
        return $html;
    }
}
