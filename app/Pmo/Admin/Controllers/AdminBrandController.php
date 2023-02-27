<?php
namespace App\Pmo\Admin\Controllers;

use App\Pmo\Admin\Controllers\RootAdminController;
use App\Pmo\Front\Models\ShopBrand;
use App\Pmo\Front\Models\ShopCustomField;
use Validator;

class AdminBrandController extends RootAdminController
{
    public function __construct()
    {
        parent::__construct();
    }
    public function index()
    {
        $data = [
            'title' => sc_language_render('admin.brand.list'),
            'title_action' => '<i class="fa fa-plus" aria-hidden="true"></i> ' . sc_language_render('admin.brand.add_new_title'),
            'subTitle' => '',
            'icon' => 'fa fa-indent',
            'urlDeleteItem' => sc_route_admin('admin_brand.delete'),
            'removeList' => 0, // 1 - Enable function delete list item
            'buttonRefresh' => 0, // 1 - Enable button refresh
            'buttonSort' => 0, // 1 - Enable button sort
            'css' => '',
            'js' => '',
            'url_action' => sc_route_admin('admin_brand.create'),
            'customFields'      => (new ShopCustomField)->getCustomField($type = 'shop_brand'),
        ];

        $listTh = [
            'name' => sc_language_render('admin.brand.name'),
            'image' => sc_language_render('admin.brand.image'),
            'status' => sc_language_render('admin.brand.status'),
        ];

        if (sc_check_multi_shop_installed() && session('adminStoreId') == SC_ID_ROOT) {
            // Only show store info if store is root
            $listTh['shop_store'] = sc_language_render('front.store_list');
        }
        $listTh['action'] = sc_language_render('action.title');

        $obj = new ShopBrand;
        $obj = $obj->orderBy('id', 'desc');
        $dataTmp = $obj->paginate(20);

        if (sc_check_multi_shop_installed() && session('adminStoreId') == SC_ID_ROOT) {
            $arrId = $dataTmp->pluck('id')->toArray();
            // Only show store info if store is root
            if (function_exists('sc_get_list_store_of_brand')) {
                $dataStores = sc_get_list_store_of_brand($arrId);
            } else {
                $dataStores = [];
            }
        }

        $dataTr = [];
        foreach ($dataTmp as $key => $row) {
            $dataMap = [
                'name' => $row['name'],
                'image' => sc_image_render($row->getThumb(), '50px', '', $row['name']),
                'status' => $row['status'] ? '<span class="badge badge-success">ON</span>' : '<span class="badge badge-danger">OFF</span>',
            ];
            if (sc_check_multi_shop_installed() && session('adminStoreId') == SC_ID_ROOT) {
                // Only show store info if store is root
                if (!empty($dataStores[$row['id']])) {
                    $storeTmp = $dataStores[$row['id']]->pluck('code', 'id')->toArray();
                    $storeTmp = array_map(function ($code) {
                        return '<a target=_new href="'.sc_get_domain_from_code($code).'">'.$code.'</a>';
                    }, $storeTmp);
                    $dataMap['shop_store'] = '<i class="nav-icon fab fa-shopify"></i> '.implode('<br><i class="nav-icon fab fa-shopify"></i> ', $storeTmp);
                } else {
                    $dataMap['shop_store'] = '';
                }
            }
            $dataMap['action'] = '<a href="' . sc_route_admin('admin_brand.edit', ['id' => $row['id'] ? $row['id'] : 'not-found-id']) . '"><span title="' . sc_language_render('action.edit') . '" type="button" class="btn btn-flat btn-sm btn-primary"><i class="fa fa-edit"></i></span></a>&nbsp;
                                <span onclick="deleteItem(\'' . $row['id'] . '\');"  title="' . sc_language_render('action.delete') . '" class="btn btn-flat btn-sm btn-danger"><i class="fas fa-trash-alt"></i></span>
                                ';
            $dataTr[$row['id']] = $dataMap;
        }



        $data['listTh'] = $listTh;
        $data['dataTr'] = $dataTr;
        $data['pagination'] = $dataTmp->appends(request()->except(['_token', '_pjax']))->links($this->templatePathAdmin.'component.pagination');
        $data['resultItems'] = sc_language_render('admin.result_item', ['item_from' => $dataTmp->firstItem(), 'item_to' => $dataTmp->lastItem(), 'total' =>  $dataTmp->total()]);

        $data['layout'] = 'index';
        return view($this->templatePathAdmin.'screen.brand')
            ->with($data);
    }


