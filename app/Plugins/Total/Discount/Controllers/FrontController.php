<?php
#App\Plugins\Total\Discount\Controllers\FrontController.php
namespace App\Plugins\Total\Discount\Controllers;

use App\Plugins\Total\Discount\Models\PluginModel as Discount;
use SCart\Core\Front\Models\ShopOrderTotal;
use Carbon\Carbon;
use App\Plugins\Total\Discount\AppConfig;
use App\Http\Controllers\RootFrontController;
class FrontController extends RootFrontController
{
    private $codes = [];
    private $length;
    private $separator;
    private $suffix;
    private $prefix;
    private $mask;
    public $plugin;

    public function __construct()
    {
        parent::__construct();

        $this->separator = false;
        $this->suffix = false;
        $this->prefix = false;
        $this->length = 8;
        $this->mask = '****-****';
        $this->mask = '****-****';
        $this->plugin = new AppConfig;
    }

    public function output($amount = 1)
    {
        $collection = [];

        for ($i = 1; $i <= $amount; $i++) {
            $random = $this->generate();

            while (!$this->validateCoupon($collection, $random)) {
                $random = $this->generate();
            }

            array_push($collection, $random);
        }

        return $collection;
    }

    /**
     * Save promocodes into database
     * Successful insert returns generated promocodes
     * Fail will return empty collection.
     *
     * @param int $amount
     * @param null $reward
     * @param array $data
     * @param int|null $expires_in
     *
     * @return \Illuminate\Support\Collection
     */
    public function create($amount = 1, $reward = 0, $limit = 1, $type = null, array $data = [], $expires_in = null)
    {
        $records = [];

        foreach ($this->output($amount) as $code) {
            $records[] = [
                'code' => $code,
                'reward' => $reward,
                'data' => json_encode($data),
                'expires_at' => $expires_in ? Carbon::now()->addDays($expires_in) : null,
                'limit' => $limit,
                'type' => $type,
                'status' => 1,
            ];
        }

        if (Discount::insert($records)) {
            return collect($records)->map(function ($record) {
                $record['data'] = json_decode($record['data'], true);
                return $record;
            });
        }

        return collect([]);
    }

/**
 * [check description]
 * @param  [type]  $code       [description]
 * @param  [type]  $uID        [description]
 * @return [type]              [description]
 */
    public function check($code, $uID = null)
    {
        $uID = (int) $uID;
        $promocode = (new Discount)->getPromotionByCode($code);
        if ($promocode === null) {
            return json_encode(['error' => 1, 'msg' => "error_code_not_exist"]);
        }
        //Check user  login
        if ($promocode->login && !$uID) {
            return json_encode(['error' => 1, 'msg' => "error_login"]);
        }

        if ($promocode->limit == 0 || $promocode->limit <= $promocode->used) {
            return json_encode(['error' => 1, 'msg' => "error_code_cant_use"]);
        }

        if ($promocode->status == 0 || $promocode->isExpired()) {
            return json_encode(['error' => 1, 'msg' => "error_code_expired_disabled"]);
        }
        if ($promocode->login) {
            //check if this user has already used this code already
            $arrUsers = [];
            foreach ($promocode->users as $value) {
                $arrUsers[] = $value->pivot->customer_id;
            }
            if (in_array($uID, $arrUsers)) {
                return json_encode(['error' => 1, 'msg' => "error_user_used"]);
            }
        }

        return json_encode(['error' => 0, 'content' => $promocode]);
    }

/**
 * [apply description]
 * @param  [type] $code [description]
 * @param  [type] $uID  [description]
 * @param  [type] $msg  [description]
 * @return [type]       [description]
 */
    public function apply($code, $uID = null, $msg = null)
    {
        //check code valid
        $checkCode = $this->check($code, $uID);
        $check = json_decode($checkCode, true);

        if ($check['error'] === 0) {
            $promocode = (new Discount)->getPromotionByCode($code);
            if($promocode) {
                try {
                    // increment used
                    $promocode->used += 1;
                    $promocode->save();
    
                    $promocode->users()->attach($uID, [
                        'used_at' => Carbon::now(),
                        'log' => $msg,
                    ]);
                    return json_encode(['error' => 0, 'content' => $promocode->load('users')]);
                } catch (\Throwable $e) {
                    return json_encode(['error' => 1, 'msg' => $e->getMessage()]);
                }
            } else {
                return json_encode(['error' => 1, 'msg' => 'error_code_not_exist']);
            }

        } else {
            return $checkCode;
        }

    }

/**
 * [disable description]
 * @param  [type] $code [description]
 * @return [type]       [description]
 */
    public function disableDiscount($code)
    {
        $promocode = (new Discount)->getPromotionByCode($code);

        if ($promocode === null) {
            return json_encode(['error' => 1, 'msg' => "error_code_not_exist"]);
        }
        $promocode->status = 0;
        $promocode->save();
        return json_encode(['error' => 0, 'content' => $promocode->save()]);
    }

/**
 * [enable description]
 * @param  [type] $code [description]
 * @return [type]       [description]
 */
    public function enableDiscount($code)
    {
        $promocode = (new Discount)->getPromotionByCode($code);

        if ($promocode === null) {
            return json_encode(['error' => 1, 'msg' => "error_code_not_exist"]);
        }
        $promocode->status = 1;
        $promocode->save();
        return json_encode(['error' => 0, 'content' => $promocode->save()]);
    }

