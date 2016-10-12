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
            $table->string('location');
            $table->boolean('is_private');
            $table->integer('size')->unsigned();
            $table->decimal('latitude', 10, 8);
            $table->decimal('longitude', 11, 8);
            $table->boolean('has_conveyor');
            $table->boolean('has_crusher');
            $table->boolean('has_blending');
            $table->integer('draft')->unsigned();
            $table->integer('anchorage_distance')->unsigned();
            
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
