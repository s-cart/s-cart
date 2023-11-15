<?php

namespace App\Listeners;

use SCart\Core\Events\OrderSuccess;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class ProcessOrderSuccess
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
     * @param  OrderSuccess  $event
     * @return void
     */
    public function handle(OrderSuccess $event)
    {
        $order = $event->order;
        // \Log::error($order);
        //Add notice (from SC 8.1)
        sc_notice_add('sc_order_success', $order->id);
    }
}
