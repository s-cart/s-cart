<?php
namespace App\Plugins\Cms\Content\Admin;

use SCart\Core\Admin\Controllers\RootAdminController;
use SCart\Core\Front\Models\ShopLanguage;
use App\Plugins\Cms\Content\Admin\Models\AdminCmsCategory;
use App\Plugins\Cms\Content\Admin\Models\AdminCmsContent;
use App\Plugins\Cms\Content\AppConfig;
use Validator;

class CmsContentController extends RootAdminController
{
    public $languages;
    public $plugin;

    public function __construct()
    {
        parent::__construct();
        $this->languages = ShopLanguage::getListActive();
        $this->plugin = new AppConfig;
    }

    public function index()
    {
        $categoriesTitle =  AdminCmsCategory::getListTitleAdmin();
        $data = [
            'title'         => sc_language_render($this->plugin->pathPlugin.'::Content.admin.list'),
            'subTitle'      => '',
            'icon'          => 'fa fa-indent',
            'menuRight'     => [],
            'menuLeft'      => [],
            'topMenuRight'  => [],
            'topMenuLeft'   => [],
            'urlDeleteItem' => sc_route_admin('admin_cms_content.delete'),
            'removeList'    => 1, // 1 - Enable function delete list item
            'buttonRefresh' => 1, // 1 - Enable button refresh
            'css'           => '', 
            'js'            => '',
        ];

        $listTh = [
            'image'       => sc_language_render($this->plugin->pathPlugin.'::Content.image'),
            'title'       => sc_language_render($this->plugin->pathPlugin.'::Content.title'),
            'category_id' => sc_language_render($this->plugin->pathPlugin.'::Content.category_id'),
            'status'      => sc_language_render($this->plugin->pathPlugin.'::Content.status'),
            'sort'        => sc_language_render($this->plugin->pathPlugin.'::Content.sort'),
            'action'      => sc_language_render($this->plugin->pathPlugin.'::Content.admin.action'),
        ];
        $sort_order = sc_clean(request('sort_order') ?? 'id_desc');
        $keyword    = sc_clean(request('keyword') ?? '');
        $arrSort = [
            'id__desc'    => sc_language_render($this->plugin->pathPlugin.'::Content.admin.sort_order.id_desc'),
            'id__asc'     => sc_language_render($this->plugin->pathPlugin.'::Content.admin.sort_order.id_asc'),
            'title__desc' => sc_language_render($this->plugin->pathPlugin.'::Content.admin.sort_order.title_desc'),
            'title__asc'  => sc_language_render($this->plugin->pathPlugin.'::Content.admin.sort_order.title_asc'),
        ];

        $dataSearch = [
            'keyword'    => $keyword,
            'sort_order' => $sort_order,
            'arrSort'    => $arrSort,
        ];
        $dataTmp = (new AdminCmsContent)->getContentListAdmin($dataSearch);

        $dataTr = [];
        foreach ($dataTmp as $key => $row) {
            $dataTr[$row['id']] = [
                'image' => sc_image_render($row->getThumb(), '50px', '50px', $row['title']),
                'title' => $row['title'],
                'category_id' => $row['category_id'] ? $categoriesTitle[$row['category_id']] ?? '' : 'ROOT',

                'status' => $row['status'] ? '<span class="badge badge-success">ON</span>' : '<span class="badge badge-danger">OFF</span>',
                'sort' => $row['sort'],
                'action' => '
                    <a href="' . sc_route_admin('admin_cms_content.edit', ['id' => $row['id'] ? $row['id'] : 'not-found-id']) . '"><span title="' . sc_language_render($this->plugin->pathPlugin.'::Content.admin.edit') . '" type="button" class="btn btn-flat btn-sm btn-primary"><i class="fa fa-edit"></i></span></a>&nbsp;

                    <span onclick="deleteItem(\'' . $row['id'] . '\');"  title="' . sc_language_render('admin.delete') . '" class="btn btn-flat btn-sm btn-danger"><i class="fa fa-trash"></i></span>
                    <a target=_new href="' . sc_route('cms.content', ['category' => $row->category->alias ?? 'null', 'alias' => $row['alias']]) . '"><span title="Link" type="button" class="btn btn-flat btn-sm btn-warning"><i class="fas fa-external-link-alt"></i></a>'
                ,
            ];
        }

        $data['listTh'] = $listTh;
        $data['dataTr'] = $dataTr;
        $data['pagination'] = $dataTmp
            ->appends(request()->except(['_token', '_pjax']))
            ->links($this->templatePathAdmin.'component.pagination');
        $data['resultItems'] = sc_language_render($this->plugin->pathPlugin.'::Content.admin.result_item', 
            [
                'item_from' => $dataTmp->firstItem(), 
                'item_to' => $dataTmp->lastItem(), 
                'total' =>  $dataTmp->total()
            ]
        );

        //menuRight
        $data['menuRight'][] = '<a href="' . sc_route_admin('admin_cms_content.create') . '" class="btn  btn-success  btn-flat" title="New" id="button_create_new">
                           <i class="fa fa-plus"></i><span class="hidden-xs">' . sc_language_render('admin.add_new') . '</span>
                           </a>';
        //=menuRight

        //menu_sort
        $optionSort = '';
        foreach ($arrSort as $key => $status) {
            $optionSort .= '<option  ' . (($sort_order == $key) ? "selected" : "") . ' value="' . $key . '">' . $status . '</option>';
        }
        //=menu_sort

        //menuSearch
        $data['topMenuRight'][] = '
            <form action="' . sc_route_admin('admin_cms_content.index') . '" id="button_search">
            <div class="input-group input-group" style="width: 230px;">
            <select class="form-control rounded-0 select2" name="sort_order" id="sort_order">
            '.$optionSort.'
            </select> &nbsp;
                <input type="text" name="keyword" class="form-control float-right" placeholder="' . sc_language_render($this->plugin->pathPlugin.'::Content.admin.search_place') . '" value="' . $keyword . '">
                <div class="input-group-append">
                    <button type="submit" class="btn btn-primary"><i class="fas fa-search"></i></button>
                </div>
            </div>
            </form>';
        //=menuSearch

        return view($this->templatePathAdmin.'screen.list')
            ->with($data);
    }

