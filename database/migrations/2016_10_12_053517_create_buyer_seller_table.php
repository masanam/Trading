<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateBuyerSellerTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('buyer_seller', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('seller_id')->nullable();
            $table->integer('buyer_id')->nullable();
            $table->string('notes');
            $table->string('is_facilitated');
            $table->string('status');
            $table->date('updated_at');
            $table->date('created_at');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('buyer_seller');
    }
}
