<?php
#app/Http/Admin/Controllers/AdminPluginsController.php
namespace App\Admin\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\File;  

class AdminPluginsController extends Controller
{

    public function index($code)
    {
        $code = sc_word_format_class($code);
        $action = request('action');
        $pluginKey = request('pluginKey');
        if ($action == 'config' && $pluginKey != '') {
            $namespace = sc_get_class_plugin_config($code, $pluginKey);
            $body = (new $namespace)->config();
        } else {
            $body = $this->pluginCode($code);
        }
        return $body;
    }

    protected function pluginCode($code)
    {
        $code = sc_word_format_class($code);

        $arrDefault = []; // plugin default, cannot remove
        if($code == 'Payment') {
            $arrDefault[] = 'Cash';
        }
        if($code == 'Shipping') {
            $arrDefault[] = 'ShippingStandard';
        }
        if($code == 'Total') {
            $arrDefault[] = 'Discount';
        }
        $pluginsInstalled = sc_get_plugin_installed($code, $onlyActive = false);
        $plugins = sc_get_all_plugin($code);
        $title = trans('admin.plugin_manager.' . $code.'_plugin');
        return $this->render($pluginsInstalled, $plugins,  $title, $code, $arrDefault);
    }

    public function render($pluginsInstalled, $plugins, $title, $code, $arrDefault)
    {
        return view('admin.screen.plugin')->with(
            [
                "title" => $title,
                "pluginsInstalled" => $pluginsInstalled,
                "plugins" => $plugins,
                "code" => $code,
                "arrDefault" => $arrDefault,
            ]);
    }

    /**
     * Install Plugin
     */
    public function install()
    {
        $key = request('key');
        $code = request('code');
        $namespace = sc_get_class_plugin_config($code, $key);
        $response = (new $namespace)->install();
        return json_encode($response);
    }

    /**
     * Uninstall plugin
     *
     * @return  [type]  [return description]
     */
    public function uninstall()
    {
        $key = request('key');
        $code = request('code');
        $namespace = sc_get_class_plugin_config($code, $key);
        $response = (new $namespace)->uninstall();
        File::deleteDirectory(app_path('Plugins/'.$code.'/'.$key));
        File::deleteDirectory(public_path('Plugins/'.$code.'/'.$key));
        return json_encode($response);
    }

    /**
     * Enable plugin
     *
     * @return  [type]  [return description]
     */
    public function enable()
    {
        $key = request('key');
        $code = request('code');
        $namespace = sc_get_class_plugin_config($code, $key);
        $response = (new $namespace)->enable();
        return json_encode($response);
    }

    /**
     * Disable plugin
     *
     * @return  [type]  [return description]
     */
    public function disable()
    {
        $key = request('key');
        $code = request('code');
        $namespace = sc_get_class_plugin_config($code, $key);
        $response = (new $namespace)->disable();
        return json_encode($response);
    }

    /**
     * Process plugin
     *
     * @param   [type]  $code  [$code description]
     * @param   [type]  $key   [$key description]
     *
     * @return  [type]         [return description]
     */
    public function process($code, $key)
    {
        $data = request()->all();
        $namespace = sc_get_class_plugin_config($code, $key);
        $response = (new $namespace)->process($data);
        return json_encode($response);
    }

    /**
     * Import plugin
     */
    public function importPlugin() {
        $data =  [
            'title' => trans('plugin.import')
        ];
        return view('admin.screen.plugin_upload')
        ->with($data);
    }