    /**
     * Form create new order in admin
     * @return [type] [description]
     */
    public function create()
    {
        $data = [
            'title' => sc_language_render($this->plugin->pathPlugin.'::Content.admin.add_new_title'),
            'subTitle' => '',
            'title_description' => sc_language_render($this->plugin->pathPlugin.'::Content.admin.add_new_des'),
            'icon' => 'fa fa-plus',
            'languages' => $this->languages,
            'content' => [],
            'categories' => (new AdminCmsCategory)->getTreeCategoriesAdmin(),
            'url_action' => sc_route_admin('admin_cms_content.create'),
        ];
        return view($this->plugin->pathPlugin.'::Admin.cms_content')
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
            'sort' => 'numeric|min:0',
            'category_id' => 'required',
            'descriptions.*.title' => 'required|string|max:200',
            'descriptions.*.keyword' => 'nullable|string|max:200',
            'descriptions.*.description' => 'nullable|string|max:500',
            'alias' => 'required|regex:/(^([0-9A-Za-z\-_]+)$)/|string|max:100|cms_content_alias_unique',
        ], [
            'descriptions.*.title.required' => sc_language_render('validation.required', 
            ['attribute' => sc_language_render($this->plugin->pathPlugin.'::Content.title')]),
            'alias.regex' => sc_language_render($this->plugin->pathPlugin.'::Content.alias_validate'),
            'alias.cms_content_alias_unique' => sc_language_render($this->plugin->pathPlugin.'::Content.alias_unique'),
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput($data);
        }
        $dataInsert = [
            'image'       => $data['image'],
            'alias'       => $data['alias'],
            'category_id' => (int) $data['category_id'],
            'status'      => !empty($data['status']) ? 1 : 0,
            'sort'        => (int) $data['sort'],
            'store_id'    => session('adminStoreId'),
        ];
        $dataInsert = sc_clean($dataInsert, [], true);
        $content = AdminCmsContent::createContentAdmin($dataInsert);
        $id = $content->id;
        $dataDes = [];
        $languages = $this->languages;
        foreach ($languages as $code => $value) {
            $dataDes[] = [
                'content_id' => $id,
                'lang' => $code,
                'title' => $data['descriptions'][$code]['title'],
                'keyword' => $data['descriptions'][$code]['keyword'],
                'description' => $data['descriptions'][$code]['description'],
                'content' => $data['descriptions'][$code]['content'],
            ];
        }
        $dataDes = sc_clean($dataDes, ['content'], true);
        AdminCmsContent::insertDescriptionAdmin($dataDes);
        sc_clear_cache('cache_cms_content');
        return redirect()->route('admin_cms_content.index')
            ->with('success', sc_language_render($this->plugin->pathPlugin.'::Content.admin.create_success'));

    }