    /**
     * Post create new item in admin
     * @return [type] [description]
     */
    public function postCreate()
    {
        $data = request()->all();

        $data['alias'] = !empty($data['alias'])?$data['alias']:$data['name'];
        $data['alias'] = sc_word_format_url($data['alias']);
        $data['alias'] = sc_word_limit($data['alias'], 100);
        $arrValidation = [
            'name'  => 'required|string|max:100',
            'alias' => 'required|regex:/(^([0-9A-Za-z\-_]+)$)/|unique:"'.ShopBrand::class.'",alias|string|max:100',
            'image' => 'required',
            'sort'  => 'numeric|min:0',
            'url'   => 'url|nullable',
        ];
        //Custom fields
        $customFields = (new ShopCustomField)->getCustomField($type = 'shop_brand');
        if ($customFields) {
            foreach ($customFields as $field) {
                if ($field->required) {
                    $arrValidation['fields.'.$field->code] = 'required';
                }
            }
        }

        $validator = Validator::make($data, $arrValidation, [
            'name.required' => sc_language_render('validation.required', ['attribute' => sc_language_render('admin.brand.name')]),
            'alias.regex' => sc_language_render('admin.brand.alias_validate'),
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput($data);
        }
        $dataCreate = [
            'image' => $data['image'],
            'name' => $data['name'],
            'alias' => $data['alias'],
            'url' => $data['url'],
            'sort' => (int) $data['sort'],
            'status' => (!empty($data['status']) ? 1 : 0),
        ];
        $dataCreate = sc_clean($dataCreate, [], true);
        $brand = ShopBrand::create($dataCreate);

        $shopStore        = $data['shop_store'] ?? [session('adminStoreId')];
        $brand->stores()->detach();
        if ($shopStore) {
            $brand->stores()->attach($shopStore);
        }

        //Insert custom fields
        $fields = $data['fields'] ?? null;
        sc_update_custom_field($fields, $brand->id, 'shop_brand');

        return redirect()->route('admin_brand.index')->with('success', sc_language_render('action.create_success'));
    }

    /**
     * Form edit
     */
    public function edit($id)
    {
        $brand = ShopBrand::find($id);
        if (!$brand) {
            return 'No data';
        }
        $data = [
        'title' => sc_language_render('admin.brand.list'),
        'title_action' => '<i class="fa fa-edit" aria-hidden="true"></i> ' . sc_language_render('action.edit'),
        'subTitle' => '',
        'icon' => 'fa fa-indent',
        'urlDeleteItem' => sc_route_admin('admin_brand.delete'),
        'removeList' => 0, // 1 - Enable function delete list item
        'buttonRefresh' => 0, // 1 - Enable button refresh
        'buttonSort' => 0, // 1 - Enable button sort
        'css' => '',
        'js' => '',
        'url_action' => sc_route_admin('admin_brand.edit', ['id' => $brand['id']]),
        'brand' => $brand,
        'id' => $id,
        'customFields'      => (new ShopCustomField)->getCustomField($type = 'shop_brand'),
    ];

        $listTh = [
        'name' => sc_language_render('admin.brand.name'),
        'image' => sc_language_render('admin.brand.image'),
        'sort' => sc_language_render('admin.brand.sort'),
        'status' => sc_language_render('admin.brand.status'),
        'action' => sc_language_render('action.title'),
    ];
        $obj = new ShopBrand;
        $obj = $obj->orderBy('id', 'desc');
        $dataTmp = $obj->paginate(20);

        $dataTr = [];
        foreach ($dataTmp as $key => $row) {
            $dataTr[$row['id']] = [
            'name' => $row['name'],
            'image' => sc_image_render($row->getThumb(), '50px', '', $row['name']),
            'sort' => $row['sort'],
            'status' => $row['status'] ? '<span class="badge badge-success">ON</span>' : '<span class="badge badge-danger">OFF</span>',
            'action' => '
                <a href="' . sc_route_admin('admin_brand.edit', ['id' => $row['id'] ? $row['id'] : 'not-found-id']) . '"><span title="' . sc_language_render('action.edit') . '" type="button" class="btn btn-flat btn-sm btn-primary"><i class="fa fa-edit"></i></span></a>&nbsp;

              <span onclick="deleteItem(\'' . $row['id'] . '\');"  title="' . sc_language_render('action.delete') . '" class="btn btn-flat btn-sm btn-danger"><i class="fas fa-trash-alt"></i></span>
              ',
        ];
        }

        $data['listTh'] = $listTh;
        $data['dataTr'] = $dataTr;
        $data['pagination'] = $dataTmp->appends(request()->except(['_token', '_pjax']))->links($this->templatePathAdmin.'component.pagination');
        $data['resultItems'] = sc_language_render('admin.result_item', ['item_from' => $dataTmp->firstItem(), 'item_to' => $dataTmp->lastItem(), 'total' =>  $dataTmp->total()]);

        $data['layout'] = 'edit';
        return view($this->templatePathAdmin.'screen.brand')
        ->with($data);
    }


    /**
     * update status
     */
    public function postEdit($id)
    {
        $brand = ShopBrand::find($id);
        $data = request()->all();
        $data['alias'] = !empty($data['alias'])?$data['alias']:$data['name'];
        $data['alias'] = sc_word_format_url($data['alias']);
        $data['alias'] = sc_word_limit($data['alias'], 100);
        $arrValidation = [
            'name'  => 'required|string|max:100',
            'alias' => 'required|regex:/(^([0-9A-Za-z\-_]+)$)/|unique:"'.ShopBrand::class.'",alias,' . $brand->id . ',id|string|max:100',
            'image' => 'required',
            'sort'  => 'numeric|min:0',
        ];
        //Custom fields
        $customFields = (new ShopCustomField)->getCustomField($type = 'shop_brand');
        if ($customFields) {
            foreach ($customFields as $field) {
                if ($field->required) {
                    $arrValidation['fields.'.$field->code] = 'required';
                }
            }
        }
        $validator = Validator::make($data, $arrValidation, [
            'name.required' => sc_language_render('validation.required', ['attribute' => sc_language_render('admin.brand.name')]),
            'alias.regex' => sc_language_render('admin.brand.alias_validate'),
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput($data);
        }
        //Edit

        $dataUpdate = [
            'image' => $data['image'],
            'name' => $data['name'],
            'alias' => $data['alias'],
            'url' => $data['url'],
            'sort' => (int) $data['sort'],
            'status' => (!empty($data['status']) ? 1 : 0),

        ];
        $dataUpdate = sc_clean($dataUpdate, [], true);
        $brand->update($dataUpdate);

        $shopStore        = $data['shop_store'] ?? [session('adminStoreId')];
        $brand->stores()->detach();
        if ($shopStore) {
            $brand->stores()->attach($shopStore);
        }

        //Insert custom fields
        $fields = $data['fields'] ?? null;
        sc_update_custom_field($fields, $brand->id, 'shop_brand');

        return redirect()->back()->with('success', sc_language_render('action.edit_success'));
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
            ShopBrand::destroy($arrID);
            return response()->json(['error' => 0, 'msg' => '']);
        }
    }
}
