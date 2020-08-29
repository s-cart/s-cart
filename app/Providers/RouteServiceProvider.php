<?php

namespace App\Providers;

use Illuminate\Foundation\Support\Providers\RouteServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Route;

class RouteServiceProvider extends ServiceProvider
{
    /**
     * This namespace is applied to your controller routes.
     *
     * In addition, it is set as the URL generator's root namespace.
     *
     * @var string
     */
    protected $namespace = 'App\Http\Controllers';

    /**
     * Define your route model bindings, pattern filters, etc.
     *
     * @return void
     */
    public function boot()
    {
        parent::boot();
    }

    /**
     * Define the routes for the application.
     *
     * @return void
     */
    public function map()
    {
        $this->mapApiRoutes();
        if(!file_exists(public_path('install.php'))) {
            $this->mapPluginsRoutes();
            $this->mapFrontRoutes();
            $this->mapWebRoutes();
        }
    }

    /**
     * Define the "web" routes for the application.
     *
     * These routes all receive session state, CSRF protection, etc.
     *
     * @return void
     */
    protected function mapWebRoutes()
    {
        Route::middleware(['web', 'localization', 'currency', 'checkdomain'])
            ->namespace($this->namespace)
            ->group(base_path('routes/web.php'));
    }

    /**
     * Define the "api" routes for the application.
     *
     * These routes are typically stateless.
     *
     * @return void
     */
    protected function mapApiRoutes()
    {
        Route::prefix('api')
            ->middleware('api')
            ->namespace('App\Api\Controllers')
            ->group(base_path('routes/api.php'));
    }

    /**
     * Route Plugins
     */
    protected function mapPluginsRoutes()
    {
        Route::middleware(['web', 'localization', 'currency', 'checkdomain'])
            ->group(function () {
                foreach (glob(app_path() . '/Plugins/*/*/Route.php') as $filename) {
                    require_once $filename;
                }       
            });
    }

    /**
     * Route Front
     */
    protected function mapFrontRoutes()
    {
        $suffix = sc_config('SUFFIX_URL')??'';
        Route::middleware(['web', 'localization', 'currency', 'checkdomain'])
            ->namespace('App\Http\Controllers')
            ->group(function () use($suffix){
                foreach (glob(base_path() . '/routes/component/*.php') as $filename) {
                    require_once $filename;
                }       
            });
    }

}
