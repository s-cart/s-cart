<?php
#app/Http/Admin/Controllers/AdminNewsController.php
namespace App\Admin\Controllers;

use App\Http\Controllers\Controller;
use App\Models\ShopLanguage;
use App\Models\ShopNews;
use App\Models\ShopNewsDescription;
use Illuminate\Http\Request;
use Validator;
use App\Models\AdminStore;
use App\Models\ShopNewsStore;

class AdminNewsController extends Controller
{
    public $languages, $stories;

    public function __construct()
    {
        $this->languages = ShopLanguage::getListActive();
        $this->stories = AdminStore::getListAll();

    }

    public function index()
    {
        $data = [
            'title' => trans('news.admin.list'),
            'subTitle' => '',
            'icon' => 'fa fa-indent',
            'urlDeleteItem' => sc_route('admin_news.delete'),
            'removeList' => 1, // 1 - Enable function delete list item
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
            'id' => trans('news.id'),
            'title' => trans('news.title'),
            'image' => trans('news.image'),
            'sort' => trans('news.sort'),
            'status' => trans('news.status'),
            'action' => trans('news.admin.action'),
        ];
        $sort_order = request('sort_order') ?? 'id_desc';
        $keyword = request('keyword') ?? '';
        $arrSort = [
            'id__desc' => trans('news.admin.sort_order.id_desc'),
            'id__asc' => trans('news.admin.sort_order.id_asc'),
            'title__desc' => trans('news.admin.sort_order.title_desc'),
            'title__asc' => trans('news.admin.sort_order.title_asc'),
        ];
        $obj = new ShopNews;

        $obj = $obj
            ->leftJoin(SC_DB_PREFIX.'shop_news_description', SC_DB_PREFIX.'shop_news_description.news_id', SC_DB_PREFIX.'shop_news.id')
            ->where(SC_DB_PREFIX.'shop_news_description.lang', sc_get_locale());
        if ($keyword) {
            $tableDescription = (new ShopNewsDescription)->getTable();
            $obj = $obj->whereRaw('('.$tableDescription.'.title like "%' . $keyword . '%" )');
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
                'id' => $row['id'],
                'title' => $row['title'],
                'image' => sc_image_render($row['image'], '50px',null,$row['title']),
                'sort' => $row['sort'],
                'status' => $row['status'] ? '<span class="badge badge-success">ON</span>' : '<span class="badge badge-danger">OFF</span>',
                'action' => '
                    <a href="' . sc_route('admin_news.edit', ['id' => $row['id']]) . '"><span title="' . trans('news.admin.edit') . '" type="button" class="btn btn-flat btn-primary"><i class="fa fa-edit"></i></span></a>&nbsp;

                    <span onclick="deleteItem(' . $row['id'] . ');"  title="' . trans('admin.delete') . '" class="btn btn-flat btn-danger"><i class="fas fa-trash-alt"></i></span>'
                ,
            ];
        }

        $data['listTh'] = $listTh;
        $data['dataTr'] = $dataTr;
        $data['pagination'] = $dataTmp->appends(request()->except(['_token', '_pjax']))->links('admin.component.pagination');
        $data['resultItems'] = trans('news.admin.result_item', ['item_from' => $dataTmp->firstItem(), 'item_to' => $dataTmp->lastItem(), 'item_total' => $dataTmp->total()]);


//menuRight
        $data['menuRight'][] = '<a href="' . sc_route('admin_news.create') . '" class="btn  btn-success  btn-flat" title="New" id="button_create_new">
                           <i class="fa fa-plus" title="'.trans('admin.add_new').'"></i>
                           </a>';
//=menuRight

//menuSort       
     $optionSort = '';
        foreach ($arrSort as $key => $status) {
            $optionSort .= '<option  ' . (($sort_order == $key) ? "selected" : "") . ' value="' . $key . '">' . $status . '</option>';
        }

        $data['urlSort'] = sc_route('admin_news.index');
        $data['optionSort'] = $optionSort;
//=menuSort

//menuSearch        
        $data['topMenuRight'][] = '
                <form action="' . sc_route('admin_news.index') . '" id="button_search">
                    <div class="input-group input-group" style="width: 250px;">
                        <input type="text" name="keyword" class="form-control float-right" placeholder="' . trans('news.admin.search_place') . '" value="' . $keyword . '">
                        <div class="input-group-append">
                            <button type="submit" class="btn btn-primary"><i class="fas fa-search"></i></button>
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
        $news = [];
        $data = [
            'title' => trans('news.admin.add_new_title'),
            'subTitle' => '',
            'title_description' => trans('news.admin.add_new_des'),
            'icon' => 'fa fa-plus',
            'languages' => $this->languages,
            'news' => $news,
            'url_action' => sc_route('admin_news.create'),
            'stories' => $this->stories,

        ];

