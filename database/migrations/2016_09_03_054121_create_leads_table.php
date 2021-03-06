<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateLeadsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('leads', function (Blueprint $table) {
            $table->increments('id');

            $table->integer('user_id');

            $table->integer('company_id')->unsigned();

            $table->date('order_date')->nullable();
            $table->date('order_expired')->nullable();
            $table->date('laycan_start')->nullable();
            $table->date('laycan_end')->nullable();

            $table->integer('factory_id')->nullable(); //weak relation tempat dikirim
            $table->integer('concession_id')->nullable(); //weak relation tempat dikirim
            $table->string('address')->nullable();
            $table->string('city')->nullable();
            $table->string('country')->nullable();
            $table->decimal('latitude', 10, 8)->nullable();
            $table->decimal('longitude', 11, 8)->nullable();
            $table->integer('port_distance')->nullable();
            $table->integer('port_id')->nullable();
            $table->string('port_name')->nullable();
            $table->string('port_status')->nullable();
            $table->integer('port_daily_rate')->nullable();
            $table->integer('port_draft_height')->nullable();
            $table->decimal('port_latitude', 10, 8)->nullable();
            $table->decimal('port_longitude', 11, 8)->nullable();

            $table->string('product_name')->nullable();
            $table->string('typical_quality')->nullable();
            $table->integer('product_id')->nullable();

            $table->decimal('gcv_arb_min', 7,2)->nullable(); //gross calorific value, as received basis
            $table->decimal('gcv_arb_max', 7,2)->nullable();
            $table->string('gcv_arb_reject')->nullable();
            $table->string('gcv_arb_bonus')->nullable();
            $table->decimal('gcv_adb_min', 7,2)->nullable(); //gross calorific value, air dried basis
            $table->decimal('gcv_adb_max', 7,2)->nullable();
            $table->string('gcv_adb_reject')->nullable();
            $table->string('gcv_adb_bonus')->nullable();
            $table->decimal('ncv_min', 7,2)->nullable(); //nett calorific value
            $table->decimal('ncv_max', 7,2)->nullable();
            $table->string('ncv_reject')->nullable();
            $table->string('ncv_bonus')->nullable();
            $table->decimal('ash_min', 5,2)->nullable(); //ash
            $table->decimal('ash_max', 5,2)->nullable();
            $table->string('ash_reject')->nullable();
            $table->string('ash_bonus')->nullable();
            $table->decimal('ts_min', 5,2)->nullable(); //total solid
            $table->decimal('ts_max', 5,2)->nullable();
            $table->string('ts_reject')->nullable();
            $table->string('ts_bonus')->nullable();
            $table->decimal('tm_min', 5,2)->nullable(); //total moisture
            $table->decimal('tm_max', 5,2)->nullable();
            $table->string('tm_reject')->nullable();
            $table->string('tm_bonus')->nullable();
            $table->decimal('im_min', 5,2)->nullable(); //inherent moisture
            $table->decimal('im_max', 5,2)->nullable();
            $table->string('im_reject')->nullable();
            $table->string('im_bonus')->nullable();
            $table->decimal('fc_min', 5,2)->nullable(); //Fixed Carbon
            $table->decimal('fc_max', 5,2)->nullable();
            $table->string('fc_reject')->nullable();
            $table->string('fc_bonus')->nullable();
            $table->decimal('vm_min', 5,2)->nullable(); //volatile matter
            $table->decimal('vm_max', 5,2)->nullable();
            $table->string('vm_reject')->nullable();
            $table->string('vm_bonus')->nullable();
            $table->decimal('hgi_min', 7,2)->nullable(); //hardness
            $table->decimal('hgi_max', 7,2)->nullable();
            $table->string('hgi_reject')->nullable();
            $table->string('hgi_bonus')->nullable();
            $table->decimal('size_min', 7,2)->nullable(); //size/piece
            $table->decimal('size_max', 7,2)->nullable();
            $table->string('size_reject')->nullable();
            $table->string('size_bonus')->nullable();
            $table->decimal('fe2o3_min', 7,2)->nullable(); //size/piece
            $table->decimal('fe2o3_max', 7,2)->nullable();
            $table->string('fe2o3_reject')->nullable(); //size/piece
            $table->string('fe2o3_bonus')->nullable();
            $table->decimal('aft_min', 7,2)->nullable(); //size/piece
            $table->decimal('aft_max', 7,2)->nullable();
            $table->string('aft_reject')->nullable(); //size/piece
            $table->string('aft_bonus')->nullable();
            $table->decimal('na2o_min', 7,2)->nullable(); //size/piece
            $table->decimal('na2o_max', 7,2)->nullable();
            $table->string('na2o_reject')->nullable(); //size/piece
            $table->string('na2o_bonus')->nullable();

            $table->char('pricing_scheme',1)->nullable();
            $table->decimal('volume', 11,2)->nullable();
            $table->decimal('price', 20, 10)->nullable();
            $table->longText('price_remarks')->nullable();
            $table->char('currency',3);
            $table->string('carrier_type')->nullable(); // not specified, gear, gearless, gear & gearless
            $table->string('trading_term')->nullable();
            $table->string('trading_term_detail')->nullable();
            $table->string('payment_term')->nullable();
            $table->string('payment_term_detail')->nullable();
            $table->longText('remarks')->nullable();
            $table->char('lead_type', 1)->nullable(); // buy(b), sell(s)
            $table->char('order_status', 1); // customer(0), factory(1), product(2), port(3), summary(4), lead(l), staged(s), partial(p), deleted(x), verified(v)
            $table->char('progress_status', 1)->nullable();

            $table->timestamps();

            $table->foreign('company_id')->references('id')->on('companies')->onDelete('restrict');
        });

        Schema::table('leads', function ($table) {
            DB::statement('ALTER TABLE leads ADD COLUMN polygon geometry;');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('leads');
    }
}