    /**
     * Process import
     *
     * @return  [type]  [return description]
     */
    public function processImport() {
        $data = request()->all();
        $validator = \Validator::make(
            $data,
            [
                'file'   => 'required|mimetypes:application/zip|max:51200',
            ]
        );

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }
        $pathTmp = time();
        $pathFile = sc_file_upload($data['file'],'tmp', $pathFolder = $pathTmp);
        if($pathFile) {
            $unzip = sc_unzip(storage_path('tmp/'.$pathFile), storage_path('tmp/'.$pathTmp));
            if($unzip) {
                $checkConfig = glob(storage_path('tmp/'.$pathTmp) . '/*/src/config.json');
                if($checkConfig) {
                    $folderName = explode('/src',$checkConfig[0]);
                    $folderName = explode('/', $folderName[0]);
                    $folderName = end($folderName);
                    $config = json_decode(file_get_contents($checkConfig[0]), true);
                    $configGroup = $config['configGroup'] ?? '';
                    $configCode = $config['configCode'] ?? '';
                    $configKey = $config['configKey'] ?? '';
                    if (!$configGroup || !$configCode || !$configKey) {
                        File::deleteDirectory(storage_path('tmp/'.$pathTmp));
                        return redirect()->back()->with('error', trans('plugin.error_config'));
                    }

                    $arrPluginLocal = sc_get_all_plugin($configCode);
                    if(array_key_exists($configKey, $arrPluginLocal)) {
                        File::deleteDirectory(storage_path('tmp/'.$pathTmp));
                        return redirect()->back()->with('error', trans('plugin.error_exist'));
                    }

                    $pathPlugin = $configGroup.'/'.$configCode.'/'.$configKey;
                    try {
                        File::copyDirectory(storage_path('tmp/'.$pathTmp.'/'.$folderName.'/public'), public_path($pathPlugin));
                        File::copyDirectory(storage_path('tmp/'.$pathTmp.'/'.$folderName.'/src'), app_path($pathPlugin));
                        File::deleteDirectory(storage_path('tmp/'.$pathTmp));
                        $namespace = sc_get_class_plugin_config($configCode, $configKey);
                        $response = (new $namespace)->install();
                    } catch(\Exception $e) {
                        File::deleteDirectory(storage_path('tmp/'.$pathTmp));
                        return redirect()->back()->with('error', $e->getMessage());
                    }

                } else {
                    File::deleteDirectory(storage_path('tmp/'.$pathTmp));
                    return redirect()->back()->with('error', trans('plugin.error_check_config'));
                }
            } else {
                return redirect()->back()->with('error', trans('plugin.error_unzip'));
            }
        } else {
            return redirect()->back()->with('error', trans('plugin.error_upload'));
        }
        return redirect()->back()->with('success', trans('plugin.import_success')); 
    }


    public function exportFormat() {
        $type = request('type');
        switch ($type) {
            case 'import_product':
                header('Content-Type: text/csv; charset=utf-8');
                header('Content-Disposition: attachment; filename='.$type.'.csv');
                $output = fopen('php://output', 'w');
                $dataHeader = [
                    'sku' => 'SKU of product',
                    'image' => 'Path of image',
                    'brand_id' => 'ID of Brand',
                    'vendor_id' => 'ID of vendor',
                    'price' => 'Price is numeric',
                    'cost' => 'Cost  is numeric',
                    'stock' => 'Stock  is numeric',
                    'sold' => 'Sold  is numeric',
                    'type' => 'Type  is numeric',
                    'kind' => 'Kind is numeric',
                    'virtual' => 'Virtual is numeric',
                    'status' => 'Status: 0 off - 1 on',
                    'date_available' => 'Empty or like 2020-10-06',
                ];
                $dataExample = [
                    'sku' => 'SKUDEMO_001',
                    'image' => '/data/product/img-22.jpg',
                    'brand_id' => '2',
                    'vendor_id' => '1',
                    'price' => '15000',
                    'cost' => '5000',
                    'stock' => '100',
                    'sold' => '0',
                    'type' => '0',
                    'kind' => '0',
                    'virtual' => '0',
                    'status' => '1',
                    'date_available' => '2020-10-06',
                ];
                fputcsv($output, array_keys($dataHeader));
                fputcsv($output, $dataHeader);
                fputcsv($output, $dataExample);
                break;

                case 'import_product_description':
                    header('Content-Type: text/csv; charset=utf-8');
                    header('Content-Disposition: attachment; filename='.$type.'.csv');
                    $output = fopen('php://output', 'w');
                    $dataHeader = [
                        'sku' => 'SKU of product',
                        'lang' => 'Code of language. Ex en,vi',
                        'name' => 'Name of product',
                        'keyword' => 'Keywords',
                        'description' => 'Description',
                        'content' => 'Detail for product',
                    ];
                    $dataExample1 = [
                        'sku' => 'SKUDEMO_001',
                        'lang' => 'en',
                        'name' => 'Easy Polo Black Edition',
                        'keyword' => 's-cart, free',
                        'description' => '',
                        'content' => '<p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.</p>',
                    ];
                    $dataExample2 = [
                        'sku' => 'SKUDEMO_001',
                        'lang' => 'vi',
                        'name' => 'Phien ban mau den',
                        'keyword' => '',
                        'description' => '',
                        'content' => '<p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.</p>',
                    ];                    
                    fputcsv($output, array_keys($dataHeader));
                    fputcsv($output, $dataHeader);
                    fputcsv($output, $dataExample1);
                    fputcsv($output, $dataExample2);
                    break;

            default:
                ;
        }
        exit;
    }

}
