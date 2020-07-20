<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Models\ShopProduct;
use App\Models\ShopCategory;
use App\Models\ShopBanner;
use App\Models\ShopBrand;
use App\Models\ShopSupplier;
use App\Models\ShopNews;
use App\Models\ShopPage;

class ScartServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        foreach (glob(app_path() . '/Library/Helpers/*.php') as $filename) {
            require_once $filename;
        }

        foreach (glob(app_path() . '/Plugins/*/*/Provider.php') as $filename) {
            require_once $filename;
        }

        if(!file_exists(public_path('install.php'))) {
            $this->bootScart();
        }

    }

    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        if(file_exists(app_path().'/Library/Const.php')) {
            require_once (app_path().'/Library/Const.php');
        }
        $this->app->bind('cart', 'App\Library\ShoppingCart\Cart');
        
        $this->registerRouteMiddleware();
    }

    public function bootScart()
    {
            if (sc_config('LOG_SLACK_WEBHOOK_URL')) {
                config(['logging.channels.slack.url' => sc_config('LOG_SLACK_WEBHOOK_URL')]);
            }
            config(['app.name' => sc_store('title')]);

            //Config for  email
            $smtpMode = sc_config('email_action_smtp_mode') ? 'smtp' : 'sendmail';
            config(['mail.default' => $smtpMode]);
            if ($smtpMode == 'smtp') {
                if(sc_config('smtp_load_config') == 'database') {
                    $smtpHost = sc_config('smtp_host');
                    $smtpPort = sc_config('smtp_port');
                    $smtpSecurity = sc_config('smtp_security');
                    $smtpUser = sc_config('smtp_user');
                    $smtpPassword = sc_config('smtp_password');
                    config(['mail.mailers.smtp.host' => $smtpHost]);
                    config(['mail.mailers.smtp.port' => $smtpPort]);
                    config(['mail.mailers.smtp.encryption' => $smtpSecurity]);
                    config(['mail.mailers.smtp.username' => $smtpUser]);
                    config(['mail.mailers.smtp.password' => $smtpPassword]);
                }
            }

            config(
                ['mail.from' =>
                    [
                        'address' => sc_store('email'),
                        'name' => sc_store('title'),
                    ],
                ]
            );
            //email

            // Time zone
            config(['app.timezone' => (sc_config('SITE_TIMEZONE') ?? config('app.timezone'))]);
            // End time zone

            //Debug mode
            config(['app.debug' => env('APP_DEBUG') ? true : ((sc_config('APP_DEBUG') === 'on') ? true : false)]);
            //End debug mode

            //Share variable for view
            view()->share('languages', sc_language_all());
            view()->share('currencies', sc_currency_all());
            view()->share('blocksContent', sc_block_content());
            view()->share('layoutsUrl', sc_link());
            view()->share('templatePath', 'templates.' . sc_store('template'));
            view()->share('templateFile', 'templates/' . sc_store('template'));
            //variable model
            view()->share('modelProduct', (new ShopProduct));
            view()->share('modelCategory', (new ShopCategory));
            view()->share('modelBanner', (new ShopBanner));
            view()->share('modelBrand', (new ShopBrand));
            view()->share('modelSupplier', (new ShopSupplier));
            view()->share('modelNews', (new ShopNews));
            view()->share('modelPage', (new ShopPage));
    }

    /**
     * The application's route middleware.
     *
     * @var array
     */
    protected $routeMiddleware = [
        'localization' => \App\Http\Middleware\Localization::class,
        'currency' => \App\Http\Middleware\Currency::class,
    ];

    /**
     * Register the route middleware.
     *
     * @return void
     */
    protected function registerRouteMiddleware()
    {
        // register route middleware.
        foreach ($this->routeMiddleware as $key => $middleware) {
            app('router')->aliasMiddleware($key, $middleware);
        }
    }
}
