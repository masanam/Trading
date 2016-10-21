<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSellDealApprovalTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sell_deal_approval', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('sell_deal_id')->unsigned();
            $table->integer('user_id')->unsigned();

            $table->integer('approver_id')->nullable();

            $table->char('status', 1); // A = Approved ; R = Reject

            $table->timestamps();
        });

        Schema::table('sell_deal_approval', function (Blueprint $table) {
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('sell_deal_id')->references('id')->on('sell_deal')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('sell_deal_approval');
    }
}
