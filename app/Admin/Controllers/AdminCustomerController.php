<?php
#app/Http/Admin/Controllers/AdminCustomerController.php
namespace App\Admin\Controllers;

use App\Http\Controllers\Controller;
use App\Models\ShopCountry;
use App\Models\ShopLanguage;
use App\Models\ShopUser;
use App\Models\ShopUserAddress;
use App\Http\Controllers\Auth\AuthTrait;
use Validator;

class AdminCustomerController extends Controller
{
    use AuthTrait;
    public $languages, $countries;

    public function __construct()
    {
        $this->languages = ShopLanguage::getListActive();
        $this->countries = ShopCountry::getListAll();

    }

    public function index()
    {
        $data = [
            'title' => trans('customer.admin.list'),
            'subTitle' => '',
            'icon' => 'fa fa-indent',
            'urlDeleteItem' => sc_route('admin_customer.delete'),
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

        $listTh = [
            'id' => trans('customer.id'),
            'email' => trans('customer.email'),
            'name' => trans('customer.name'),
            'phone' => trans('customer.phone'),
            'address1' => trans('customer.address1'),
            'address2' => trans('customer.address2'),
            'country' => trans('customer.country'),
            'status' => trans('customer.status'),
            'created_at' => trans('customer.created_at'),
            'action' => trans('customer.admin.action'),
        ];
        $sort_order = request('sort_order') ?? 'id_desc';
        $keyword = request('keyword') ?? '';
        $arrSort = [
            'id__desc' => trans('customer.admin.sort_order.id_desc'),
            'id__asc' => trans('customer.admin.sort_order.id_asc'),
            'first_name__desc' => trans('customer.admin.sort_order.first_name_desc'),
            'first_name__asc' => trans('customer.admin.sort_order.first_name_asc'),
            'last_name__desc' => trans('customer.admin.sort_order.last_name_desc'),
            'last_name__asc' => trans('customer.admin.sort_order.last_name_asc'),
        ];
        $obj = new ShopUser;

        if ($keyword) {
            $obj = $obj->whereRaw('(id = ' . (int) $keyword . ' OR email like "%' . $keyword . '%" OR first_name like "%' . $keyword . '%" OR last_name like "%' . $keyword . '%"  )');
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
                'email' => $row['email'],
                'name' => $row['name'],
                'phone' => $row['phone'],
                'address1' => $row['address1'],
                'address2' => $row['address2'],
                'country' => $this->countries[$row['country']]->name ?? '',
                'status' => $row['status'] ? '<span class="badge badge-success">ON</span>' : '<span class="badge badge-danger">OFF</span>',
                'created_at' => $row['created_at'],
                'action' => '
                    <a href="' . sc_route('admin_customer.edit', ['id' => $row['id']]) . '"><span title="' . trans('customer.admin.edit') . '" type="button" class="btn btn-flat btn-primary"><i class="fa fa-edit"></i></span></a>&nbsp;

                    <span onclick="deleteItem(' . $row['id'] . ');"  title="' . trans('admin.delete') . '" class="btn btn-flat btn-danger"><i class="fas fa-trash-alt"></i></span>'
                ,
            ];
        }

        $data['listTh'] = $listTh;
        $data['dataTr'] = $dataTr;
        $data['pagination'] = $dataTmp->appends(request()->except(['_token', '_pjax']))->links('admin.component.pagination');
        $data['resultItems'] = trans('customer.admin.result_item', ['item_from' => $dataTmp->firstItem(), 'item_to' => $dataTmp->lastItem(), 'item_total' => $dataTmp->total()]);

//menuRight
        $data['menuRight'][] = '<a href="' . sc_route('admin_customer.create') . '" class="btn  btn-success  btn-flat" title="New" id="button_create_new">
                           <i class="fa fa-plus" title="'.trans('admin.add_new').'"></i>
                           </a>';
//=menuRight

//menuSort        
        $optionSort = '';
        foreach ($arrSort as $key => $status) {
            $optionSort .= '<option  ' . (($sort_order == $key) ? "selected" : "") . ' value="' . $key . '">' . $status . '</option>';
        }
        $data['urlSort'] = sc_route('admin_customer.index');
        $data['optionSort'] = $optionSort;
//=menuSort

//menuSearch        
        $data['topMenuRight'][] = '
                <form action="' . sc_route('admin_customer.index') . '" id="button_search">
                <div class="input-group input-group" style="width: 250px;">
                    <input type="text" name="keyword" class="form-control float-right" placeholder="' . trans('customer.admin.search_place') . '" value="' . $keyword . '">
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
        $data = [
            'title' => trans('customer.admin.add_new_title'),
            'subTitle' => '',
            'title_description' => trans('customer.admin.add_new_des'),
            'icon' => 'fa fa-plus',
            'countries' => (new ShopCountry)->getCodeAll(),
            'customer' => [],
            'url_action' => sc_route('admin_customer.create'),

        ];

        return view('admin.screen.customer_add')
            ->with($data);
    }

/**
 * Post create new order in admin
 * @return [type] [description]
 */
    public function postCreate()
    {
        $data = request()->all();
        $data['status'] = empty($data['status']) ? 0 : 1;
        $dataMapping = $this->mappingValidator($data);
        $validator =  Validator::make($data, $dataMapping['validate'], $dataMapping['messages']);
        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }
        ShopUser::createCustomer($dataMapping['dataInsert']);

