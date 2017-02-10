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
            $table->integer('user_id')->unsigned();
            $table->integer('index_id')->unsigned()->nullable();
            $table->boolean('in_house')->default(false);
            $table->string('cancel_reason')->nullable();
            $table->string('request_reason')->nullable();
            $table->string('finalize_reason')->nullable();
            
            $table->integer('approval_sequence')->unsigned()->default(0);
            $table->char('status', 1);
            $table->timestamps();

            $table->foreign('user_id')->references('id')->on('users')->onDelete('restrict');
            $table->foreign('index_id')->references('id')->on('index')->onDelete('restrict');
        });

        Schema::create('order_approvals', function (Blueprint $table) {
            $table->integer('order_id')->unsigned();
            $table->integer('user_id')->unsigned();
            $table->string('approval_token')->index();
            $table->char('status', 1); // A = Approved ; R = Reject
            $table->timestamps();

            $table->foreign('order_id')->references('id')->on('orders')->onDelete('restrict');
            $table->foreign('user_id')->references('id')->on('users')->onDelete('restrict');
            $table->unique(['order_id', 'user_id']);
        });

        //intinya sama dengan si order_approval, tapi bedanya ini cuma log doang
        Schema::create('order_approval_logs', function (Blueprint $table) {
            $table->integer('order_id')->unsigned();
            $table->integer('user_id')->unsigned();
            $table->char('status', 1); // A = Approved ; R = Reject
            $table->timestamps();

            $table->foreign('order_id')->references('id')->on('orders')->onDelete('restrict');
            $table->foreign('user_id')->references('id')->on('users')->onDelete('restrict');
        });

        Schema::create('order_users', function (Blueprint $table) {
            $table->integer('order_id')->unsigned();
            $table->integer('user_id')->unsigned();
            $table->string('role'); // A = Approved ; R = Reject

            $table->foreign('order_id')->references('id')->on('orders')->onDelete('restrict');
            $table->foreign('user_id')->references('id')->on('users')->onDelete('restrict');
            $table->unique(['order_id', 'user_id']);
        });

        Schema::create('currency', function (Blueprint $table) {
            $table->char('id',3);
            $table->integer('value');
        });

        Schema::create('exchange_rates', function (Blueprint $table) {
            $table->char('buy',3);
            $table->char('sell',3);
            $table->decimal('value', 20, 10);
            $table->timestamps();
        });

        Schema::create('order_details', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('order_id')->unsigned();
            $table->integer('lead_id')->unsigned();
            $table->integer('price');
            $table->integer('volume');
            $table->string('trading_term');
            $table->string('payment_term');
            $table->char('base_currency_id',3);
            $table->integer('base_price');
            $table->char('deal_currency_id',3);
            $table->integer('deal_price');
            $table->decimal('exchange_rate', 20, 10);
            $table->timestamps();

            $table->foreign('order_id')->references('id')->on('orders')->onDelete('restrict');
            $table->foreign('lead_id')->references('id')->on('leads')->onDelete('restrict');
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

            $table->foreign('order_detail_id')->references('id')->on('order_details')->onDelete('restrict');
            $table->foreign('user_id')->references('id')->on('users')->onDelete('restrict');
        });

        Schema::create('order_additional_costs', function (Blueprint $table) {
            $table->integer('company_id')->unsigned();
            $table->integer('order_id')->unsigned();
            $table->string('label');
            $table->decimal('cost', 15, 3);

            $table->foreign('order_id')->references('id')->on('orders')->onDelete('restrict');
            $table->foreign('company_id')->references('id')->on('companies')->onDelete('restrict');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('order_additional_costs');
        Schema::dropIfExists('order_negotiations');
        Schema::dropIfExists('currency');
        Schema::dropIfExists('order_details');
        Schema::dropIfExists('exchange_rates');
        Schema::dropIfExists('order_users');
        Schema::dropIfExists('order_approvals');
        Schema::dropIfExists('order_approval_logs');
        Schema::dropIfExists('orders');
    }
}
