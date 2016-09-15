<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateBuyDealTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('buy_deal', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('buy_order_id')->unsigned();
            $table->integer('user_id')->unsigned();
            $table->integer('deal_id');
            
            $table->timestamps();
        });

        Schema::table('buy_deal', function (Blueprint $table) {
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
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
        Schema::drop('buy_deal');
    }
}
