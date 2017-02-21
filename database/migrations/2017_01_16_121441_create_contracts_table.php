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
          $table->integer('area_id')->unsigned()->nullable();
          $table->integer('shipment_count');
          $table->string('term');
          $table->text('term_desc');
          $table->datetime('date_from');
          $table->datetime('date_to');
          $table->char('status', 1);
          $table->timestamps();

          $table->foreign('order_id')->references('id')->on('orders')->onDelete('restrict');
          $table->foreign('area_id')->references('id')->on('areas')->onDelete('restrict');
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
          $table->string('fc'); //floating crane
          $table->datetime('laycan_start');
          $table->datetime('eta'); //estimated time of arrival
          $table->datetime('loaded');
          $table->datetime('etd'); //estimated time of departure
          $table->datetime('laycan_end');
          $table->integer('volume');
          $table->integer('demurrage_rate');
          $table->integer('loading_rate');
          $table->integer('price');
          $table->datetime('bl_date'); //bill of lading
          $table->integer('cargo_bl'); //cargo bill of lading
          $table->char('status', 1);

          $table->timestamps();

          $table->foreign('contract_id')->references('id')->on('contracts')->onDelete('restrict');
          $table->foreign('supplier_id')->references('id')->on('companies')->onDelete('restrict');
          $table->foreign('customer_id')->references('id')->on('companies')->onDelete('restrict');
          $table->foreign('product_id')->references('id')->on('products')->onDelete('restrict');
          $table->foreign('surveyor_id')->references('id')->on('companies')->onDelete('restrict');
      });

      Schema::create('shipment_history', function (Blueprint $table) {
          $table->increments('id');
          $table->integer('shipment_id')->unsigned();
          $table->integer('user_id')->unsigned();
          $table->integer('contract_id')->unsigned();
          $table->integer('supplier_id')->unsigned();
          $table->integer('customer_id')->unsigned();
          $table->integer('product_id')->unsigned();
          $table->integer('surveyor_id')->unsigned();
          $table->string('shipment_no');
          $table->string('vessel');
          $table->string('fc'); //floating crane
          $table->datetime('laycan_start');
          $table->datetime('eta'); //estimated time of arrival
          $table->datetime('loaded');
          $table->datetime('etd'); //estimated time of departure
          $table->datetime('laycan_end');
          $table->integer('volume');
          $table->integer('demurrage_rate');
          $table->integer('loading_rate');
          $table->integer('price');
          $table->datetime('bl_date'); //bill of lading
          $table->integer('cargo_bl'); //cargo bill of lading
          $table->char('status', 1);
          $table->timestamps();

          $table->foreign('shipment_id')->references('id')->on('shipments')->onDelete('restrict');
          $table->foreign('user_id')->references('id')->on('users')->onDelete('restrict');
          $table->foreign('contract_id')->references('id')->on('contracts')->onDelete('restrict');
          $table->foreign('supplier_id')->references('id')->on('companies')->onDelete('restrict');
          $table->foreign('customer_id')->references('id')->on('companies')->onDelete('restrict');
          $table->foreign('product_id')->references('id')->on('products')->onDelete('restrict');
          $table->foreign('surveyor_id')->references('id')->on('companies')->onDelete('restrict');
      });

      Schema::create('shipment_log', function (Blueprint $table) {
          $table->integer('shipment_id')->unsigned();
          $table->integer('user_id')->unsigned();
          $table->string('stowage_plan')->nullable();
          $table->integer('cargo_supply')->nullable(); //cargo supply
          $table->integer('cargo_on_board')->nullable();
          $table->text('remark')->nullable();
          $table->string('shipment_status')->nullable(); // loading , unloading , loaded , unloaded , not started
          $table->timestamps();

          $table->foreign('shipment_id')->references('id')->on('shipments')->onDelete('restrict');
          $table->foreign('user_id')->references('id')->on('users')->onDelete('restrict');
      });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('shipment_log');
        Schema::dropIfExists('shipment_history');
        Schema::dropIfExists('shipments');
        Schema::dropIfExists('contracts');
    }
}
