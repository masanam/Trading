<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSellOrderTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sell_order', function (Blueprint $table) {
            $table->increments('id');

            $table->integer('user_id');

            $table->integer('seller_id')->unsigned();

            $table->date('order_date');
            $table->date('order_deadline');
            $table->date('ready_date');
            $table->date('expired_date');

            $table->decimal('latitude', 10, 8)->nullable();
            $table->decimal('longitude', 11, 8)->nullable();
            $table->string('address');
            $table->string('city');
            $table->string('country');
            $table->integer('port_distance')->nullable();
            $table->integer('port_id')->nullable();
            $table->string('port_name')->nullable();
            $table->string('port_status')->nullable();
            $table->integer('port_daily_rate')->nullable();
            $table->integer('port_draft_height')->nullable();
            $table->decimal('port_latitude', 10, 8)->nullable();
            $table->decimal('port_longitude', 11, 8)->nullable();
            
            $table->string('product_name')->nullable();
            $table->integer('product_id')->nullable();

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

            $table->integer('volume');
            $table->integer('min_price');
            $table->string('trading_term')->nullable();
            $table->string('payment_terms')->nullable();
            $table->longText('commercial_term');
            $table->longText('penalty_desc');
            $table->char('order_status', 1); // open(o), progress(p), finish(f), cancel(c) 
            $table->char('progress_status', 1)->nullable();
            
            $table->timestamps();
        });

        Schema::table('sell_order', function (Blueprint $table) {
            $table->foreign('seller_id')->references('id')->on('sellers')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('sell_order');
    }
}
