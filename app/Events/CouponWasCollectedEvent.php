<?php

namespace App\Events;

use App\Events\Event;
use App\Models\Coupon;
use Illuminate\Queue\SerializesModels;

class CouponWasCollectedEvent extends Event
{
    use SerializesModels;

    /**
    * The coupon referrer.
    *
    * @var \App\Models\Coupon
    */
    public $coupon;

    /**
     * Create a new event instance.
     *
     * @param  Coupon  $coupon
     * @return void
     */
    public function __construct(Coupon $coupon)
    {
        $this->coupon = $coupon;
    }

    public function broadcastOn()
    {
        return ['brand-'.$this->coupon->brand_id];
    }

    public function broadcastWith()
    {
        return [
            'coupon' => $this->coupon,
            'user' => $this->coupon->user
        ];
    }
}
