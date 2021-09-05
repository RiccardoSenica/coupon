<?php

namespace App\Events;

use App\Events\Event;
use App\Models\CouponOrder;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\SerializesModels;

class CouponsGenerationEvent extends Event implements ShouldQueue
{
    use SerializesModels;

    /**
     * The coupon order referrer.
     *
     * @var \App\Models\CouponOrder
     */
    public $couponOrder;

    /**
     * Create a new event instance.
     *
     * @param  CouponOrder  $couponOrder
     * @return void
     */
    public function __construct(CouponOrder $couponOrder)
    {
        $this->couponOrder = $couponOrder;
    }
}
