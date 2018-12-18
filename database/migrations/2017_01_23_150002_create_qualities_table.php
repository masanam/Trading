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
            $table->integer('shipment_id')->nullable();
            $table->integer('contract_id')->nullable();
            // $table->integer('lead_id')->unsigned();
            $table->char('status', 1);
            $table->char('type', 1);
            $table->timestamps();

            // $table->unique('shipment_id');
            // $table->foreign('lead_id')->references('id')->on('leads')->onDelete('cascade');
        });

        Schema::create('quality_details', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('quality_id')->unsigned();
            $table->decimal('value', 7,2);
            $table->integer('quality_metrics_id');
            $table->timestamps();

            $table->foreign('quality_id')->references('id')->on('qualities')->onDelete('cascade');
            $table->unique(['quality_id', 'quality_metrics_id']);
        });

        Schema::create('quality_metrics', function (Blueprint $table) {
            $table->increments('id');
            $table->string('quality');
            $table->string('metric');
            $table->timestamps();

            $table->unique(['quality', 'metric']);
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
