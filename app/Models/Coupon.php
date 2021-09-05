<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Coupon extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'brand_id',
        'coupon_order_id',
        'user_id',
        'code',
        'collected_at'
    ];

    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */
    protected $hidden = [
        //
    ];

    /**
    * Return the related CouponOrder object.
    *
    * @var CouponOrder
    */
    public function couponOrder()
    {
        return $this->belongsTo(CouponOrder::class, 'coupon_order_id');
    }

    /**
    * Return the related User object.
    *
    * @var User
    */
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
