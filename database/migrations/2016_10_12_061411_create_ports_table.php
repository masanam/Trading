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
            $table->increments('port_id');
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
            
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('ports');
    }
}
