<?php

namespace App\Listeners;

use App\Events\OrderCreated;
use App\Helpers\CurrentBranchId;
use App\Models\Cart;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class EmptyCart
{
    /**
     * Create the event listener.
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     */
    public function handle(OrderCreated $event): void
    {
        Cart::where('cookie_id', $event->cartId)
            ->where('restaurant_id', $event->order->restaurant_id)
            ->where('branch_id', $event->order->branch_id)
            ->delete();
    }
}