        return view('admin.screen.news')
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
            'alias' => 'required|regex:/(^([0-9A-Za-z\-_]+)$)/|string|max:100',
            'descriptions.*.title' => 'required|string|max:200',
            'descriptions.*.keyword' => 'nullable|string|max:200',
            'descriptions.*.description' => 'nullable|string|max:300',
            'store' => 'required',
            ], [
                'alias.regex' => trans('news.alias_validate'),
                'descriptions.*.title.required' => trans('validation.required', ['attribute' => trans('news.title')]),
            ]
        );
        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput($data);
        }

        $store = $data['store'] ?? [];

        $dataInsert = [
            'image' => $data['image'],
            'sort' => $data['sort'],
            'alias' => $data['alias'],
            'status' => !empty($data['status']) ? 1 : 0,
        ];
        $news = ShopNews::create($dataInsert);
        $id = $news->id;
        $dataDes = [];
        $languages = $this->languages;
        foreach ($languages as $code => $value) {
            $dataDes[] = [
                'news_id' => $id,
                'lang' => $code,
                'title' => $data['descriptions'][$code]['title'],
                'keyword' => $data['descriptions'][$code]['keyword'],
                'description' => $data['descriptions'][$code]['description'],
                'content' => $data['descriptions'][$code]['content'],
            ];
        }
        ShopNewsDescription::insert($dataDes);
        //Insert store
        if ($store) {
            $news->stories()->attach($store);
        }

        return redirect()->route('admin_news.index')->with('success', trans('news.admin.create_success'));

    }

    /**
     * Form edit
     */
    public function edit($id)
    {
        $news = ShopNews::find($id);
        if ($news === null) {
            return 'no data';
        }
        $data = [
            'title' => trans('news.admin.edit'),
            'subTitle' => '',
            'title_description' => '',
            'icon' => 'fa fa-edit',
            'languages' => $this->languages,
            'news' => $news,
            'url_action' => sc_route('admin_news.edit', ['id' => $news['id']]),
            'stories' => $this->stories,
            'storiesPivot' => ShopNewsStore::where('news_id', $id)->pluck('store_id')->all(),
        ];
        return view('admin.screen.news')
            ->with($data);
    }

    /**
     * update status
     */
    public function postEdit($id)
    {
        $news = ShopNews::find($id);
        $data = request()->all();

        $langFirst = array_key_first(sc_language_all()->toArray()); //get first code language active
        $data['alias'] = !empty($data['alias'])?$data['alias']:$data['descriptions'][$langFirst]['title'];
        $data['alias'] = sc_word_format_url($data['alias']);
        $data['alias'] = sc_word_limit($data['alias'], 100);

        $validator = Validator::make($data, [
            'descriptions.*.title' => 'required|string|max:200',
            'descriptions.*.keyword' => 'nullable|string|max:200',
            'descriptions.*.description' => 'nullable|string|max:300',
            'alias' => 'required|regex:/(^([0-9A-Za-z\-_]+)$)/|string|max:100',
            'store' => 'required',
            ], [
                'alias.regex' => trans('news.alias_validate'),
                'descriptions.*.title.required' => trans('validation.required', ['attribute' => trans('news.title')]),
            ]
        );

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput($data);
        }
//Edit
        $store = $data['store'] ?? [];
        $dataUpdate = [
            'image' => $data['image'],
            'alias' => $data['alias'],
            'sort' => $data['sort'],
            'status' => !empty($data['status']) ? 1 : 0,
        ];

        $news->update($dataUpdate);
        $news->descriptions()->delete();
        $dataDes = [];
        foreach ($data['descriptions'] as $code => $row) {
            $dataDes[] = [
                'news_id' => $id,
                'lang' => $code,
                'title' => $row['title'],
                'keyword' => $row['keyword'],
                'description' => $row['description'],
                'content' => $row['content'],
            ];
        }
        ShopNewsDescription::insert($dataDes);
        //Update store
        $news->stories()->detach();
        if (count($store)) {
            $news->stories()->attach($store);
        }
//
        return redirect()->route('admin_news.index')->with('success', trans('news.admin.edit_success'));

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
            ShopNews::destroy($arrID);
            return response()->json(['error' => 0, 'msg' => '']);
        }
    }

}
