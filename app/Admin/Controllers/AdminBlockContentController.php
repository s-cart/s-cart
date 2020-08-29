<?php
#app/Http/Admin/Controllers/AdminBlockContentController.php
namespace App\Admin\Controllers;

use App\Http\Controllers\Controller;
use App\Models\ShopBlockContent;
use App\Models\ShopLayoutPage;
use App\Models\ShopLayoutPosition;
use Validator;

class AdminBlockContentController extends Controller
{

    public $layoutType;
    public $layoutPage;
    public $layoutPosition;
    public function __construct()
    {
        $this->layoutPage = ShopLayoutPage::getPages();
        $this->layoutType = ['html'=>'Html', 'view' => 'View'];
        $this->layoutPosition = ShopLayoutPosition::getPositions();
    }

    public function index()
    {

        $data = [
            'title' => trans('block_content.admin.list'),
            'subTitle' => '',
            'icon' => 'fa fa-indent',
            'urlDeleteItem' => sc_route('admin_block_content.delete'),
            'removeList' => 0, // 1 - Enable function delete list item
            'buttonRefresh' => 0, // 1 - Enable button refresh
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
            'id' => trans('block_content.id'),
            'name' => trans('block_content.name'),
            'type' => trans('block_content.type'),
            'position' => trans('block_content.position'),
            'page' => trans('block_content.page'),
            'text' => trans('block_content.text'),
            'status' => trans('block_content.status'),
            'action' => trans('block_content.admin.action'),
        ];
        $layout = new ShopBlockContent;
        $layout = $layout;
        $layout = $layout->orderBy('id', 'desc');
        $dataTmp = $layout->paginate(20);

        $dataTr = [];
        foreach ($dataTmp as $key => $row) {
            $layoutPage = $this->layoutPage;
            $htmlPage = '';
            if (!$row['page']) {
                $htmlPage .= '';
            } else
            if (strpos($row['page'], '*') !== false) {
                $htmlPage .= sc_language_render('lang::layout.page_position.all');
            } else {
                $arrPage = explode(',', $row['page']);
                foreach ($arrPage as $key => $value) {
                    $htmlPage .= '+' . sc_language_render($layoutPage[$value] ?? '') . '<br>';
                }
            }

            $type_name = $this->layoutType[$row['type']] ?? '';
            if ($row['type'] == 'view') {
                $type_name = '<span class="badge badge-warning">' . $type_name . '</span>';
            } elseif ($row['type'] == 'html') {
                $type_name = '<span class="badge badge-primary">' . $type_name . '</span>';
            }
            $dataTr[] = [
                'id' => $row['id'],
                'name' => $row['name'],
                'type' => $type_name,
                'position' => htmlspecialchars(sc_language_render($this->layoutPosition[$row['position']]) ?? ''),
                'page' => $htmlPage,
                'text' => htmlspecialchars($row['text']),
                'status' => $row['status'] ? '<span class="badge badge-success">ON</span>' : '<span class="badge badge-danger">OFF</span>',
                'action' => '
                    <a href="' . sc_route('admin_block_content.edit', ['id' => $row['id']]) . '"><span title="' . trans('block_content.admin.edit') . '" type="button" class="btn btn-flat btn-primary"><i class="fa fa-edit"></i></span></a>&nbsp;

                  <span onclick="deleteItem(' . $row['id'] . ');"  title="' . trans('block_content.admin.delete') . '" class="btn btn-flat btn-danger"><i class="fas fa-trash-alt"></i></span>
                  ',
            ];
        }

        $data['listTh'] = $listTh;
        $data['dataTr'] = $dataTr;
        $data['pagination'] = $dataTmp->appends(request()->except(['_token', '_pjax']))->links('admin.component.pagination');
        $data['resultItems'] = trans('block_content.admin.result_item', ['item_from' => $dataTmp->firstItem(), 'item_to' => $dataTmp->lastItem(), 'item_total' => $dataTmp->total()]);

        //menuRight
        $data['menuRight'][] = '
                           <a href="' . sc_route('admin_block_content.create') . '" class="btn  btn-success  btn-flat" title="New" id="button_create_new">
                           <i class="fa fa-plus" title="'.trans('admin.add_new').'"></i>
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
        $listViewBlock = $this->getListViewBlock();
        $data = [
            'title' => trans('block_content.admin.add_new_title'),
            'subTitle' => '',
            'title_description' => trans('block_content.admin.add_new_des'),
            'icon' => 'fa fa-plus',
            'layoutPosition' => $this->layoutPosition,
            'layoutPage' => $this->layoutPage,
            'layoutType' => $this->layoutType,
            'listViewBlock' => $listViewBlock,
            'layout' => [],
            'url_action' => sc_route('admin_block_content.create'),
        ];
        return view('admin.screen.block_content')
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
            'page' => 'required',
            'position' => 'required',
            'text' => 'required',
            'type' => 'required',
        ]);

        if ($validator->fails()) {
            // dd($validator->messages());
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        $dataInsert = [
            'name' => $data['name'],
            'position' => $data['position'],
            'page' => in_array('*', $data['page'] ?? []) ? '*' : implode(',', $data['page'] ?? []),
            'text' => $data['text'],
            'type' => $data['type'],
            'sort' => (int) $data['sort'],
            'status' => (empty($data['status']) ? 0 : 1),
        ];
        ShopBlockContent::create($dataInsert);
        //
        return redirect()->route('admin_block_content.index')->with('success', trans('block_content.admin.create_success'));
    }

    /**
     * Form edit
     */
    public function edit($id)
    {
        $layout = ShopBlockContent::find($id);
        if ($layout === null) {
            return 'no data';
        }
        $listViewBlock = $this->getListViewBlock();

        $data = [
            'title' => trans('block_content.admin.edit'),
            'subTitle' => '',
            'title_description' => '',
            'icon' => 'fa fa-edit',
            'layoutPosition' => $this->layoutPosition,
            'layoutPage' => $this->layoutPage,
            'layoutType' => $this->layoutType,
            'listViewBlock' => $listViewBlock,
            'layout' => $layout,
            'url_action' => sc_route('admin_block_content.edit', ['id' => $layout['id']]),
        ];
        return view('admin.screen.block_content')
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
        ], [
            'name.required' => trans('validation.required'),
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
            'position' => $data['position'],
            'page' => in_array('*', $data['page'] ?? []) ? '*' : implode(',', $data['page'] ?? []),
            'text' => $data['text'],
            'type' => $data['type'],
            'sort' => (int) $data['sort'],
            'status' => (empty($data['status']) ? 0 : 1),
        ];
        $layout = ShopBlockContent::find($id);
        $layout->update($dataUpdate);
        //
        return redirect()->route('admin_block_content.index')->with('success', trans('block_content.admin.edit_success'));
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
            ShopBlockContent::destroy($arrID);
            return response()->json(['error' => 0, 'msg' => '']);
        }
    }

    public function getListViewBlock()
    {
        $arrView = [];
        foreach (glob(base_path() . "/resources/views/templates/".sc_store('template')."/block/*.blade.php") as $file) {
            if (file_exists($file)) {
                $arr = explode('/', $file);
                $arrView[substr(end($arr), 0, -10)] = substr(end($arr), 0, -10);
            }
        }
        return $arrView;
    }

}
