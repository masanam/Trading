<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCompaniesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('companies', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('user_id');
            $table->string('company_name');
            $table->boolean('is_affiliated');

            $table->string('phone');
            $table->string('email');
            $table->string('web')->nullable();;
            $table->string('address');
            $table->string('city');
            $table->string('country');
            $table->string('industry'); //cement, powerplant, pulp paper, general
            $table->integer('annual_demand')->nullable();
            $table->integer('annual_sales')->nullable();
            $table->string('preferred_trading_term')->nullable();
            $table->string('preferred_trading_term_detail')->nullable();
            $table->string('preferred_payment_term')->nullable();
            $table->string('preferred_payment_term_detail')->nullable();
            $table->string('purchasing_countries');
            $table->text('description');

            $table->char('company_type', 1); // b = buyer, s = seller, t = trader, v = vendor
            $table->char('status', 1); // A = Active , X = Deleted
            $table->timestamps();
        });

        Schema::create('contacts', function (Blueprint $table) {
            $table->increments('id');

            $table->integer('user_id')->nullable();
            $table->integer('company_id')->nullable();

            $table->string('name');
            $table->string('phone');
            $table->string('email');
            
            $table->char('status', 1);
            $table->timestamps();

            $table->foreign('company_id')->references('id')->on('companies')->onDelete('cascade');
        });


        Schema::create('products', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('company_id');
            $table->integer('concession_id')->nullable();
            $table->string('brand');
            $table->string('typical_quality');

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

            $table->foreign('company_id')->references('id')->on('companies')->onDelete('cascade');
        });

        Schema::create('concessions', function (Blueprint $table) {
            $table->increments('id');
            $table->string('concession_name');
            $table->integer('company_id')->unsigned()->nullable();
            $table->string('owner')->nullable();
            $table->string('address')->nullable();
            $table->string('city')->nullable();
            $table->string('country')->nullable();
            $table->decimal('latitude', 10, 8)->nullable();
            $table->decimal('longitude', 11, 8)->nullable();
            $table->longText('polygon')->nullable();
            $table->integer('size')->nullable();
            $table->decimal('stripping_ratio', 4, 2)->nullable();
            $table->integer('resource')->nullable();
            $table->integer('reserves')->nullable();
            $table->integer('contracted_volume')->nullable();
            $table->integer('remaining_volume')->nullable();
            $table->integer('annual_production')->nullable();
            $table->string('hauling_road_name')->nullable(); //nama jalanannya
            $table->integer('stockpile_capacity')->nullable(); //kapasitas 
            $table->integer('stockpile_coverage')->nullable();
            $table->integer('stockpile_distance')->nullable();
            $table->integer('port_id')->nullable();
            $table->decimal('port_distance', 6, 2)->nullable();
            $table->string('license_type')->nullable();
            $table->date('license_expiry_date')->nullable();
            $table->char('status', 1); // A = Active , X = Deleted
            $table->timestamps();
        });

        Schema::create('factories', function (Blueprint $table) {
            $table->increments('id');
            $table->string('factory_name');
            $table->integer('company_id')->unsigned()->nullable();
            $table->string('owner')->nullable();
            $table->string('address')->nullable();
            $table->string('city')->nullable();
            $table->string('country')->nullable();
            $table->decimal('latitude', 10, 8)->nullable();
            $table->decimal('longitude', 11, 8)->nullable();
            $table->integer('size')->unsigned()->nullable();
            $table->integer('consumption')->unsigned()->nullable();
            $table->integer('port_id')->nullable();
            $table->decimal('port_distance', 6, 2)->nullable();
            $table->char('status', 1); // A = Active , X = Deleted
            $table->timestamps();
        });
        
        Schema::create('ports', function (Blueprint $table) {
            $table->increments('id');
            $table->string('port_name');
            $table->string('owner');
            $table->boolean('is_private');
            $table->string('location');
            $table->integer('size')->unsigned();
            $table->integer('river_capacity')->nullable();
            $table->decimal('latitude', 10, 8);
            $table->decimal('longitude', 11, 8);
            $table->integer('anchorage_distance')->nullable();
            $table->boolean('has_conveyor');
            $table->boolean('has_crusher');
            $table->boolean('has_blending');
            $table->integer('draft_height')->unsigned();
            $table->integer('daily_discharge_rate')->unsigned()->nullable();
            $table->char('status', 1)->nullable();
            
            $table->timestamps();
        });

        Schema::create('company_port', function (Blueprint $table) {
            $table->integer('port_id')->unsigned();
            $table->integer('company_id')->unsigned();
            
            $table->foreign('port_id')->references('id')->on('ports')->onDelete('cascade');
            $table->foreign('company_id')->references('id')->on('companies')->onDelete('cascade');
            $table->primary(array('port_id', 'company_id'));
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('company_port');
        Schema::dropIfExists('ports');
        Schema::dropIfExists('factories');
        Schema::dropIfExists('concessions');
        Schema::dropIfExists('products');
        Schema::dropIfExists('contacts');
        Schema::dropIfExists('companies');
    }
}