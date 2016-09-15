<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSellOrderPricingTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sell_order_pricing', function (Blueprint $table) {
            $table->increments('id');

            $table->integer('sell_order_id')->unsigned();

            $table->string('pricing_type');
            $table->integer('price');

            $table->timestamps();
        });

        Schema::table('sell_order_pricing', function (Blueprint $table) {
            $table->foreign('sell_order_id')->references('id')->on('sell_order')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('sell_order_pricing');
    }
}
