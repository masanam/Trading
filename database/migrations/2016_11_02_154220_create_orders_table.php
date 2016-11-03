<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateOrdersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('user_id');
            $table->char('status', 1);
            $table->timestamps();
        });

        Schema::create('order_approvals', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('order_id')->unsigned();
            $table->integer('user_id')->unsigned();
            $table->char('status', 1); // A = Approved ; R = Reject
            $table->timestamps();

            $table->foreign('order_id')->references('id')->on('orders')->onDelete('cascade');
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
        });

        Schema::create('order_details', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('order_id')->unsigned();
            $table->integer('orderable_id')->unsigned();
            $table->string('orderable_type');
            $table->integer('price');
            $table->integer('volume');
            $table->timestamps();

            $table->foreign('order_id')->references('id')->on('orders')->onDelete('cascade');
        });

        Schema::create('order_negotiations', function (Blueprint $table) {
            $table->integer('order_detail_id')->unsigned();
            $table->integer('user_id')->unsigned();
            $table->integer('old_volume');
            $table->integer('old_price');
            $table->integer('new_volume');
            $table->integer('new_price');
            $table->text('notes');
            $table->timestamps();

            $table->foreign('order_detail_id')->references('id')->on('order_details')->onDelete('cascade');
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('orders');
        Schema::drop('order_approval');
        Schema::drop('detail_order');
        Schema::drop('detail_order_negotiation');
    }
}
