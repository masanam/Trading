<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCostsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('calculation_types', function (Blueprint $table) {
            $table->increments('id');
            $table->string('cost_type');
        });

        Schema::create('cost_sections', function (Blueprint $table) {
            $table->increments('id');
            $table->string('section_name');

            $table->integer('calculation_id')->unsigned();

            $table->foreign('calculation_id')->references('id')->on('calculation_types')->onDelete('restrict');
        });

        Schema::create('cost_headers', function (Blueprint $table) {
            $table->increments('id');

            $table->integer('calculation_id')->unsigned();
            $table->integer('mining_license_id')->unsigned();
            $table->date('date_of_analysis')->nullable();
            $table->integer('profit_sharing')->nullable();
            $table->char('base_currency_id',3);            
            $table->char('deal_currency_id',3);            
            $table->decimal('exchange_rate', 20, 10);
            $table->foreign('calculation_id')->references('id')->on('calculation_types')->onDelete('restrict');
            $table->foreign('mining_license_id')->references('id')->on('mining_licenses')->onDelete('restrict');
        });

        Schema::create('cost_total', function (Blueprint $table) {
            $table->increments('id');

            $table->integer('header_id')->unsigned();
            $table->integer('total');
            $table->integer('cogs');
            $table->timestamps();

            $table->foreign('header_id')->references('id')->on('cost_headers')->onDelete('restrict');
        });

        Schema::create('cost_details', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('section_id')->unsigned();
            $table->integer('header_id')->unsigned();
            $table->integer('user_id');
            $table->string('desc');
            $table->decimal('base_value',20,10);
            $table->decimal('deal_value',20,10);
            $table->integer('quantity');
            $table->char('status', 1); // A = Active , X = Deleted
            $table->timestamps();

            // $table->timestamps();
            // $table->integer('preliminary_geo_survey');
            // $table->integer('due_diligence');
            // $table->integer('consultant_fee');
            // $table->integer('legal_permit');
            // $table->integer('acquisition_cost');
            // $table->integer('land_acquisition_clearing');
            // $table->integer('haul_road');
            // $table->integer('washing_plant');
            // $table->integer('stockpile_and_facility');
            // $table->integer('bridge');
            // $table->integer('port_facility');
            // $table->integer('camp_and_office');
            // $table->integer('production_equipment');
            // $table->integer('non_production_equipment');
            // $table->integer('fixtures_and_furnitures');
            // $table->integer('pre_operation_prep_cost');
            // $table->integer('over_burden_removal');
            // $table->integer('blasting');
            // $table->integer('coal_getting');
            // $table->integer('coal_hauling_to_rom');
            // $table->integer('stockpile_management');
            // $table->integer('coal_processing');
            // $table->integer('coal_hauling_to_port');
            // $table->integer('road_maintenance');
            // $table->integer('port_rehandling_and_bargeloading');
            // $table->integer('barging_and_stevedoring');
            // $table->integer('surveyor_and_coallabanalysis');
            // $table->integer('environment_and_rehabilitation');
            // $table->integer('government_royalty');
            // $table->integer('land_fee');
            // $table->integer('road_fee');
            // $table->integer('dana_taktis');
            // $table->integer('community_fee');
            // $table->integer('local_gov_income');
            // $table->integer('management_fee');
            // $table->integer('other_and_interest');
            // $table->integer('overhead_and_other');
            // $table->integer('amortization_and_depreciation');


            $table->foreign('section_id')->references('id')->on('cost_sections')->onDelete('restrict');
            $table->foreign('header_id')->references('id')->on('cost_headers')->onDelete('restrict');
        });

        Schema::create('equations', function (Blueprint $table) {
            $table->increments('id');
            $table->string('equation_name');
            $table->string('equation_desc');
            $table->string('equation');
        });

        Schema::create('constants_setting', function (Blueprint $table) {
            $table->increments('id');
            $table->string('constant_name');
            $table->integer('constant_value');
            $table->timestamp('last_updated');
            $table->string('used_in');
            $table->datetime('date');

            $table->char('status', 1); // A = Active ,H = History, X = Deleted

        });

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('constants_setting');
        Schema::dropIfExists('equations');
        Schema::dropIfExists('cost_details');
        Schema::dropIfExists('cost_total');
        Schema::dropIfExists('cost_headers');
        Schema::dropIfExists('cost_sections');
        Schema::dropIfExists('calculation_types');

    }

}
