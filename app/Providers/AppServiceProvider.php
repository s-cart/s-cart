<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Laravel\Passport\Passport;
use Illuminate\Pagination\Paginator;
class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    // public function boot()
    public function boot()
    {
        Paginator::useBootstrap();
        //If env is production, then disable debug mode
        if (config('app.env') === 'production') {
            config(['app.debug' => false]);
        }
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //Dont use migrate from library passport
        Passport::ignoreMigrations();
    }
}
