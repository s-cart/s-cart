<?php

namespace App\Models;

use App\Models\ShopEmailTemplate;
use App\Models\ShopUserAddress;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Auth;
use Laravel\Passport\HasApiTokens;

class ShopUser extends Authenticatable
{
    use Notifiable, HasApiTokens;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $table = SC_DB_PREFIX.'shop_user';
    protected $guarded = [];
    protected $connection = SC_CONNECTION;
    private static $getList = null;
    private static $profile = null;
    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];
    protected $appends = [
        'name',
    ];
    public function orders()
    {
        return $this->hasMany(ShopOrder::class, 'user_id', 'id');
    }

    public function addresses()
    {
        return $this->hasMany(ShopUserAddress::class, 'user_id', 'id');
    }

    public static function getListAll()
    {
        if (self::$getList === null) {
            self::$getList = self::get()->keyBy('id');
        }
        return self::$getList;
    }

    /**
     * Send email reset password
     * @param  [type] $token [description]
     * @return [type]        [description]
     */
    public function sendPasswordResetNotification($token)
    {
        $checkContent = (new ShopEmailTemplate)->where('group', 'forgot_password')->where('status', 1)->first();
        if ($checkContent) {
            $content = $checkContent->text;
            $dataFind = [
                '/\{\{\$title\}\}/',
                '/\{\{\$reason_sendmail\}\}/',
                '/\{\{\$note_sendmail\}\}/',
                '/\{\{\$note_access_link\}\}/',
                '/\{\{\$reset_link\}\}/',
                '/\{\{\$reset_button\}\}/',
            ];
            $dataReplace = [
                trans('email.forgot_password.title'),
                trans('email.forgot_password.reason_sendmail'),
                trans('email.forgot_password.note_sendmail', ['site_admin' => config('mail.from.name')]),
                trans('email.forgot_password.note_access_link', ['reset_button' => trans('email.forgot_password.reset_button')]),
                route('password.reset', ['token' => $token]),
                trans('email.forgot_password.reset_button'),
            ];
            $content = preg_replace($dataFind, $dataReplace, $content);
            $dataView = [
                'content' => $content,
            ];

            $config = [
                'to' => $this->getEmailForPasswordReset(),
                'subject' => trans('email.forgot_password.reset_button'),
            ];

            sc_send_mail('templates.' . sc_store('template') . '.mail.forgot_password', $dataView, $config, $dataAtt = []);
        }

    }

    /*
    Full name
     */
    public function getNameAttribute()
    {
        return $this->first_name . ' ' . $this->last_name;

    }

/**
 * Update info customer
 * @param  [array] $dataUpdate
 * @param  [int] $id
 */
    public static function updateInfo($dataUpdate, $id)
    {
        $dataUpdate = sc_clean($dataUpdate, 'password');
        $obj = self::find($id);
        return $obj->update($dataUpdate);
    }

/**
 * Create new customer
 * @return [type] [description]
 */
    public static function createCustomer($dataInsert)
    {
        $dataClean = sc_clean($dataInsert, 'password');
        $dataAddress = [
            'first_name'      => $dataClean['first_name'] ?? '',
            'last_name'       => $dataClean['last_name'] ?? '',
            'first_name_kana' => $dataClean['first_name_kana'] ?? '',
            'last_name_kana'  => $dataClean['last_name_kana'] ?? '',
            'postcode'        => $dataClean['postcode'] ?? '',
            'address1'        => $dataClean['address1'] ?? '',
            'address2'        => $dataClean['address2'] ?? '',
            'country'         => $dataClean['country'] ?? '',
            'phone'           => $dataClean['phone'] ?? '',
        ];
        $user = self::create($dataClean);
        $address = $user->addresses()->save(new ShopUserAddress($dataAddress));
        $user->address_id = $address->id;
        $user->save();
        return $user;
    }

    /**
     * Get address default of user
     *
     * @return  [collect]
     */
    public function getAddressDefault() {
        return (new ShopUserAddress)->where('user_id', $this->id)
            ->where('id', $this->address_id)
            ->first();
    }

    public function profile() {
        if (self::$profile === null) {
            self::$profile = Auth::user();
        }
        return self::$profile;
    }

}
