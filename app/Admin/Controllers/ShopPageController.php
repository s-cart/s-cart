<?php
#app/Http/Admin/Controllers/ShopPageController.php
namespace App\Admin\Controllers;

use App\Http\Controllers\Controller;
use App\Models\ShopLanguage;
use App\Models\ShopPage;
use App\Models\ShopPageDescription;
use Illuminate\Http\Request;
use Validator;

class ShopPageController extends Controller
{
    public $languages;

    public function __construct()
    {
        $this->languages = ShopLanguage::getList();

    }

    public function index()
    {
        $data = [
            'title' => trans('page.admin.list'),
            'subTitle' => '',
            'icon' => 'fa fa-indent',
            'urlDeleteItem' => route('admin_page.delete'),
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

        $listTh = [
            'title' => trans('page.title'),
            'image' => trans('page.image'),
            'alias' => trans('page.alias'),
            'status' => trans('page.status'),
            'action' => trans('page.admin.action'),
        ];
        $sort_order = request('sort_order') ?? 'id_desc';
        $keyword = request('keyword') ?? '';
        $arrSort = [
            'id__desc' => trans('page.admin.sort_order.id_desc'),
            'id__asc' => trans('page.admin.sort_order.id_asc'),
            'title__desc' => trans('page.admin.sort_order.title_desc'),
            'title__asc' => trans('page.admin.sort_order.title_asc'),
        ];
        $obj = new ShopPage;

        $obj = $obj
            ->leftJoin(SC_DB_PREFIX.'shop_page_description', SC_DB_PREFIX.'shop_page_description.page_id', SC_DB_PREFIX.'shop_page.id')
            ->where(SC_DB_PREFIX.'shop_page_description.lang', sc_get_locale());
        if ($keyword) {
            $obj = $obj->whereRaw('("'.ShopPage::class.'"_description.title like "%' . $keyword . '%" )');
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
                'title' => $row['title'],
                'image' => sc_image_render($row['image'], '50px','',$row['title']),
                'alias' => $row['alias'],
                'status' => $row['status'] ? '<span class="label label-success">ON</span>' : '<span class="label label-danger">OFF</span>',
                'action' => '
                    <a href="' . route('admin_page.edit', ['id' => $row['id']]) . '"><span title="' . trans('page.admin.edit') . '" type="button" class="btn btn-flat btn-primary"><i class="fa fa-edit"></i></span></a>&nbsp;

                      <span ' . (in_array($row['id'], SC_GUARD_PAGES) ? "style='display:none'" : "") . ' onclick="deleteItem(' . $row['id'] . ');"  title="' . trans('language.admin.delete') . '" class="btn btn-flat btn-danger"><i class="fa fa-trash"></i></span>'
                ,
            ];
        }

        $data['listTh'] = $listTh;
        $data['dataTr'] = $dataTr;
        $data['pagination'] = $dataTmp->appends(request()->except(['_token', '_pjax']))->links('admin.component.pagination');
        $data['resultItems'] = trans('page.admin.result_item', ['item_from' => $dataTmp->firstItem(), 'item_to' => $dataTmp->lastItem(), 'item_total' => $dataTmp->total()]);


//menuRight
        $data['menuRight'][] = '<a href="' . route('admin_page.create') . '" class="btn  btn-success  btn-flat" title="New" id="button_create_new">
                           <i class="fa fa-plus" title="'.trans('admin.add_new').'"></i>
                           </a>';
//=menuRight

//menuSort        
        $optionSort = '';
        foreach ($arrSort as $key => $status) {
            $optionSort .= '<option  ' . (($sort_order == $key) ? "selected" : "") . ' value="' . $key . '">' . $status . '</option>';
        }

        $data['urlSort'] = route('admin_page.index');
        $data['optionSort'] = $optionSort;
//=menuSort

//menuSearch        
        $data['topMenuRight'][] = '
                <form action="' . route('admin_page.index') . '" id="button_search">
                   <div onclick="$(this).submit();" class="btn-group pull-right">
                           <a class="btn btn-flat btn-primary" title="Refresh">
                              <i class="fa  fa-search"></i>
                           </a>
                   </div>
                   <div class="btn-group pull-right">
                         <div class="form-group">
                           <input type="text" name="keyword" class="form-control" placeholder="' . trans('page.admin.search_place') . '" value="' . $keyword . '">
                         </div>
                   </div>
                </form>';
//=menuSearch

        return view('admin.screen.list')
            ->with($data);
    }

/**
 * Form create new order in admin
 * @return [type] [description]
 */
    public function create()
    {
        $page = [];
        $data = [
            'title' => trans('page.admin.add_new_title'),
            'subTitle' => '',
            'title_description' => trans('page.admin.add_new_des'),
            'icon' => 'fa fa-plus',
            'languages' => $this->languages,
            'page' => $page,
            'url_action' => route('admin_page.create'),

        ];

        return view('admin.screen.page')
            ->with($data);
    }

/**
 * Post create new order in admin
 * @return [type] [description]
 */
    public function postCreate()
    {

        $data = request()->all();
        $langFirst = array_key_first(sc_language_all()->toArray()); //get first code language active
        $data['alias'] = !empty($data['alias'])?$data['alias']:$data['descriptions'][$langFirst]['title'];
        $data['alias'] = sc_word_format_url($data['alias']);
        $data['alias'] = sc_word_limit($data['alias'], 100);
        $validator = Validator::make($data, [
            'alias' => 'required|regex:/(^([0-9A-Za-z\-_]+)$)/|unique:"'.ShopPage::class.'",alias|string|max:100',
            'descriptions.*.title' => 'required|string|max:200',
            'descriptions.*.keyword' => 'nullable|string|max:200',
            'descriptions.*.description' => 'nullable|string|max:300',
        ], [
            'alias.regex' => trans('page.alias_validate'),
            'descriptions.*.title.required' => trans('validation.required', ['attribute' => trans('page.title')]),
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput($data);
        }

        $dataInsert = [
            'image' => $data['image'],
            'alias' => $data['alias'],
            'status' => !empty($data['status']) ? 1 : 0,
        ];
        $id = ShopPage::insertGetId($dataInsert);
        $dataDes = [];
        $languages = $this->languages;
        foreach ($languages as $code => $value) {
            $dataDes[] = [
                'page_id' => $id,
                'lang' => $code,
                'title' => $data['descriptions'][$code]['title'],
                'keyword' => $data['descriptions'][$code]['keyword'],
                'description' => $data['descriptions'][$code]['description'],
                'content' => $data['descriptions'][$code]['content'],
            ];
        }
        ShopPageDescription::insert($dataDes);

        return redirect()->route('admin_page.index')->with('success', trans('page.admin.create_success'));

    }

/**
 * Form edit
 */
    public function edit($id)
    {
        $page = ShopPage::find($id);
        if ($page === null) {
            return 'no data';
        }
        $data = [
            'title' => trans('page.admin.edit'),
            'subTitle' => '',
            'title_description' => '',
            'icon' => 'fa fa-pencil-square-o',
            'languages' => $this->languages,
            'page' => $page,
            'url_action' => route('admin_page.edit', ['id' => $page['id']]),
        ];
        return view('admin.screen.page')
            ->with($data);
    }

/**
 * update status
 */
    public function postEdit($id)
    {
        $page = ShopPage::find($id);
        $data = request()->all();
        $langFirst = array_key_first(sc_language_all()->toArray()); //get first code language active
        $data['alias'] = !empty($data['alias'])?$data['alias']:$data['descriptions'][$langFirst]['title'];
        $data['alias'] = sc_word_format_url($data['alias']);
        $data['alias'] = sc_word_limit($data['alias'], 100);

        $validator = Validator::make($data, [
            'descriptions.*.title' => 'required|string|max:200',
            'descriptions.*.keyword' => 'nullable|string|max:200',
            'descriptions.*.description' => 'nullable|string|max:300',
            'alias' => 'required|regex:/(^([0-9A-Za-z\-_]+)$)/|unique:"'.ShopPage::class.'",alias,' . $page->id . ',id|string|max:100',
        ], [
            'alias.regex' => trans('page.alias_validate'),
            'descriptions.*.title.required' => trans('validation.required', ['attribute' => trans('page.title')]),
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput($data);
        }
//Edit

        $dataUpdate = [
            'image' => $data['image'],
            'status' => empty($data['status']) ? 0 : 1,
        ];
        if (!empty($data['alias'])) {
            $dataUpdate['alias'] = $data['alias'];
        }
        $obj = ShopPage::find($id);
        $obj->update($dataUpdate);
        $obj->descriptions()->delete();
        $dataDes = [];
        foreach ($data['descriptions'] as $code => $row) {
            $dataDes[] = [
                'page_id' => $id,
                'lang' => $code,
                'title' => $row['title'],
                'keyword' => $row['keyword'],
                'description' => $row['description'],
                'content' => $row['content'],
            ];
        }
        ShopPageDescription::insert($dataDes);

//
        return redirect()->route('admin_page.index')->with('success', trans('page.admin.edit_success'));

    }

/*
Delete list Item
Need mothod destroy to boot deleting in model
 */
    public function deleteList()
    {
        if (!request()->ajax()) {
            return response()->json(['error' => 1, 'msg' => 'Method not allow!']);
        } else {
            $ids = request('ids');
            $arrID = explode(',', $ids);
            ShopPage::destroy($arrID);
            return response()->json(['error' => 0, 'msg' => '']);
        }
    }

}
