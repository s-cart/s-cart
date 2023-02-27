<?php
namespace App\Pmo\Admin\Controllers;

use App\Pmo\Admin\Controllers\RootAdminController;
use App\Pmo\Front\Models\Languages;
use App\Pmo\Front\Models\ShopLanguage;
use Validator;

class AdminLanguageManagerController extends RootAdminController
{
    public function __construct()
    {
        parent::__construct();
    }
    public function index()
    {
        $lang = request('lang');
        $position = request('position');
        $keyword = request('keyword');
        $languages = ShopLanguage::getListAll();
        $positionLang = Languages::getPosition();
        $languagesPosition = Languages::getLanguagesPosition($lang, $position, $keyword);
        
        $codeLanguages = ShopLanguage::getCodeAll();
        if (!in_array($lang, array_keys($codeLanguages))) {
            $languagesPositionEL =   [];
        } else {
            $languagesPositionEL = Languages::getLanguagesPosition('en', $position, $keyword);
        }
        $arrayKeyLanguagesPosition = array_keys($languagesPosition);
        $arrayKeyLanguagesPositionEL = array_keys($languagesPositionEL);
        $arrayKeyDiff = array_diff($arrayKeyLanguagesPositionEL, $arrayKeyLanguagesPosition);
        $urlUpdateData = sc_route_admin('admin_language_manager.update');
        $data = [
            'languages' => $languages,
            'lang' => $lang,
            'positionLang' => $positionLang,
            'position' => $position,
            'keyword' => $keyword,
            'languagesPosition' => $languagesPosition,
            'languagesPositionEL' => $languagesPositionEL,
            'arrayKeyDiff' => $arrayKeyDiff,
            'urlUpdateData' => $urlUpdateData,
            'title' => sc_language_render('admin.language_manager.title'),
            'subTitle' => '',
            'icon' => 'fa fa-indent',
            'removeList' => 0, // 1 - Enable function delete list item
            'buttonRefresh' => 0, // 1 - Enable button refresh
            'buttonSort' => 0, // 1 - Enable button sort
            'css' => '',
            'js' => '',
            'layout' => 'index',
        ];


        return view($this->templatePathAdmin.'screen.language_manager')
            ->with($data);
    }

    /**
     * Update data
     *
     * @return void
     */
    public function postUpdate()
    {
        if (!request()->ajax()) {
            return response()->json(['error' => 1, 'msg' => sc_language_render('admin.method_not_allow')]);
        } else {
            $data = request()->all();
            $lang = sc_clean($data['lang']);
            $name = sc_clean($data['name']);
            $value = sc_clean($data['value']);
            $position = sc_clean($data['pk']);
            $languages = ShopLanguage::getCodeAll();
            if (!in_array($lang, array_keys($languages))) {
                return response()->json(['error' => 1, 'msg' => sc_language_render('admin.method_not_allow')]);
            }
            if ($position) {
                Languages::updateOrCreate(
                    ['location' => $lang, 'code' => $name],
                    ['text' => $value, 'position' => $position],
                );
            } else {
                Languages::updateOrCreate(
                    ['location' => $lang, 'code' => $name],
                    ['text' => $value],
                );
            }

            return response()->json(['error' => 0, 'msg' => sc_language_render('action.update_success')]);
        }
    }

    /**
     * Screen add new record language
     *
     * @return void
     */
    public function add()
    {
        $languages = ShopLanguage::getListAll();
        $positionLang = Languages::getPosition();
        $data = [
            'title' => sc_language_render('admin.language_manager.add'),
            'positionLang' => $positionLang,
            'languages' => $languages,
        ];
        return view($this->templatePathAdmin.'screen.language_manager_add')
            ->with($data);
    }

    /**
     * Add new record for language
     *
     * @return void
     */
    public function postAdd()
    {
        $data = request()->all();
        $validator = Validator::make(
            $data,
            [
                'text'         => 'required',
                'position' => 'required_without:position_new',
                'code'         => 'required|unique:"'.Languages::class.'",code|string|max:100',
            ]
        );

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput($data);
        }

        $dataCreate = [
            'code' => trim($data['code']),
            'text' => trim($data['text']),
            'position' => trim(empty($data['position_new']) ? $data['position'] : $data['position_new']),
            'location' => 'en',
        ];
        $dataCreate = sc_clean($dataCreate, ['text'], true);
        Languages::insert($dataCreate);

        return redirect(sc_route_admin('admin_language_manager.index'))->with('success', sc_language_render('action.create_success'));
    }
}
