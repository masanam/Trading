<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateContractsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
      Schema::create('contracts', function (Blueprint $table) {
          $table->increments('id');
          $table->string('contract_no');
          $table->integer('order_id')->unsigned();
          $table->integer('shipment_count');
          $table->string('term');
          $table->text('term_desc');
          $table->datetime('date_from');
          $table->datetime('date_to');
          $table->char('status', 1);
          $table->timestamps();

          $table->foreign('order_id')->references('id')->on('orders')->onDelete('cascade');
      });

      Schema::create('shipments', function (Blueprint $table) {
          $table->increments('id');
          $table->integer('contract_id')->unsigned();
          $table->integer('supplier_id')->unsigned();
          $table->integer('customer_id')->unsigned();
          $table->integer('product_id')->unsigned();
          $table->integer('surveyor_id')->unsigned();
          $table->string('shipment_no');
          $table->string('vessel');
          $table->datetime('laycan_start');
          $table->datetime('laycan_end');
          $table->datetime('eta');
          $table->datetime('etd');
          $table->integer('volume');
          $table->integer('demurrage_rate');
          $table->integer('loading_rate');
          $table->integer('price');
          $table->char('status', 1);
          $table->timestamps();

          $table->foreign('contract_id')->references('id')->on('contracts')->onDelete('cascade');
          $table->foreign('supplier_id')->references('id')->on('companies')->onDelete('cascade');
          $table->foreign('customer_id')->references('id')->on('companies')->onDelete('cascade');
          $table->foreign('product_id')->references('id')->on('products')->onDelete('cascade');
          $table->foreign('surveyor_id')->references('id')->on('companies')->onDelete('cascade');
      });

      Schema::create('shipment_history', function (Blueprint $table) {
          $table->increments('id');
          $table->integer('shipment_id')->unsigned();
          $table->integer('surveyor_id')->unsigned();
          $table->string('vessel');
          $table->datetime('laycan_start');
          $table->datetime('laycan_end');
          $table->datetime('eta');
          $table->datetime('etd');
          $table->integer('volume');
          $table->integer('demurrage_rate');
          $table->integer('loading_rate');
          $table->integer('price');
          $table->char('status', 1);
          $table->timestamps();

          $table->foreign('shipment_id')->references('id')->on('shipments')->onDelete('cascade');
          $table->foreign('surveyor_id')->references('id')->on('companies')->onDelete('cascade');
      });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('shipment_history');
        Schema::drop('shipments');
        Schema::drop('contracts');
    }
}
