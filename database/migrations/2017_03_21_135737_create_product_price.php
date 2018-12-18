<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProductPrice extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('product_prices', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('product_id')->unsigned();
            $table->decimal('barging',7,2)->nullable();
            $table->decimal('discount',7,2)->nullable();
            $table->decimal('price',7,2)->nullable();
            $table->date('date')->nullable();
            $table->char('status',1)->nullable();
            $table->timestamp('created_at')->nullable();
            $table->timestamp('updated_at')->nullable();

        });

        Schema::create('settings', function (Blueprint $table) {
            $table->increments('id');
            $table->string('application');
            $table->string('variable');
            $table->string('value');
            $table->timestamp('created_at')->nullable();
            $table->timestamp('updated_at')->nullable();
        });

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {

       Schema::dropIfExists('settings');
       Schema::dropIfExists('product_prices');

    }
}
