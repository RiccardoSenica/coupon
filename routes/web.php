<?php

/** @var \Laravel\Lumen\Routing\Router $router */

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It is a breeze. Simply tell Lumen the URIs it should respond to
| and give it the Closure to call when that URI is requested.
|
*/


$router->group(['middleware' => 'jwt'], function() use ($router) {
    /*
    |   Route for a brand to generate a coupon codes
    */
    $router->post('/generate-coupons', ['uses' => 'CouponController@generateCoupons']);

    /*
    |   Route for the user to retrieve a coupon code
    */
    $router->get('/get-coupon', ['uses' => 'CouponController@getCoupon']);
});