        return redirect()->route('admin_customer.index')->with('success', trans('customer.admin.create_success'));

    }

/**
 * Form edit
 */
    public function edit($id)
    {
        $customer = ShopUser::find($id);
        if ($customer === null) {
            return 'no data';
        }
        $data = [
            'title' => trans('customer.admin.edit'),
            'subTitle' => '',
            'title_description' => '',
            'icon' => 'fa fa-edit',
            'customer' => $customer,
            'countries' => (new ShopCountry)->getCodeAll(),
            'addresses' => $customer->addresses,
            'url_action' => sc_route('admin_customer.edit', ['id' => $customer['id']]),
        ];
        return view('admin.screen.customer_edit')
            ->with($data);
    }

    /**
     * update status
     */
    public function postEdit($id)
    {
        $data = request()->all();
        $data['status'] = empty($data['status']) ? 0 : 1;
        $data['id'] = $id;
        $dataMapping = $this->mappingValidatorEdit($data);

        $validator =  Validator::make($data, $dataMapping['validate'], $dataMapping['messages']);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }
        ShopUser::updateInfo($dataMapping['dataUpdate'], $id);
    //
        return redirect()->route('admin_customer.index')->with('success', trans('customer.admin.edit_success'));

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
            ShopUser::destroy($arrID);
            return response()->json(['error' => 0, 'msg' => '']);
        }
    }


    /**
     * Render address detail
     * @return [view]
     */
    public function updateAddress($id)
    {
        $address =  (new ShopUserAddress)
            ->where('id', $id)
            ->first();
        if ($address) {
            $title = trans('account.address_detail').' #'.$address->id;
        } else {
            $title = trans('account.address_detail_notfound');
        }
        return view('admin.screen.customer_update_address')
        ->with(
            [
            'title' => $title,
            'address' => $address,
            'customer' => ShopUser::find($address->user_id),
            'countries' => ShopCountry::getCodeAll(),
            'layout_page' => 'shop_profile',
            'url_action' => sc_route('admin_customer.update_address', ['id' => $id]),
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
        $address =  (new ShopUserAddress)
            ->where('id', $id)
            ->first();
        
        $dataUpdate = [
            'first_name' => $data['first_name'],
            'address1' => $data['address1'],
        ];
        $validate = [
            'first_name' => 'required|string|max:100',
        ];
        
        if (sc_config('customer_lastname')) {
            if (sc_config('customer_lastname_required')) {
                $validate['last_name'] = 'required|string|max:100';
            } else {
                $validate['last_name'] = 'nullable|string|max:100';
            }
            $dataUpdate['last_name'] = $data['last_name']??'';
        }

        if (sc_config('customer_address1')) {
            if (sc_config('customer_address1_required')) {
                $validate['address1'] = 'required|string|max:100';
            } else {
                $validate['address1'] = 'nullable|string|max:100';
            }
            $dataUpdate['address1'] = $data['address1']??'';
        }

        if (sc_config('customer_address2')) {
            if (sc_config('customer_address1_required')) {
                $validate['address2'] = 'required|string|max:100';
            } else {
                $validate['address2'] = 'nullable|string|max:100';
            }
            $dataUpdate['address2'] = $data['address2']??'';
        }

        if (sc_config('customer_phone')) {
            if (sc_config('customer_phone_required')) {
                $validate['phone'] = 'required|regex:/^0[^0][0-9\-]{7,13}$/';
            } else {
                $validate['phone'] = 'nullable|regex:/^0[^0][0-9\-]{7,13}$/';
            }
            $dataUpdate['phone'] = $data['phone']??'';
        }

        if (sc_config('customer_country')) {
            $arraycountry = (new ShopCountry)->pluck('code')->toArray();
            if (sc_config('customer_country_required')) {
                $validate['country'] = 'required|string|min:2|in:'. implode(',', $arraycountry);
            } else {
                $validate['country'] = 'nullable|string|min:2|in:'. implode(',', $arraycountry);
            }
            
            $dataUpdate['country'] = $data['country']??'';
        }

        if (sc_config('customer_postcode')) {
            if (sc_config('customer_postcode_required')) {
                $validate['postcode'] = 'required|min:5';
            } else {
                $validate['postcode'] = 'nullable|min:5';
            }
            $dataUpdate['postcode'] = $data['postcode']??'';
        }

        if (sc_config('customer_name_kana')) {
            if (sc_config('customer_name_kana_required')) {
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
            'last_name.required'  => trans('validation.required',['attribute'=> trans('account.last_name')]),
            'first_name.required' => trans('validation.required',['attribute'=> trans('account.first_name')]),
            'address1.required'   => trans('validation.required',['attribute'=> trans('account.address1')]),
            'address2.required'   => trans('validation.required',['attribute'=> trans('account.address2')]),
            'phone.required'      => trans('validation.required',['attribute'=> trans('account.phone')]),
            'country.required'    => trans('validation.required',['attribute'=> trans('account.country')]),
            'postcode.required'   => trans('validation.required',['attribute'=> trans('account.postcode')]),
            'phone.regex'         => trans('validation.regex',['attribute'=> trans('account.phone')]),
            'postcode.min'        => trans('validation.min',['attribute'=> trans('account.postcode')]),
            'country.min'         => trans('validation.min',['attribute'=> trans('account.country')]),
            'first_name.max'      => trans('validation.max',['attribute'=> trans('account.first_name')]),
            'address1.max'        => trans('validation.max',['attribute'=> trans('account.address1')]),
            'address2.max'        => trans('validation.max',['attribute'=> trans('account.address2')]),
            'last_name.max'       => trans('validation.max',['attribute'=> trans('account.last_name')]),
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
            $customer = ShopUser::find($address->user_id);
            $customer->address_id = $id;
            $customer->save();
        }
        return redirect()->route('admin_customer.edit', ['id' => $address->user_id])
            ->with(['success' => trans('account.update_success')]);
    }

    /**
     * Get address detail 
     *
     * @return  [json] 
     */
    public function deleteAddress() {
        $id = request('id');
        (new ShopUserAddress)
            ->where('id', $id)
            ->delete();
        return json_encode(['error' => 0, 'msg' => trans('account.delete_address_success')]);
    }


}
