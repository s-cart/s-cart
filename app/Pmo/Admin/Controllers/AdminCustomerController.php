<?php
namespace App\Pmo\Admin\Controllers;

use App\Pmo\Admin\Controllers\RootAdminController;
use App\Pmo\Front\Models\ShopCountry;
use App\Pmo\Front\Models\ShopLanguage;
use App\Pmo\Admin\Models\AdminCustomer;
use App\Pmo\Front\Models\ShopCustomField;
use App\Pmo\Front\Models\ShopCustomFieldDetail;
use App\Pmo\Front\Controllers\Auth\AuthTrait;
use Validator;

class AdminCustomerController extends RootAdminController
{
    use AuthTrait;
    public $languages;
    public $countries;

    public function __construct()
    {
        parent::__construct();
        $this->languages = ShopLanguage::getListActive();
        $this->countries = ShopCountry::getListAll();
    }

    public function index()
    {
        $data = [
            'title'         => sc_language_render('customer.admin.list'),
            'subTitle'      => '',
            'icon'          => 'fa fa-indent',
            'urlDeleteItem' => sc_route_admin('admin_customer.delete'),
            'removeList'    => 1, // 1 - Enable function delete list item
            'buttonRefresh' => 0, // 1 - Enable button refresh
            'buttonSort'    => 1, // 1 - Enable button sort
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
            'email'      => sc_language_render('customer.email'),
            'name'       => sc_language_render('customer.name'),
            'phone'      => sc_language_render('customer.phone'),
            'address1'   => sc_language_render('customer.address1'),
            'address2'   => sc_language_render('customer.address2'),
            'address3'   => sc_language_render('customer.address3'),
            'country'    => sc_language_render('customer.country'),
            'status'     => sc_language_render('customer.status'),
            'created_at' => sc_language_render('admin.created_at'),
            'action'     => sc_language_render('action.title'),
        ];
        $sort_order = sc_clean(request('sort_order') ?? 'id_desc');
        $keyword    = sc_clean(request('keyword') ?? '');
        $arrSort = [
            'id__desc' => sc_language_render('filter_sort.id_desc'),
            'id__asc' => sc_language_render('filter_sort.id_asc'),
            'first_name__desc' => sc_language_render('filter_sort.first_name_desc'),
            'first_name__asc' => sc_language_render('filter_sort.first_name_asc'),
            'last_name__desc' => sc_language_render('filter_sort.last_name_desc'),
            'last_name__asc' => sc_language_render('filter_sort.last_name_asc'),
        ];

        $dataSearch = [
            'keyword'    => $keyword,
            'sort_order' => $sort_order,
            'arrSort'    => $arrSort,
        ];
        $dataTmp = (new AdminCustomer)->getCustomerListAdmin($dataSearch);


        $dataTr = [];
        foreach ($dataTmp as $key => $row) {
            $dataTr[$row['id']] = [
                'email' => $row['email'],
                'name' => $row['name'],
                'phone' => $row['phone'],
                'address1' => $row['address1'],
                'address2' => $row['address2'],
                'address3' => $row['address3'],
                'country' => $this->countries[$row['country']]->name ?? '',
                'status' => $row['status'] ? '<span class="badge badge-success">ON</span>' : '<span class="badge badge-danger">OFF</span>',
                'created_at' => $row['created_at'],
                'action' => '
                    <a href="' . sc_route_admin('admin_customer.edit', ['id' => $row['id'] ? $row['id'] : 'not-found-id']) . '"><span title="' . sc_language_render('action.edit') . '" type="button" class="btn btn-flat btn-sm btn-primary"><i class="fa fa-edit"></i></span></a>&nbsp;

                    <span onclick="deleteItem(\'' . $row['id'] . '\');"  title="' . sc_language_render('action.delete') . '" class="btn btn-flat btn-sm btn-danger"><i class="fas fa-trash-alt"></i></span>'
                ,
            ];
        }

        $data['listTh'] = $listTh;
        $data['dataTr'] = $dataTr;
        $data['pagination'] = $dataTmp->appends(request()->except(['_token', '_pjax']))->links($this->templatePathAdmin.'component.pagination');
        $data['resultItems'] = sc_language_render('admin.result_item', ['item_from' => $dataTmp->firstItem(), 'item_to' => $dataTmp->lastItem(), 'total' =>  $dataTmp->total()]);

        //menuRight
        $data['menuRight'][] = '<a href="' . sc_route_admin('admin_customer.create') . '" class="btn  btn-success  btn-flat" title="New" id="button_create_new">
                           <i class="fa fa-plus" title="'.sc_language_render('admin.add_new').'"></i>
                           </a>';
        //=menuRight

        //menuSort
        $optionSort = '';
        foreach ($arrSort as $key => $status) {
            $optionSort .= '<option  ' . (($sort_order == $key) ? "selected" : "") . ' value="' . $key . '">' . $status . '</option>';
        }
        $data['urlSort'] = sc_route_admin('admin_customer.index', request()->except(['_token', '_pjax', 'sort_order']));
        $data['optionSort'] = $optionSort;
        //=menuSort

        //menuSearch
        $data['topMenuRight'][] = '
                <form action="' . sc_route_admin('admin_customer.index') . '" id="button_search">
                <div class="input-group input-group" style="width: 350px;">
                    <input type="text" name="keyword" class="form-control rounded-0 float-right" placeholder="' . sc_language_render('search.placeholder') . '" value="' . $keyword . '">
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
     * Form create new item in admin
     * @return [type] [description]
     */
    public function create()
    {
        $data = [
            'title'             => sc_language_render('customer.admin.add_new_title'),
            'subTitle'          => '',
            'title_description' => sc_language_render('customer.admin.add_new_des'),
            'icon'              => 'fa fa-plus',
            'countries'         => (new ShopCountry)->getCodeAll(),
            'customer'          => [],
            'url_action'        => sc_route_admin('admin_customer.create'),
            'customFields'         => (new ShopCustomField)->getCustomField($type = 'shop_customer'),

        ];

        return view($this->templatePathAdmin.'screen.customer_add')
            ->with($data);
    }

    /**
     * Post create new item in admin
     * @return [type] [description]
     */
    public function postCreate()
    {
        $data = request()->all();
        $data['status'] = empty($data['status']) ? 0 : 1;
        $data['store_id'] = session('adminStoreId');
        $dataMapping = $this->mappingValidator($data);
        $validator =  Validator::make($data, $dataMapping['validate'], $dataMapping['messages']);
        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        $data = request()->all();
        $data['status'] = empty($data['status']) ? 0 : 1;
        $data['store_id'] = session('adminStoreId');

        $customer = AdminCustomer::createCustomer($dataMapping['dataInsert']);

        if ($customer) {
            sc_customer_created_by_admin($customer, $dataMapping['dataInsert']);
        }

        return redirect()->route('admin_customer.index')->with('success', sc_language_render('action.create_success'));
    }

    /**
     * Form edit
     */
    public function edit($id)
    {
        $customer = (new AdminCustomer)->getCustomerAdmin($id);
        if (!$customer) {
            return redirect()->route('admin.data_not_found')->with(['url' => url()->full()]);
        }
        $data = [
            'title' => sc_language_render('action.edit'),
            'subTitle' => '',
            'title_description' => '',
            'icon' => 'fa fa-edit',
            'customer' => $customer,
            'countries' => (new ShopCountry)->getCodeAll(),
            'addresses' => $customer->addresses,
            'url_action' => sc_route_admin('admin_customer.edit', ['id' => $customer['id']]),
            'customFields'         => (new ShopCustomField)->getCustomField($type = 'shop_customer'),
        ];
        return view($this->templatePathAdmin.'screen.customer_edit')
            ->with($data);
    }

    /**
     * update status
     */
    public function postEdit($id)
    {
        $data = request()->all();
        $customer = (new AdminCustomer)->getCustomerAdmin($id);
        if (!$customer) {
            return redirect()->route('admin.data_not_found')->with(['url' => url()->full()]);
        }

        $data['status'] = empty($data['status']) ? 0 : 1;
        $data['store_id'] = session('adminStoreId');
        $data['id'] = $id;
        $dataMapping = $this->mappingValidatorEdit($data);

        $validator =  Validator::make($data, $dataMapping['validate'], $dataMapping['messages']);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        AdminCustomer::updateInfo($dataMapping['dataUpdate'], $id);

        return redirect()->route('admin_customer.index')->with('success', sc_language_render('action.edit_success'));
    }

    /*
    Delete list Item
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
            AdminCustomer::destroy($arrID);
            return response()->json(['error' => 0, 'msg' => '']);
        }
    }


    /**
     * Render address detail
     * @return [view]
     */
    public function updateAddress($id)
    {
        $address =  AdminCustomer::getAddress($id);
        if ($address) {
            $title = sc_language_render('customer.address_detail').' #'.$address->id;
        } else {
            $title = sc_language_render('customer.address_detail_notfound');
        }
        return view($this->templatePathAdmin.'screen.customer_update_address')
        ->with(
            [
            'title'       => $title,
            'address'     => $address,
            'customer'    => (new AdminCustomer)->getCustomerAdmin($address->customer_id),
            'countries'   => ShopCountry::getCodeAll(),
            'layout_page' => 'shop_profile',
            'url_action'  => sc_route_admin('admin_customer.update_address', ['id' => $id]),
            ]
        );
    }

    /**
     * Process update address
     *
     *
     * @return  [redirect]
     */
    public function postUpdateAddress($id)
    {
        $data = request()->all();
        $address =  AdminCustomer::getAddress($id);
        $dataUpdate = [
            'first_name' => $data['first_name'],
            'address1' => $data['address1'],
        ];
        $validate = [
            'first_name' => 'required|string|max:100',
        ];
        
        if (sc_config_admin('customer_lastname')) {
            if (sc_config_admin('customer_lastname_required')) {
                $validate['last_name'] = 'required|string|max:100';
            } else {
                $validate['last_name'] = 'nullable|string|max:100';
            }
            $dataUpdate['last_name'] = $data['last_name']??'';
        }

        if (sc_config_admin('customer_address1')) {
            if (sc_config_admin('customer_address1_required')) {
                $validate['address1'] = 'required|string|max:100';
            } else {
                $validate['address1'] = 'nullable|string|max:100';
            }
            $dataUpdate['address1'] = $data['address1']??'';
        }

        if (sc_config_admin('customer_address2')) {
            if (sc_config_admin('customer_address2_required')) {
                $validate['address2'] = 'required|string|max:100';
            } else {
                $validate['address2'] = 'nullable|string|max:100';
            }
            $dataUpdate['address2'] = $data['address2']??'';
        }

        if (sc_config_admin('customer_address3')) {
            if (sc_config_admin('customer_address3_required')) {
                $validate['address3'] = 'required|string|max:100';
            } else {
                $validate['address3'] = 'nullable|string|max:100';
            }
            $dataUpdate['address3'] = $data['address3']??'';
        }

        if (sc_config_admin('customer_phone')) {
            if (sc_config_admin('customer_phone_required')) {
                $validate['phone'] = config('validation.customer.phone_required', 'required|regex:/^0[^0][0-9\-]{6,12}$/');
            } else {
                $validate['phone'] = config('validation.customer.phone_null', 'nullable|regex:/^0[^0][0-9\-]{6,12}$/');
            }
            $dataUpdate['phone'] = $data['phone']??'';
        }

        if (sc_config_admin('customer_country')) {
            $arraycountry = (new ShopCountry)->pluck('code')->toArray();
            if (sc_config_admin('customer_country_required')) {
                $validate['country'] = 'required|string|min:2|in:'. implode(',', $arraycountry);
            } else {
                $validate['country'] = 'nullable|string|min:2|in:'. implode(',', $arraycountry);
            }
            
            $dataUpdate['country'] = $data['country']??'';
        }

        if (sc_config_admin('customer_postcode')) {
            if (sc_config_admin('customer_postcode_required')) {
                $validate['postcode'] = 'required|min:5';
            } else {
                $validate['postcode'] = 'nullable|min:5';
            }
            $dataUpdate['postcode'] = $data['postcode']??'';
        }

        if (sc_config_admin('customer_name_kana')) {
            if (sc_config_admin('customer_name_kana_required')) {
                $validate['first_name_kana'] = 'required|string|max:100';
                $validate['last_name_kana'] = 'required|string|max:100';
            } else {
                $validate['first_name_kana'] = 'nullable|string|max:100';
                $validate['last_name_kana'] = 'nullable|string|max:100';
            }
            $dataUpdate['first_name_kana'] = $data['first_name_kana']?? '';
            $dataUpdate['last_name_kana'] = $data['last_name_kana']?? '';
        }

        $messages = [
            'last_name.required'  => sc_language_render('validation.required', ['attribute'=> sc_language_render('customer.last_name')]),
            'first_name.required' => sc_language_render('validation.required', ['attribute'=> sc_language_render('customer.first_name')]),
            'address1.required'   => sc_language_render('validation.required', ['attribute'=> sc_language_render('customer.address1')]),
            'address2.required'   => sc_language_render('validation.required', ['attribute'=> sc_language_render('customer.address2')]),
            'address3.required'   => sc_language_render('validation.required', ['attribute'=> sc_language_render('customer.address3')]),
            'phone.required'      => sc_language_render('validation.required', ['attribute'=> sc_language_render('customer.phone')]),
            'country.required'    => sc_language_render('validation.required', ['attribute'=> sc_language_render('customer.country')]),
            'postcode.required'   => sc_language_render('validation.required', ['attribute'=> sc_language_render('customer.postcode')]),
            'phone.regex'         => sc_language_render('customer.phone_regex'),
            'postcode.min'        => sc_language_render('validation.min', ['attribute'=> sc_language_render('customer.postcode')]),
            'country.min'         => sc_language_render('validation.min', ['attribute'=> sc_language_render('customer.country')]),
            'first_name.max'      => sc_language_render('validation.max', ['attribute'=> sc_language_render('customer.first_name')]),
            'address1.max'        => sc_language_render('validation.max', ['attribute'=> sc_language_render('customer.address1')]),
            'address2.max'        => sc_language_render('validation.max', ['attribute'=> sc_language_render('customer.address2')]),
            'address3.max'        => sc_language_render('validation.max', ['attribute'=> sc_language_render('customer.address3')]),
            'last_name.max'       => sc_language_render('validation.max', ['attribute'=> sc_language_render('customer.last_name')]),
        ];

        $v = Validator::make(
            $dataUpdate,
            $validate,
            $messages
        );
        if ($v->fails()) {
            return redirect()->back()->withErrors($v->errors());
        }

        $address->update(sc_clean($dataUpdate));

        if (!empty($data['default'])) {
            $customer = (new AdminCustomer)->getCustomerAdmin($address->customer_id);
            $customer->address_id = $id;
            $customer->save();
        }
        return redirect()->route('admin_customer.edit', ['id' => $address->customer_id])
            ->with(['success' => sc_language_render('customer.update_success')]);
    }

    /**
     * Get address detail
     *
     * @return  [json]
     */
    public function deleteAddress()
    {
        $id = request('id');
        AdminCustomer::deleteAddress($id);
        return json_encode(['error' => 0, 'msg' => sc_language_render('customer.delete_address_success')]);
    }

    /**
     * Check permisison item
     */
    public function checkPermisisonItem($id)
    {
        return (new AdminCustomer)->getCustomerAdmin($id);
    }
}
