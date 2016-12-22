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
            $table->boolean('in_house')->default(false);
            $table->string('cancel_reason')->nullable();
            $table->string('request_reason')->nullable();
            $table->string('finalize_reason')->nullable();
            $table->char('status', 1);
            $table->timestamps();
        });

        Schema::create('order_approvals', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('order_id')->unsigned();
            $table->integer('user_id')->unsigned();
            $table->string('approval_token')->index();
            $table->char('status', 1); // A = Approved ; R = Reject
            $table->timestamps();

            $table->foreign('order_id')->references('id')->on('orders')->onDelete('cascade');
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->unique(['order_id', 'user_id']);
        });

        Schema::create('order_users', function (Blueprint $table) {
            $table->integer('order_id')->unsigned();
            $table->integer('user_id')->unsigned();
            $table->string('role'); // A = Approved ; R = Reject

            $table->foreign('order_id')->references('id')->on('orders')->onDelete('cascade');
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->unique(['order_id', 'user_id']);
        });

        Schema::create('order_details', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('order_id')->unsigned();
            $table->integer('lead_id')->unsigned();
            $table->integer('price');
            $table->integer('volume');
            $table->string('trading_term');
            $table->string('payment_term');
            $table->timestamps();

            $table->foreign('order_id')->references('id')->on('orders')->onDelete('cascade');
            $table->foreign('lead_id')->references('id')->on('leads')->onDelete('cascade');
            $table->unique(['order_id', 'lead_id']);
        });

        Schema::create('order_negotiations', function (Blueprint $table) {
            $table->integer('order_detail_id')->unsigned();
            $table->integer('user_id')->unsigned();
            $table->integer('volume');
            $table->integer('price');
            $table->string('trading_term');
            $table->string('payment_term');
            $table->text('notes');
            $table->decimal('insurance_cost', 15, 3)->nullable();
            $table->decimal('interest_cost', 15, 3)->nullable();
            $table->decimal('surveyor_cost', 15, 3)->nullable();
            $table->decimal('others_cost', 15, 3)->nullable();
            $table->decimal('pit_to_port', 15, 3)->nullable();
            $table->decimal('transhipment', 15, 3)->nullable();
            $table->decimal('freight_cost', 15, 3)->nullable();
            $table->decimal('port_to_factory', 15, 3)->nullable();
            $table->timestamps();

            $table->foreign('order_detail_id')->references('id')->on('order_details')->onDelete('cascade');
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
        });

        Schema::create('order_additional_costs', function (Blueprint $table) {
            $table->integer('company_id')->unsigned();
            $table->integer('order_id')->unsigned();
            $table->string('label');
            $table->decimal('cost', 15, 3);

            $table->foreign('order_id')->references('id')->on('orders')->onDelete('cascade');
            $table->foreign('company_id')->references('id')->on('companies')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('order_additional_costs');
        Schema::drop('order_negotiations');
        Schema::drop('order_details');
        Schema::drop('order_users');
        Schema::drop('order_approvals');
        Schema::drop('orders');
    }
}
