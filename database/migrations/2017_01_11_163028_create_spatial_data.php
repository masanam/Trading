<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSpatialData extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
		Schema::create('spatial_data', function (Blueprint $table){
			$table->increments('id');
            
			$table->string('restricted_area')->nullable();
			$table->string('type')->nullable();
			$table->string('desc')->nullable();
            $table->integer('created_by')->unsigned()->nullable();
            $table->char('status',1)->nullable();
            $table->timestamps();

            $table->foreign('created_by')->references('id')->on('users')->onDelete('cascade');
		});
        
		Schema::table('spatial_data', function ($table) {
			DB::statement('ALTER TABLE spatial_data ADD COLUMN polygon geometry;');
		});
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('spatial_data');
    }
}

