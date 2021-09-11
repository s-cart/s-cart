<?php

namespace App\Listeners;

use Illuminate\Auth\Events\Login;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Cart;

class ProcessLogin
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
     * @param  Login  $event
     * @return void
     */
    public function handle(Login $event)
    {
        $user = $event->user;
        //Process sync cart data and session
        $userId = $user->id;
        $cartDB = \SCart\Core\Library\ShoppingCart\CartModel::where('identifier', $userId)
            ->where('store_id', config('app.storeId'))
            ->get()->keyBy('instance');
        if ($cartDB) {
            foreach ($cartDB as $instance => $cartInstance) {
                $content = json_decode($cartInstance->content, true);
                if ($content) {
                    foreach ($content as $key => $dataItem) {
                        Cart::instance($instance)->add($dataItem);
                    }
                }
            }
        }
        //End process sync cart
    }
}
