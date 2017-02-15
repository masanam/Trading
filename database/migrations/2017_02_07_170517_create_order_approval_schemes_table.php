<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateOrderApprovalSchemesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //role
        Schema::create('order_approval_schemes', function (Blueprint $table) {
            $table->increments('id');
            $table->string('order_approval_scheme_name');
            // $table->integer('buy_area_id')->unsigned()->nullable();
            $table->integer('sell_area_id')->unsigned()->nullable();
            // $table->integer('min_buy_value');
            // $table->integer('max_buy_value');
            // $table->integer('min_sell_value');
            // $table->integer('max_sell_value');
            $table->timestamps();

            $table->foreign('sell_area_id')->references('id')->on('areas')->onDelete('restrict');
        });

        Schema::create('order_approval_scheme_sequences', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('order_approval_scheme_id')->unsigned();
            $table->integer('sequence')->unsigned();
            $table->integer('role_id')->unsigned();
            $table->char('approval_scheme', 1); // [a] AND, [o] OR, [integer] number of approval, [s] direct supervisor
            $table->timestamps();

            $table->unique(['order_approval_scheme_id', 'sequence'], 'orderapprovalseq_primary');
            $table->foreign('order_approval_scheme_id')->references('id')->on('order_approval_schemes')->onDelete('restrict');
            $table->foreign('role_id')->references('id')->on('roles')->onDelete('restrict');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('order_approval_scheme_sequences');
        Schema::dropIfExists('order_approval_schemes');
    }
}
