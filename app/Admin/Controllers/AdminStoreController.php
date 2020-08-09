<?php
#app/Http/Admin/Controllers/AdminStoreController.php
namespace App\Admin\Controllers;

use App\Http\Controllers\Controller;
use App\Models\AdminStore;
use App\Models\AdminStoreDescription;
use App\Models\ShopLanguage;
use App\Models\ShopCurrency;
use Validator;
use Illuminate\Http\Request;

class AdminStoreController extends Controller
{
    public $templates, $currencies, $languages, $allLanguages, $timezones;

    public function __construct()
    {
        $allTemplate = sc_get_all_template();
        $templates = [];
        foreach ($allTemplate as $key => $template) {
            $templates[$key] = empty($template['config']['name']) ? $key : $template['config']['name'];
        }
        foreach (timezone_identifiers_list() as $key => $value) {
            $timezones[$value] = $value;
        }
        $this->templates = $templates;
        $this->currencies = ShopCurrency::getCodeActive();
        $this->languages = ShopLanguage::getCodeActive();
        $this->allLanguages = ShopLanguage::getList();
        $this->timezones = $timezones;

    }

    public function index()
    {
        $data = [
            'title' => trans('config.admin.title'),
            'subTitle' => '',
            'icon' => 'fa fa-indent',
        ];


        $data = [
            'title' => trans('store.admin.list'),
            'subTitle' => '',
            'icon' => 'fa fa-indent',        
        ];
        $stories = AdminStore::getAll();
        $data['stories'] = $stories;
        $data['templates'] = $this->templates;
        $data['allLanguages'] = $this->allLanguages;
        $data['timezones'] = $this->timezones;
        $data['languages'] = $this->languages;
        $data['currencies'] =$this->currencies;

        $data['urlDeleteItem'] = route('admin_store.delete');
        return view('admin.screen.store')
            ->with($data);
    }


    /**
     * Form create new order in admin
     * @return [type] [description]
     */
    public function create()
    {
        $data = [
            'title' => trans('store.admin.add_new_title'),
            'subTitle' => '',
            'title_description' => trans('store.admin.add_new_des'),
            'icon' => 'fa fa-plus',
            'store' => [],
            'allLanguages' => $this->allLanguages,
            'url_action' => route('admin_store.create'),
            'templates' => $this->templates
        ];

        $data['timezones'] = $this->timezones;
        $data['languages'] = $this->languages;
        $data['currencies'] =$this->currencies;

        return view('admin.screen.store_add')
            ->with($data);
    }

    /*
    * Post create new order in admin
    * @return [type] [description]
    */
    public function postCreate()
    {
        $dataOrigin = $data = request()->all();
        $data['domain'] = str_replace(['http://', 'https://'], '', $data['domain']);
        $validator = Validator::make($data, [
            'descriptions.*.title' => 'required|string|max:200',
            'descriptions.*.keyword' => 'nullable|string|max:200',
            'descriptions.*.description' => 'nullable|string|max:300',
            'domain' => 'required|unique:"'.AdminStore::class.'",domain',
            'timezone' => 'required',
            'language' => 'required',
            'currency' => 'required',
            'template' => 'required',
            ], [
                'domain.required' => trans('validation.required', ['attribute' => trans('store.domain')]),
                'descriptions.*.title.required' => trans('validation.required', ['attribute' => trans('store.title')]),
                'descriptions.*.keyword.required' => trans('validation.required', ['attribute' => trans('store.keyword')]),
                'descriptions.*.description.required' => trans('validation.required', ['attribute' => trans('store.description')]),
            ]
        );
        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput($dataOrigin);
        }
        $dataInsert = [
            'logo' => $data['logo'],
            'phone' => $data['phone'],
            'long_phone' => $data['long_phone'],
            'email' => $data['email'],
            'time_active' => $data['time_active'],
            'address' => $data['address'],
            'office' => $data['office'],
            'timezone' => $data['timezone'],
            'language' => $data['language'],
            'currency' => $data['currency'],
            'template' => $data['template'],
            'domain' => $data['domain'],
            'status' => empty($data['status']) ? 0 : 1,
        ];
        $store = AdminStore::create($dataInsert);

        $dataDes = [];
        $languages = ShopLanguage::getList();
        foreach ($languages as $code => $value) {
            $dataDes[] = [
                'store_id' => $store->id,
                'lang' => $code,
                'title' => $data['descriptions'][$code]['title'],
                'keyword' => $data['descriptions'][$code]['keyword'],
                'description' => $data['descriptions'][$code]['description'],
            ];
        }
        AdminStoreDescription::insert($dataDes);

        return redirect()->route('admin_store.index')->with('success', trans('store.admin.create_success'));

    }

    /*
    Update value config
    */
    public function updateInfo()
    {
        $data = request()->all();
        $fieldName = $data['name'];
        $value = $data['value'];
        $parseName = explode('__', $fieldName);
        $storeId = $parseName[0];
        $name = $parseName[1];
        $lang = $parseName[2] ?? '';
        $msg = '';
        if (!in_array($parseName[1], ['title', 'description', 'keyword', 'maintain_content'])) {
            if (config('app.storeId') == $storeId && $name == 'status') {
                $error = 1;
                $msg = trans('store.cannot_disable');
            } else {
                try {
                    if ($name == 'domain') {
                        $value = str_replace(['http://', 'https://'], '', $value);
                        if (AdminStore::where('domain', $value)->first()) {
                            $error = 1;
                            $msg = trans('store.domain_exist');
                        } else {
                            AdminStore::where('id', $storeId)->update([$name => $value]);
                            $error = 0;
                        }
                    } else {
                        AdminStore::where('id', $storeId)->update([$name => $value]);
                        $error = 0;
                    }

                } catch (\Throwable $e) {
                    $error = 1;
                    $msg = $e->getMessage();
                }
            }

            
        } else {
            try {
                AdminStoreDescription::where('store_id', $storeId)
                    ->where('lang', $lang)
                    ->update([$name => $value]);
                $error = 0;
            } catch (\Throwable $e) {
                $error = 1;
                $msg = $e->getMessage();
            }
            
        }
        return response()->json(['error' => $error, 'msg' => $msg]);

    }

    /*
    Delete list item
    Need mothod destroy to boot deleting in model
    */
    public function delete()
    {
        if (!request()->ajax()) {
            return response()->json(['error' => 1, 'msg' => 'Method not allow!']);
        } else {
            $id = request('id');
            if (config('app.storeId') == $id) {
                return response()->json(['error' => 1, 'msg' => trans('store.cannot_delete')]);
            }
            if ($id != 1) {
                AdminStore::destroy($id);
            }
            return response()->json(['error' => 0, 'msg' => '']);
        }
    }

}
