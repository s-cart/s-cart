<?php

namespace App\Listeners;

use SCart\Core\Events\OrderCreated;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class ProcessOrderCreated
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
     * @param  OrderCreated  $event
     * @return void
     */
    public function handle(OrderCreated $event)
    {
        $order = $event->order;
        // \Log::info($order);
    }
}
