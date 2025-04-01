<?php
/**
 * Template format 1.0
 */
#App\GP247\Templates\Default\AppConfig.php
namespace App\GP247\Templates\Default;

use GP247\Core\Models\AdminConfig;
use GP247\Core\Models\AdminStore;
use GP247\Core\Models\AdminHome;
use GP247\Front\Models\FrontLayoutBlock;
use GP247\Front\Models\FrontBanner;
use GP247\Front\Models\FrontBannerStore;
use GP247\Core\ExtensionConfigDefault;
class AppConfig extends ExtensionConfigDefault
{
    public function __construct()
    { 
        //Read config from gp247.json
        $config = file_get_contents(__DIR__.'/gp247.json');
        $config = json_decode($config, true);
    	$this->configGroup = $config['configGroup'];
        $this->configKey = $config['configKey'];
        $this->requireCore = $config['requireCore'] ?? [];
        $this->requirePackages = $config['requirePackages'] ?? [];
        $this->requireExtensions = $config['requireExtensions'] ?? [];

        //Path
        $this->appPath = $this->configGroup . '/' . $this->configKey;
        //Language
        $this->title = trans($this->appPath.'::lang.title');
        //Image logo or thumb
        $this->image = $this->appPath.'/'.$config['image'];
        //
        $this->version = $config['version'];
        $this->auth = $config['auth'];
        $this->link = $config['link'];
    }

    public function install()
    {
        $check = AdminConfig::where('key', $this->configKey)
            ->where('group', $this->configGroup)->first();
        if ($check) {
            //Check Plugin key exist
            $return = ['error' => 1, 'msg' =>  gp247_language_render('admin.extension.plugin_exist')];
        } else {
            //Insert plugin to config
            $dataInsert = [
                [
                    'group'  => $this->configGroup,
                    'key'    => $this->configKey,
                    'code'    => $this->configKey,
                    'sort'   => 0,
                    'store_id' => GP247_STORE_ID_GLOBAL,
                    'value'  => self::ON, //Enable extension
                    'detail' => $this->appPath.'::lang.title',
                ],
            ];
            $process = AdminConfig::insert(
                $dataInsert
            );
            if (app()->runningInConsole()) {
                // While install template from command, cannot load helper gp247
                if (!$process) {
                    $return = ['error' => 1, 'msg' => 'Error installing template'];
                } else {
                    $return = ['error' => 0, 'msg' => 'Install template success'];
                }
            } else {
                if (!$process) {
                    $return = ['error' => 1, 'msg' => gp247_language_render('admin.extension.install_faild')];
                } else {
                    $return = ['error' => 0, 'msg' => gp247_language_render('admin.extension.install_success')];
                }
            }

        }

        //Setup store for Root store
        $this->setupStore(GP247_STORE_ID_ROOT);

        return $return;
    }

    public function uninstall()
    {
        //Please delete all values inserted in the installation step
        $process = (new AdminConfig)
            ->where('key', $this->configKey)
            ->orWhere('code', $this->configKey.'_config')
            ->delete();
        if (!$process) {
            $return = ['error' => 1, 'msg' => gp247_language_render('admin.extension.action_error', ['action' => 'Uninstall'])];
        } else {
            //Admin config home
            AdminHome::where('extension', $this->appPath)->delete();
            $return = ['error' => 0, 'msg' => gp247_language_render('admin.extension.uninstall_success')];
        }

        //Remove setup for all stores
        $this->removeStore();

        return $return;
    }
    
    public function enable()
    {
        $process = (new AdminConfig)
            ->where('group', $this->configGroup)
            ->where('key', $this->configKey)
            ->update(['value' => self::ON]);
        if (!$process) {
            $return = ['error' => 1, 'msg' => gp247_language_render('admin.extension.action_error', ['action' => 'Enable'])];
        }
        $return = ['error' => 0, 'msg' => gp247_language_render('admin.extension.enable_success')];
        return $return;
    }

    public function disable()
    {
        $process = (new AdminConfig)
            ->where('group', $this->configGroup)
            ->where('key', $this->configKey)
            ->update(['value' => self::OFF]);
        if (!$process) {
            $return = ['error' => 1, 'msg' => gp247_language_render('admin.extension.action_error', ['action' => 'Disable'])];
        } else {
            //Admin config home
            AdminHome::where('extension', $this->appPath)->update(['status' => 0]);
            $return = ['error' => 0, 'msg' => gp247_language_render('admin.extension.disable_success')];
        }

        return $return;
    }


