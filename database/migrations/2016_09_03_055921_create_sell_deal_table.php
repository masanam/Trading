<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSellDealTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sell_deal', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('sell_order_id')->unsigned();
            $table->integer('user_id')->unsigned();
            $table->integer('deal_id')->nullable();

            $table->char('status');
            
            $table->timestamps();
        });

        Schema::table('sell_deal', function (Blueprint $table) {
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
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
        Schema::drop('sell_deal');
    }
}
