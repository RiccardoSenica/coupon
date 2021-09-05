<?php

namespace App\Listeners;

use App\Events\CouponsGenerationEvent;
use App\Models\Coupon;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class CouponsGenerationListener implements ShouldQueue
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
     * @param  \App\Events\CouponsGenerationEvent  $event
     * @return void
     */
    public function handle(CouponsGenerationEvent $event)
    {
        for($i = 0; $i < $event->couponOrder->quantity; $i++){
            Coupon::create([
                'brand_id' => $event->couponOrder->brand_id,
                'coupon_order_id' => $event->couponOrder->id,
                'code' => uniqid($event->couponOrder->prefix, true)
            ]);
        }
    }
}