    /**
     * Get info template
     *
     * @return  [type]  [return description]
     */
    public function getInfo()
    {
        $arrData = [
            'title' => $this->title,
            'key' => $this->configKey,
            'image' => $this->image,
            'permission' => self::ALLOW,
            'version' => $this->version,
            'auth' => $this->auth,
            'link' => $this->link,
            'appPath' => $this->appPath
        ];

        return $arrData;
    }

    // Remove setup for store

    public function removeStore($storeId = null)
    {
        if ($storeId) {
            FrontLayoutBlock::where('template', $this->configKey)
                ->where('store_id', $storeId)
                ->delete();
            $tableBanner = (new FrontBanner)->getTable();
            $tableBannerStore = (new FrontBannerStore)->getTable();
            $idBanners = (new FrontBanner)
                ->join($tableBannerStore, $tableBannerStore.'.banner_id', $tableBanner.'.id')
                ->where($tableBanner.'.title', 'like', '%('.$this->configKey.')%')
                ->where($tableBannerStore.'.store_id', $storeId)
                ->pluck('id');
    
            if ($idBanners) {
                FrontBannerStore::whereIn('banner_id', $idBanners)
                ->delete();
                FrontBanner::whereIn('id', $idBanners)
                ->delete();
            }
        } else {
            // Remove from all stories
            FrontLayoutBlock::where('template', $this->configKey)
                ->delete();
            $idBanners = FrontBanner::where('title', 'like', '%('.$this->configKey.')%')
                ->pluck('id');
            if ($idBanners) {
                FrontBannerStore::whereIn('banner_id', $idBanners)
                ->delete();
                FrontBanner::whereIn('id', $idBanners)
                ->delete();
            }
        }
    }

    // Setup for store

    public function setupStore($storeId = null)
    {
        // Change template for store
        AdminStore::where('id', $storeId)
            ->update(['template' => $this->configKey]);

        // Insert layout block for store
        $dataInsert[] = [
            'id'       => $this->uuid(),
            'name'     => 'Banner top ('.$this->configKey.')',
            'position' => 'top',
            'page'     => 'front_home',
            'text'     => 'banner_image',
            'type'     => 'view',
            'sort'     => 10,
            'status'   => 1,
            'template' => $this->configKey,
            'store_id' => $storeId,
        ];

        $dataInsert[] = [
            'id'       => $this->uuid(),
            'name'     => 'Page home ('.$this->configKey.')',
            'position' => 'bottom',
            'page'     => 'front_home',
            'text'     => 'home',
            'type'     => 'page',
            'sort'     => 10,
            'status'   => 1,
            'template' => $this->configKey,
            'store_id' => $storeId,
        ];

        FrontLayoutBlock::insert($dataInsert);
    
        $modelBanner = new FrontBanner;
        $modelBannerStore = new FrontBannerStore; 
    
        $idBanner1 = $modelBanner->create(['id' => $this->uuid(), 'title' => 'Banner home 1 ('.$this->configKey.')', 'image' => 'https://picsum.photos/800/400?random=1', 'target' => '_self', 'html' => '', 'status' => 1, 'type' => 'banner']);
        $modelBannerStore->create(['banner_id' => $idBanner1->id, 'store_id' => $storeId]);
        $idBanner2 = $modelBanner->create(['id' => $this->uuid(), 'title' => 'Banner home 2 ('.$this->configKey.')', 'image' => 'https://picsum.photos/800/400?random=2', 'target' => '_self', 'html' => '', 'status' => 1, 'type' => 'banner']);
        $modelBannerStore->create(['banner_id' => $idBanner2->id, 'store_id' => $storeId]);
        $idBanner3 = $modelBanner->create(['id' => $this->uuid(), 'title' => 'Banner breadcrumb ('.$this->configKey.')', 'image' => 'https://picsum.photos/800/400?random=3', 'target' => '_self', 'html' => '', 'status' => 1, 'type' => 'breadcrumb']);
        $modelBannerStore->create(['banner_id' => $idBanner3->id, 'store_id' => $storeId]);
        $idBanner4 = $modelBanner->create(['id' => $this->uuid(), 'title' => 'Banner store ('.$this->configKey.')', 'image' => 'https://picsum.photos/800/400?random=4', 'target' => '_self', 'html' => '', 'status' => 1, 'type' => 'banner-store']);
        $modelBannerStore->create(['banner_id' => $idBanner4->id, 'store_id' => $storeId]);
    
    }
    private function uuid() {
        // While install template from command, cannot load helper gp247
        if(app()->runningInConsole( )) {
            return (string)\Illuminate\Support\Str::orderedUuid();
        } else {
            return gp247_uuid();
        }
    }
}