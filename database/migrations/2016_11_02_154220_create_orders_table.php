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
            $table->string('index_name')->nullable();
            $table->string('index_provider')->nullable();
            $table->decimal('price', 20, 10)->nullable();
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
            $table->string('reason')->nullable();
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
            $table->string('reason')->nullable();
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

        Schema::create('currencies', function (Blueprint $table) {
            $table->char('id',3)->primary();
            $table->string('value');
            $table->timestamps();
        });

        Schema::create('exchange_rates', function (Blueprint $table) {
            $table->increments('id');
            $table->char('buy',3);
            $table->char('sell',3);
            $table->decimal('value', 20, 10);
            $table->boolean('in_use');
            $table->timestamps();

            $table->foreign('buy')->references('id')->on('currencies');
            $table->foreign('sell')->references('id')->on('currencies');
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
            $table->decimal('base_price', 20, 10);
            $table->char('deal_currency_id',3);
            $table->decimal('deal_price', 20, 10);
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
            $table->char('base_currency_id',3);
            $table->decimal('base_price', 20, 10);
            $table->char('deal_currency_id',3);
            $table->decimal('deal_price', 20, 10);
            $table->decimal('exchange_rate', 20, 10);
            $table->string('trading_term');
            $table->string('payment_term');
            $table->text('notes')->nullable();
            $table->timestamps();

            $table->foreign('order_detail_id')->references('id')->on('order_details')->onDelete('cascade');
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
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
        Schema::dropIfExists('exchange_rates');
        Schema::dropIfExists('currencies');
        Schema::dropIfExists('order_details');
        Schema::dropIfExists('order_users');
        Schema::dropIfExists('order_approvals');
        Schema::dropIfExists('order_approval_logs');
        Schema::dropIfExists('orders');
    }
}
