<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateBuyDealChatTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('buy_deal_chat', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('trader_id')->unsigned();
            $table->integer('approver_id')->unsigned();
            $table->integer('buy_deal_id')->unsigned();
            $table->string('message');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('buy_deal_chat');
    }
}
