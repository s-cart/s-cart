<?php

namespace App\Listeners;

use SCart\Core\Events\CustomerCreated;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class ProcessCustomerCreated
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  CustomerCreated  $event
     * @return void
     */
    public function handle(CustomerCreated $event)
    {
        // $customer = $event->customer;
        // \Log::info($customer);
    }
}
