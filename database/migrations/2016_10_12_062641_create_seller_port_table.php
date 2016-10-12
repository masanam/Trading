<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSellerPortTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('seller_port', function (Blueprint $table) {
            $table->increments('port_id');
            $table->integer('seller_id')->unsigned();
            $table->integer('distance');
            
            $table->timestamps();
        });

        Schema::table('seller_port', function (Blueprint $table) {
            $table->foreign('port_id')->references('port_id')->on('ports')->onDelete('cascade');
            $table->foreign('seller_id')->references('id')->on('sellers')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('seller_port');
    }
}
