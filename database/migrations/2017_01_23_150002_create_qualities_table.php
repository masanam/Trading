<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateQualitiesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('qualities', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('shipment_id')->unsigned();  
            $table->integer('lead_id')->unsigned();
            $table->char('status', 1);
            $table->char('type', 1);
            $table->timestamps();

            $table->foreign('shipment_id')->references('id')->on('shipments')->onDelete('cascade');
            $table->foreign('lead_id')->references('id')->on('leads')->onDelete('cascade');
        });

        Schema::create('quality_details', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('quality_id')->unsigned();
            $table->integer('value');
            $table->string('quality');
            $table->timestamps();

            $table->foreign('quality_id')->references('id')->on('qualities')->onDelete('cascade');
        });

        Schema::create('quality_metrics', function (Blueprint $table) {
            $table->increments('id');
            $table->string('quality');
            $table->string('metric');
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
        Schema::dropIfExists('quality_metrics');
        Schema::dropIfExists('quality_details');
        Schema::dropIfExists('qualities');
    }
}