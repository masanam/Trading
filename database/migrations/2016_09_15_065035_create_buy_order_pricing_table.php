<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateBuyOrderPricingTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('buy_order_pricing', function (Blueprint $table) {
            $table->increments('id');

            $table->integer('buy_order_id')->unsigned();

            $table->string('pricing_type');
            $table->integer('price');

            $table->timestamps();
        });

        Schema::table('buy_order_pricing', function (Blueprint $table) {
            $table->foreign('buy_order_id')->references('id')->on('buy_order')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('buy_order_pricing');
    }
}