/**
 * Form edit
 */
    public function edit($id)
    {
        $content = AdminCmsContent::getContentAdmin($id);

        if (!$content) {
            return redirect()->route('admin.data_not_found')->with(['url' => url()->full()]);
        }
        $data = [
            'title' => sc_language_render($this->plugin->pathPlugin.'::Content.admin.edit'),
            'subTitle' => '',
            'title_description' => '',
            'icon' => 'fa fa-pencil-square-o',
            'languages' => $this->languages,
            'content' => $content,
            'categories' => (new AdminCmsCategory)->getTreeCategoriesAdmin(),
            'url_action' => sc_route_admin('admin_cms_content.edit', ['id' => $content['id']]),

        ];
        return view($this->plugin->pathPlugin.'::Admin.cms_content')
            ->with($data);
    }

/**
 * update status
 */
    public function postEdit($id)
    {
        $content = AdminCmsContent::getContentAdmin($id);

        if (!$content) {
            return redirect()->route('admin.data_not_found')->with(['url' => url()->full()]);
        }

        $data = request()->all();
        
        $langFirst = array_key_first(sc_language_all()->toArray()); //get first code language active
        $data['alias'] = !empty($data['alias'])?$data['alias']:$data['descriptions'][$langFirst]['title'];
        $data['alias'] = sc_word_format_url($data['alias']);
        $data['alias'] = sc_word_limit($data['alias'], 100);

        $validator = Validator::make($data, [
            'category_id' => 'required',
            'alias' => 'required|regex:/(^([0-9A-Za-z\-_]+)$)/|string|max:100|cms_content_alias_unique:'.$id,
            'sort' => 'numeric|min:0',
            'descriptions.*.title' => 'required|string|max:200',
            'descriptions.*.keyword' => 'nullable|string|max:200',
            'descriptions.*.description' => 'nullable|string|max:500',
        ], [
            'alias.regex' => sc_language_render($this->plugin->pathPlugin.'::Content.alias_validate'),
            'descriptions.*.title.required' => sc_language_render('validation.required', ['attribute' => sc_language_render($this->plugin->pathPlugin.'::Content.title')]),
            'alias.cms_content_alias_unique' => sc_language_render($this->plugin->pathPlugin.'::Content.alias_unique'),
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput($data);
        }
        //Edit
        $dataUpdate = [
            'image'       => $data['image'],
            'alias'       => $data['alias'],
            'category_id' => $data['category_id'],
            'sort'        => $data['sort'],
            'status'      => empty($data['status']) ? 0 : 1,
            'store_id'    => session('adminStoreId'),
        ];
        $dataUpdate = sc_clean($dataUpdate, [], true);
        $content->update($dataUpdate);
        $content->descriptions()->delete();
        $dataDes = [];
        foreach ($data['descriptions'] as $code => $row) {
            $dataDes[] = [
                'content_id'  => $id,
                'lang'        => $code,
                'title'       => $row['title'],
                'keyword'     => $row['keyword'],
                'description' => $row['description'],
                'content'     => $row['content'],
            ];
        }
        $dataDes = sc_clean($dataDes, ['content'], true);
        AdminCmsContent::insertDescriptionAdmin($dataDes);
        sc_clear_cache('cache_cms_content');
        return redirect()->route('admin_cms_content.index')->with('success', sc_language_render($this->plugin->pathPlugin.'::Content.admin.edit_success'));

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
            $arrDontPermission = [];
            foreach ($arrID as $key => $id) {
                if(!$this->checkPermisisonItem($id)) {
                    $arrDontPermission[] = $id;
                }
            }
            if (count($arrDontPermission)) {
                return response()->json(['error' => 1, 'msg' => sc_language_render('admin.remove_dont_permisison') . ': ' . json_encode($arrDontPermission)]);
            }
            AdminCmsContent::destroy($arrID);
            sc_clear_cache('cache_cms_content');
            return response()->json(['error' => 0, 'msg' => '']);
        }
    }

    /**
     * Check permisison item
     */
    public function checkPermisisonItem($id) {
        return AdminCmsContent::getContentAdmin($id);
    }

}
