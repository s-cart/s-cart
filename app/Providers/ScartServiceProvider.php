<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

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
        if(!file_exists(public_path('install.php'))) {
            foreach (glob(app_path() . '/Plugins/*/*/Provider.php') as $filename) {
                require_once $filename;
            }
            if(sc_config()) {
                $this->bootScart();
            }
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
            config(['mail.driver' => $smtpMode]);
            if ($smtpMode == 'smtp') {
                if(sc_config('smtp_load_config') == 'database') {
                    $smtpHost = sc_config('smtp_host');
                    $smtpPort = sc_config('smtp_port');
                    $smtpSecurity = sc_config('smtp_security');
                    $smtpUser = sc_config('smtp_user');
                    $smtpPassword = sc_config('smtp_password');
                    config(['mail.host' => $smtpHost]);
                    config(['mail.port' => $smtpPort]);
                    config(['mail.encryption' => $smtpSecurity]);
                    config(['mail.username' => $smtpUser]);
                    config(['mail.password' => $smtpPassword]);
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
