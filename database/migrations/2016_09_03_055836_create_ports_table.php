<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePortsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ports', function (Blueprint $table) {
            $table->increments('id');
            $table->string('port_name');
            $table->string('owner');
            $table->boolean('is_private');
            $table->string('location');
            $table->integer('size')->unsigned();
            $table->integer('river_capacity')->nullable();
            $table->decimal('latitude', 10, 8);
            $table->decimal('longitude', 11, 8);
            $table->integer('anchorage_distance')->unsigned();
            $table->boolean('has_conveyor');
            $table->boolean('has_crusher');
            $table->boolean('has_blending');
            $table->integer('draft_height')->unsigned();
            $table->integer('daily_discharge_rate')->unsigned()->nullable();
            $table->char('status', 1)->nullable();
            
            $table->timestamps();
        });

        Schema::create('buyer_port', function (Blueprint $table) {
            $table->integer('port_id')->unsigned();
            $table->integer('buyer_id')->unsigned();
            
            $table->foreign('port_id')->references('id')->on('ports')->onDelete('cascade');
            $table->foreign('buyer_id')->references('id')->on('buyers')->onDelete('cascade');
            $table->primary(array('port_id', 'buyer_id'));
        });

        Schema::create('port_seller', function (Blueprint $table) {
            $table->integer('port_id')->unsigned();
            $table->integer('seller_id')->unsigned();

            $table->foreign('port_id')->references('id')->on('ports')->onDelete('cascade');
            $table->foreign('seller_id')->references('id')->on('sellers')->onDelete('cascade');
            $table->primary(array('port_id', 'seller_id'));
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('port_seller');
        Schema::dropIfExists('buyer_port');
        Schema::dropIfExists('ports');
    }
}
