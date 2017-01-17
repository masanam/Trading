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

          /* OTHER ELEMENTS GOES HERE */

          $table->char('status', 1);
          $table->timestamps();

          $table->foreign('contract_id')->references('id')->on('contracts')->onDelete('cascade');
      });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('shipments');
        Schema::drop('contracts');
    }
}
