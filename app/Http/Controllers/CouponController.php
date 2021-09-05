<?php

namespace App\Http\Controllers;

use App\Events\CouponsGenerationEvent;
use App\Events\CouponWasCollectedEvent;
use App\Http\Resources\CouponResource;
use App\Models\Coupon;
use App\Models\CouponOrder;
use App\Models\User;
use Illuminate\Http\Request;

class CouponController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Retrieve a coupon code for the user, based on the selected brand, if available.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     *
     * @OA\Get(
     *     path="/get-coupon",
     *     operationId="/get-coupon",
     *     tags={"getCoupon"},
     *     security={ {"bearer": {} }},
     *     @OA\Parameter(
     *         name="brand_id",
     *         in="query",
     *         description="ID of the brand for which the coupon is requested.",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(
     *         response="200",
     *         description="Returns the coupon code",
     *     ),
     *     @OA\Response(
     *         response="401",
     *         description="Error: Not authenticated.",
     *         @OA\JsonContent(
     *              @OA\Property(property="message", type="string", example="Token expired.")
     *          )
     *     ),
     *     @OA\Response(
     *         response="403",
     *         description="Error: Not authorized.",
     *         @OA\JsonContent(
     *              @OA\Property(property="message", type="string", example="Not authorized.")
     *          )
     *     ),
     * )
     */
    public function getCoupon(Request $request){
        if($request->auth['role'] != 'customer'){
            return response()->json([
                'error' => 'Not authorized.'
            ], 403);
        }

        $data = $this->validate($request, [
            'brand_id' => 'required|numeric'
        ]);

        $user = User::find(['id', $request->auth['id']])->first();

        if(empty($user)){
            $user = User::create([
                'id' => $request->auth['id']
            ]);
        }

        $coupon = Coupon::where(['brand_id' => $data['brand_id'], 'user_id' => null])->first();

        if(empty($coupon)){
            return response()->json([
                'message' => 'No coupon found.'
            ], 200);
        }

        $coupon->user_id = $request->auth['id'];
        $coupon->collected_at = date("Y-m-d H:i:s");;
        $coupon->save();

        event(new CouponWasCollectedEvent($coupon));

        return new CouponResource($coupon);
    }

    /**
     * Generates coupon codes for a brand.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     *
     * @OA\Get(
     *     path="/generate-coupons",
     *     operationId="/generate-coupons",
     *     tags={"generateCoupons"},
     *     security={ {"bearer": {} }},
     *     @OA\Parameter(
     *         name="quantity",
     *         in="query",
     *         description="Quantity of coupons to be generated.",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Parameter(
     *         name="prefix",
     *         in="query",
     *         description="Prefix to be used in the coupon codes.",
     *         required=true,
     *         @OA\Schema(type="string")
     *     ),
     *     @OA\Response(
     *         response="200",
     *         description="Success.",
     *         @OA\JsonContent(
     *              @OA\Property(property="message", type="string", example="Coupon code(s) generation job sent.")
     *          )
     *     ),
     *     @OA\Response(
     *         response="401",
     *         description="Error: Not authenticated.",
     *         @OA\JsonContent(
     *              @OA\Property(property="message", type="string", example="Token expired.")
     *          )
     *     ),
     *     @OA\Response(
     *         response="403",
     *         description="Error: Not authorized.",
     *         @OA\JsonContent(
     *              @OA\Property(property="message", type="string", example="Not authorized.")
     *          )
     *     ),
     * )
     */
    public function generateCoupons(Request $request){
        if($request->auth['role'] != 'brand'){
            return response()->json([
                'error' => 'Not authorized.'
            ], 403);
        }

        $data = $this->validate($request, [
            'quantity' => 'required|numeric',
            'prefix' => 'sometimes|string'
        ]);

        $data['brand_id'] = $request->auth['id'];

        $couponOrder = CouponOrder::create($data);

        event(new CouponsGenerationEvent($couponOrder));

        return response()->json([
            'message' => 'Coupon code(s) generation job sent.'
        ], 200);
    }
}
