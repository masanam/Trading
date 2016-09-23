<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateBuyDealApprovalTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('buy_deal_approval', function (Blueprint $table) {
            $table->integer('buy_deal_id')->unsigned();
            $table->integer('user_id')->unsigned();

            $table->string('approver');

            $table->char('status', 1); // A = Approved ; R = Reject

            $table->timestamps();
        });

        Schema::table('buy_deal_approval', function (Blueprint $table) {
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('buy_deal_id')->references('id')->on('buy_deal')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('buy_deal_approval');
    }
}
