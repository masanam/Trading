<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateBuyerPortTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('buyer_port', function (Blueprint $table) {
            $table->increments('port_id');
            $table->integer('buyer_id')->unsigned();
            $table->integer('distance');
            
            $table->timestamps();
        });

        Schema::table('buyer_port', function (Blueprint $table) {
            $table->foreign('port_id')->references('port_id')->on('ports')->onDelete('cascade');
            $table->foreign('buyer_id')->references('id')->on('buyers')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('buyer_port');
    }
}
