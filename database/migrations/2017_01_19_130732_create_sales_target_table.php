<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSalesTargetTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sales_target', function (Blueprint $table) {
            // $table->increments('id');
            $table->integer('product_id')->unsigned();           
            $table->integer('month')->unsigned();
            $table->integer('year')->unsigned();
            $table->integer('value');
            $table->char('status', 1);
            $table->timestamps();

            $table->foreign('product_id')->references('id')->on('products')->onDelete('restrict');
            $table->primary(['product_id', 'month', 'year']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('sales_target');
    }
}
