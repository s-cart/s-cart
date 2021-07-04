<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
class DataDefaultSeeder extends Seeder
{
    public $adminUser = 'admin';
    //admin
    public $adminPassword = '$2y$10$JcmAHe5eUZ2rS0jU1GWr/.xhwCnh2RU13qwjTPcqfmtZXjZxcryPO';
    public $adminEmail = 'your-email@your-domain.com';
    public $timezone_default = 'Asia/Ho_Chi_Minh';
    public $language_default = 'en';

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //Insert admin
        $pathAdminFull = base_path('vendor/s-cart/core/src/DB/default.sql');
        if (!empty(session('infoInstall')['admin_user'])) {
            $this->adminUser = session('infoInstall')['admin_user'];
        }
        if (!empty(session('infoInstall')['admin_password'])) {
            $this->adminPassword = session('infoInstall')['admin_password'];
        }
        if (!empty(session('infoInstall')['admin_email'])) {
            $this->adminEmail = session('infoInstall')['admin_email'];
        }
        
        if (!empty(session('infoInstall')['timezone_default'])) {
            $this->timezone_default = session('infoInstall')['timezone_default'];
        }
        if (!empty(session('infoInstall')['language_default'])) {
            $this->language_default = session('infoInstall')['language_default'];
        }
        $search = [
            '__SC_DB_PREFIX__',
            '__SC_ADMIN_PREFIX__',
            '__adminUser__',
            '__adminPassword__',
            '__adminEmail__',
            '__timezone_default__',
            '__language_default__',
            '__domain__',
        ];
        $replace = [
            SC_DB_PREFIX,
            SC_ADMIN_PREFIX,
            $this->adminUser,
            $this->adminPassword,
            $this->adminEmail,
            $this->timezone_default,
            $this->language_default,
            str_replace(['http://','https://', '/install.php'], '', url('/')),
        ];
        $content = str_replace(
            $search,
            $replace,
            file_get_contents($pathAdminFull)
        );

        DB::connection(SC_CONNECTION)->unprepared($content);
    }
}