    /**
     * Here will be generated single code using your parameters from config.
     *
     * @return string
     */
    public function generate()
    {
        $characters = '23456789ABCDEFGHJKLMNPQRSTUVWXYZ';
        $promocode = '';
        $random = [];

        for ($i = 1; $i <= $this->length; $i++) {
            $character = $characters[rand(0, strlen($characters) - 1)];
            $random[] = $character;
        }

        shuffle($random);
        $length = count($random);

        $promocode .= $this->getPrefix();

        for ($i = 0; $i < $length; $i++) {
            $this->mask = preg_replace('/\*/', $random[$i], $this->mask, 1);
        }

        $promocode .= $this->mask;
        $promocode .= $this->getSuffix();

        return $promocode;
    }

    /**
     * Generate prefix with separator for promocode.
     *
     * @return string
     */
    public function getPrefix()
    {

        return (bool) $this->prefix ? $this->prefix . $this->separator : '';
    }

    /**
     * Generate suffix with separator for promocode.
     *
     * @return string
     */
    public function getSuffix()
    {
        return (bool) $this->suffix ? $this->separator . $this->suffix : '';
    }

    /**
     * Your code will be validateCoupond to be unique for one request.
     *
     * @param $collection
     * @param $new
     *
     * @return bool
     */
    public function validateCoupon($collection, $new)
    {
        $this->codes = Discount::pluck('code')->toArray();
        return !in_array($new, array_merge($collection, $this->codes));
    }

/**
 * [useDiscount description]
 * @return [type]           [description]
 */
    public function useDiscount()
    {
        $html = '';
        $code = request('code');
        $uID = request('uID');
        $check = json_decode($this->check($code, $uID), true);
        if ($check['error'] == 1) {
            $error = 1;
            if ($check['msg'] == 'error_code_not_exist') {
                $msg = trans('promotion.process.invalid');
            } elseif ($check['msg'] == 'error_code_cant_use') {
                $msg = trans('promotion.process.over');
            } elseif ($check['msg'] == 'error_code_expired_disabled') {
                $msg = trans('promotion.process.expire');
            } elseif ($check['msg'] == 'error_user_used') {
                $msg = trans('promotion.process.used');
            } elseif ($check['msg'] == 'error_uID_input') {
                $msg = trans('promotion.process.customer_id_invalid');
            } elseif ($check['msg'] == 'error_login') {
                $msg = trans('promotion.process.must_login');
            } else {
                $msg = trans('promotion.process.undefined');
            }
        } else {
            $content = $check['content'];
            if ($content['type'] === 1) {
                //Point use in my page
                $error = 1;
                $msg = trans('promotion.process.not_allow');
            } else {
                $error = 0;
                $msg = trans('promotion.process.completed');

                //Set session discount
                $totalMethod = session('totalMethod',[]);
                $totalMethod[$this->plugin->configKey] = $code;
                session(['totalMethod' => $totalMethod]);

                $objects = ShopOrderTotal::getObjectOrderTotal();
                $dataTotal = ShopOrderTotal::processDataTotal($objects);
                if (view()->exists($this->templatePath.'.common.render_total')) {
                    $html = view($this->templatePath.'.common.render_total')->with(['dataTotal' => $dataTotal])->render();
                }
            }

        }
        return json_encode(['error' => $error, 'msg' => $msg, 'html' => $html]);

    }

    public function removeDiscount()
    {
        $html = '';
        //destroy discount
        $totalMethod = session('totalMethod', []);
        unset($totalMethod[$this->plugin->configKey]);
        session(['totalMethod' => $totalMethod]);

        $objects = ShopOrderTotal::getObjectOrderTotal();
        $dataTotal = ShopOrderTotal::processDataTotal($objects);
        if (view()->exists($this->templatePath.'.common.render_total')) {
            $html = view($this->templatePath.'.common.render_total')->with(['dataTotal' => $dataTotal])->render();
        }
        return json_encode(['html' => $html]);
    }

}
