<?php

namespace App\Providers;

use Illuminate\Auth\Events\Registered;
use Illuminate\Auth\Listeners\SendEmailVerificationNotification;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Event;

class EventServiceProvider extends ServiceProvider
{
    /**
     * The event listener mappings for the application.
     *
     * @var array
     */
    protected $listen = [
        Registered::class => [
            SendEmailVerificationNotification::class,
        ],
        \SCart\Core\Events\OrderCreated::class => [
            \App\Listeners\ProcessOrderCreated::class,
        ],
        \SCart\Core\Events\OrderSuccess::class => [
            \App\Listeners\ProcessOrderSuccess::class,
        ],
        \SCart\Core\Events\CustomerCreated::class => [
            \App\Listeners\ProcessCustomerCreated::class,
        ],
        \SCart\Core\Events\OrderUpdateStatus::class => [
            \App\Listeners\ProcessOrderUpdateStatus::class,
        ],
        \Illuminate\Auth\Events\Login::class => [
            \App\Listeners\ProcessLogin::class,
        ],
    ];

    /**
     * Register any events for your application.
     *
     * @return void
     */
    public function boot()
    {
        parent::boot();

        //
    }
}
