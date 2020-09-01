<?php
/**
 * @author Naruto <lanhktc@gmail.com>
 */

require __DIR__ . '/../vendor/autoload.php';
$app = include_once __DIR__ . '/../bootstrap/app.php';
use Illuminate\Encryption\Encrypter;
use Illuminate\Support\Facades\Artisan;
$kernel   = $app->make(Illuminate\Contracts\Http\Kernel::class);
$response = $kernel->handle(
    $request = Illuminate\Http\Request::capture()
);
$lang = request('lang') ?? 'en';
app()->setlocale($lang);
if (request()->method() == 'POST' && request()->ajax()) {

    $step = request('step');
    switch ($step) {
        case 'step1':
            $domain            = str_replace('/install.php', '', url()->current());
            $database_host     = request('database_host') ?? '127.0.0.1';
            $database_port     = request('database_port') ?? '3306';
            $database_name     = request('database_name') ?? '';
            $database_user     = request('database_user') ?? '';
            $database_password = request('database_password') ?? '';
            $database_prefix   = request('database_prefix') ?? '';
            $admin_url         = request('admin_url') ?? '';
            $admin_url         = str_replace('/','',strip_tags(strtolower($admin_url)));
            if (in_array($admin_url, ['','admin','css','data','images','js','packages','templates', 'plugin', 'plugins','vendor','component'])) {
                $admin_url = 'sc_admin';
            }
            
        try {
            $api_key = 'base64:' . base64_encode(
                Encrypter::generateKey(config('app.cipher'))
            );
            $getEnv = file_get_contents(base_path() . '/.env.example');
            $getEnv = str_replace('sc_your_domain', $domain, $getEnv);
            $getEnv = str_replace('sc_database_host', $database_host, $getEnv);
            $getEnv = str_replace('sc_database_port', $database_port, $getEnv);
            $getEnv = str_replace('sc_database_name', $database_name, $getEnv);
            $getEnv = str_replace('sc_database_user', $database_user, $getEnv);
            $getEnv = str_replace('DB_PREFIX=sc_', 'DB_PREFIX='.$database_prefix, $getEnv);
            $getEnv = str_replace('sc_database_password', $database_password, $getEnv);
            $getEnv = str_replace('sc_api_key', $api_key, $getEnv);
            $getEnv = str_replace('sc_admin', $admin_url, $getEnv);

            $env = fopen(base_path() . "/.env", "w") or die(json_encode(['error' => 1, 'msg' => trans('install.env.error_open')]));
            fwrite($env, $getEnv);
            fclose($env);

        } catch (\Throwable $e) {
            echo json_encode(['error' => 1, 'msg' => $e->getMessage()]);
            exit();
        }

        $infoInstall =  [
            'timezone_default' => request('timezone_default'),
            'language_default' => request('language_default'),
            'admin_user' => request('admin_user'),
            'admin_password' => bcrypt(request('admin_password')),
            'admin_email' => request('admin_email'),
            'admin_url' => $admin_url,
        ];

            echo json_encode(['error' => 0, 'msg' => trans('install.env.process_sucess'), 'infoInstall' => $infoInstall]);
            break;

    case 'step2-1':
        session(['infoInstall'=> request('infoInstall')]);
        //Drop table migrations if exist
        try {
            \Schema::dropIfExists('migrations');
            Artisan::call('migrate --path=/database/migrations/2020_00_00_step1_create_tables_admin.php');
        } catch(\Throwable $e) {
            echo json_encode([
                'error' => '1',
                'msg' => $e->getMessage(),
            ]);
            break;
        }
        echo json_encode([
            'error' => '0',
            'msg' => trans('install.database.process_sucess_1'),
            'infoInstall' => request('infoInstall')
        ]);
        break;

        case 'step2-2':
            session(['infoInstall'=> request('infoInstall')]);
            try {
                Artisan::call('migrate --path=/database/migrations/2020_00_00_step2_create_tables_shop.php');
            } catch(\Throwable $e) {
                echo json_encode([
                    'error' => '1',
                    'msg' => $e->getMessage(),
                ]);
                break;
            }
            echo json_encode([
                'error' => '0',
                'msg' => trans('install.database.process_sucess_2'),
                'infoInstall' => request('infoInstall')
            ]);
            break;

        case 'step2-3':
            session(['infoInstall'=> request('infoInstall')]);
            try {
                Artisan::call('db:seed --class=DataAdminSeeder');
                Artisan::call('db:seed --class=DataStoreSeeder');
            } catch(\Throwable $e) {
                echo json_encode([
                    'error' => '1',
                    'msg' => $e->getMessage(),
                ]);
                break;
            }
            echo json_encode([
                'error' => '0',
                'msg' => trans('install.database.process_sucess_3'),
                'infoInstall' => request('infoInstall')
            ]);
            break;

            case 'step2-4':
                session(['infoInstall'=> request('infoInstall')]);
                try {
                    Artisan::call('db:seed --class=DataShopSeeder');
                } catch(\Throwable $e) {
                    echo json_encode([
                        'error' => '1',
                        'msg' => $e->getMessage(),
                    ]);
                    break;
                }
                session()->forget('infoInstall');
                echo json_encode([
                    'error' => '0',
                    'msg' => trans('install.database.process_sucess_4'),
                ]);
                break;

                case 'step2-5':
                    session(['infoInstall'=> request('infoInstall')]);
                    try {
                        Artisan::call('db:seed --class=DataProductSeeder');
                        Artisan::call('passport:install');
                    } catch(\Throwable $e) {
                        echo json_encode([
                            'error' => '1',
                            'msg' => $e->getMessage(),
                        ]);
                        break;
                    }
                    session()->forget('infoInstall');
                    echo json_encode([
                        'error' => '0',
                        'msg' => trans('install.database.process_sucess_5'),
                    ]);
                    break;


    case 'step3':
        try {
            rename(base_path() . '/public/install.php', base_path() . '/public/install.scart');
        } catch (\Throwable $e) {
            echo json_encode([
                'error' => '1',
                'msg' => trans('install.rename_error'),
            ]);
            break;
        }
        echo json_encode([
            'error' => '0',
            'msg' => '',
        ]);
        break;

    default:
        break;
    }
} else {
    $dirsWritable = [
        storage_path(),
        public_path('data'),
        base_path('vendor'),
        base_path('bootstrap/cache'),
    ];
    @exec('chmod o+w -R ' . implode(' ', $dirsWritable));
    
    $requirements = [
        'ext' => [
            'PHP >= 7.2.5'                 => version_compare(PHP_VERSION, '7.2.5', '>='),
            'BCMath PHP Extension'         => extension_loaded('bcmath'),
            'Ctype PHP Extension'          => extension_loaded('ctype'),
            'JSON PHP Extension'           => extension_loaded('json'),
            'OpenSSL PHP Extension'        => extension_loaded('openssl'),
            'PDO PHP Extension'            => extension_loaded('pdo'),
            'Tokenizer PHP Extension'      => extension_loaded('tokenizer'),
            'XML PHP extension'            => extension_loaded('xml'),
            'xmlwriter PHP extension'      => extension_loaded('xmlwriter'),
            'Mbstring PHP extension'       => extension_loaded('mbstring'),
            'ZipArchive PHP extension'     => extension_loaded('zip'),
            'GD (optional) PHP extension'  => extension_loaded('gd'),
            'Dom (optional) PHP extension' => extension_loaded('dom'),
        ],
        'writable' => [
            storage_path() => is_writable(storage_path()),
            public_path('data') => is_writable(public_path('data')),
            base_path('vendor') => is_writable(base_path('vendor')),
            base_path('bootstrap/cache') => is_writable(base_path('bootstrap/cache')),
        ]
    ];

    echo view('install', array(
        'path_lang' => (($lang != 'en') ? "?lang=" . $lang : ""),
        'title'     => trans('install.title'), 'requirements' => $requirements)
    );
    exit();
}
