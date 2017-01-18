<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTonnagesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tonnages', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('product_id')->unsigned();           
            $table->integer('month');
            $table->integer('year');
            $table->integer('value');
            $table->dateTime('updated_at');
            $table->dateTime('created_at');
            $table->char('status', 1);

            $table->foreign('product_id')->references('id')->on('products')->onDelete('cascade');
        });

        Schema::create('tonnages_history', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('product_id')->unsigned();
            $table->integer('month');
            $table->integer('year');
            $table->integer('value');
            $table->integer('updated_by')->unsigned();
            $table->dateTime('updated_at');
            $table->char('status', 1);
            $table->dateTime('created_at');            
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('tonnages');
        Schema::drop('tonnages_history');
    }
}
