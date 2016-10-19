<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateConcessionTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('concession', function (Blueprint $table) {
            $table->increments('id');
            $table->string('concession_name');
            $table->integer('seller_id')->unsigned()->nullable();
            $table->string('owner')->nullable();
            $table->string('address');
            $table->string('city');
            $table->string('country');
            $table->decimal('latitude', 10, 8);
            $table->decimal('longitude', 11, 8);
            $table->longText('polygon');
            $table->integer('size')->nullable();
            $table->decimal('stripping_ratio', 4, 2)->nullable();
            $table->integer('resource')->nullable();
            $table->integer('reserves')->nullable();
            $table->integer('contracted_volume')->nullable();
            $table->integer('remaining_volume')->nullable();
            $table->integer('annual_production');
            $table->string('hauling_road_name')->nullable(); //nama jalanannya
            $table->integer('stockpile_capacity'); //kapasitas 
            $table->integer('stockpile_coverage');
            $table->integer('stockpile_distance');
            $table->integer('port_id')->nullable();
            $table->decimal('port_distance', 6, 2);
            $table->string('license_type');
            $table->date('license_expiry_date')->nullable();
            $table->char('status', 1); // A = Active , X = Deleted
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
        Schema::drop('concession');
    }
}
