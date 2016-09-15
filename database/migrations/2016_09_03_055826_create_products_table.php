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

            $table->integer('seller_id');
            $table->integer('buyer_id');

            $table->string('commercial_term');

            $table->date('ready_date');
            $table->date('expired_date');

            $table->integer('gcv_arb_min')->nullable(); //gross calorific value, as received basis
            $table->integer('gcv_arb_max')->nullable();
            $table->integer('gcv_arb_reject')->nullable();
            $table->integer('gcv_arb_bonus')->nullable();
            $table->integer('gcv_adb_min')->nullable(); //gross calorific value, air dried basis
            $table->integer('gcv_adb_max')->nullable();
            $table->integer('gcv_adb_reject')->nullable();
            $table->integer('gcv_adb_bonus')->nullable();
            $table->integer('ncv_min')->nullable(); //nett calorific value
            $table->integer('ncv_max')->nullable();
            $table->integer('ncv_reject')->nullable();
            $table->integer('ncv_bonus')->nullable();
            $table->decimal('ash_min', 5,2)->nullable(); //ash
            $table->decimal('ash_max', 5,2)->nullable();
            $table->decimal('ash_reject', 5,2)->nullable();
            $table->decimal('ash_bonus', 5,2)->nullable();
            $table->decimal('ts_min', 5,2)->nullable(); //total solid
            $table->decimal('ts_max', 5,2)->nullable();
            $table->decimal('ts_reject', 5,2)->nullable();
            $table->decimal('ts_bonus', 5,2)->nullable();
            $table->decimal('tm_min', 5,2)->nullable(); //total moisture
            $table->decimal('tm_max', 5,2)->nullable();
            $table->decimal('tm_reject', 5,2)->nullable();
            $table->decimal('tm_bonus', 5,2)->nullable();
            $table->decimal('im_min', 5,2)->nullable(); //inherent moisture
            $table->decimal('im_max', 5,2)->nullable();
            $table->decimal('im_reject', 5,2)->nullable();
            $table->decimal('im_bonus', 5,2)->nullable();
            $table->decimal('fc_min', 5,2)->nullable(); //Fixed Carbon
            $table->decimal('fc_max', 5,2)->nullable();
            $table->decimal('fc_reject', 5,2)->nullable();
            $table->decimal('fc_bonus', 5,2)->nullable();
            $table->decimal('vm_min', 5,2)->nullable(); //volatile matter
            $table->decimal('vm_max', 5,2)->nullable();
            $table->decimal('vm_reject', 5,2)->nullable();
            $table->decimal('vm_bonus', 5,2)->nullable();
            $table->integer('hgi_min')->nullable(); //hardness
            $table->integer('hgi_max')->nullable();
            $table->integer('hgi_reject')->nullable();
            $table->integer('hgi_bonus')->nullable();
            $table->integer('size_min')->nullable(); //size/piece
            $table->integer('size_max')->nullable();
            $table->integer('size_reject')->nullable();
            $table->integer('size_bonus')->nullable();

            $table->decimal('volume', 20, 2);

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
