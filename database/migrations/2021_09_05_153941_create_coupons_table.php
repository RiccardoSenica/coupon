<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCouponsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('coupons', function (Blueprint $table) {
            $table->id();
            $table->timestamps();

            $table->unsignedBigInteger('brand_id');
            $table->unsignedBigInteger('coupon_order_id');
            $table->unsignedBigInteger('user_id')->nullable();
            $table->string('code')->unique();
            $table->timestamp('collected_at')->nullable();

            $table->foreign('user_id')->references('id')->on('users');

            $table->index('id');
            $table->index('code');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('coupons');
    }
}
