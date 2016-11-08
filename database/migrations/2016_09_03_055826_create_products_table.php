<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProductsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('products', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('seller_id')->nullable();
            $table->integer('buyer_id')->nullable();
            $table->integer('concession_id')->nullable();
			$table->string('product_name');
            $table->string('typical_quality')->nullable();
            $table->integer('gcv_arb_min')->nullable(); //gross calorific value, as received basis
            $table->integer('gcv_arb_max')->nullable();
            $table->integer('gcv_adb_min')->nullable(); //gross calorific value, air dried basis
            $table->integer('gcv_adb_max')->nullable();
            $table->integer('ncv_min')->nullable(); //nett calorific value
            $table->integer('ncv_max')->nullable();
            $table->decimal('ash_min', 5,2)->nullable(); //ash
            $table->decimal('ash_max', 5,2)->nullable();
            $table->decimal('ts_min', 5,2)->nullable(); //total solid
            $table->decimal('ts_max', 5,2)->nullable();
            $table->decimal('tm_min', 5,2)->nullable(); //total moisture
            $table->decimal('tm_max', 5,2)->nullable();
            $table->decimal('im_min', 5,2)->nullable(); //inherent moisture
            $table->decimal('im_max', 5,2)->nullable();
            $table->decimal('fc_min', 5,2)->nullable(); //Fixed Carbon
            $table->decimal('fc_max', 5,2)->nullable();
            $table->decimal('vm_min', 5,2)->nullable(); //volatile matter
            $table->decimal('vm_max', 5,2)->nullable();
            $table->integer('hgi_min')->nullable(); //hardness
            $table->integer('hgi_max')->nullable();
            $table->integer('size_min')->nullable(); //size/piece
            $table->integer('size_max')->nullable();
            $table->integer('fe2o3_min')->nullable(); //size/piece
            $table->integer('fe2o3_max')->nullable();
            $table->integer('aft_min')->nullable(); //size/piece
            $table->integer('aft_max')->nullable();

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
        Schema::drop('products');
    }
}
