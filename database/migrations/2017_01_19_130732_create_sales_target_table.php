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
            $table->integer('product_variant_id')->unsigned();           
            $table->integer('month')->unsigned();
            $table->integer('year')->unsigned();
            $table->integer('tonnage');
            $table->integer('price');
            $table->char('status', 1);
            $table->timestamps();

            $table->foreign('product_variant_id')->references('id')->on('product_variants')->onDelete('restrict');
            $table->primary(['product_variant_id', 'month', 'year']);
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
