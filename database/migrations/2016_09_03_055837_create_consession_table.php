<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateConsessionTable extends Migration
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
            $table->string('owner');
            $table->integer('seller_id')->nullable();
            $table->string('city');
            $table->string('address');
            $table->decimal('latitude', 10, 8);
            $table->decimal('longitude', 11, 8);
            $table->integer('size');
            $table->integer('resource');
            $table->integer('reserves');
            $table->integer('contracted_volume');
            $table->integer('annual_production');
            $table->integer('stockpile_distance');
            $table->decimal('stripping_ratio', 4, 2);
            $table->string('road_accessibility');
            $table->decimal('port_distance', 6, 2);
            $table->integer('road_capacity');
            $table->string('port_name');
            $table->string('river_capacity');
            $table->string('license_type');
            $table->date('license_expired_date');
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
