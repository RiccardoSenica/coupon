<?php

namespace App\Listeners;

use App\Events\CouponWasCollectedEvent;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class BrandNotificationListener
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
     * @param  \App\Events\CouponWasCollectedEvent  $event
     * @return void
     */
    public function handle(CouponWasCollectedEvent $event)
    {
        //
    }
}
