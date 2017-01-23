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
        Schema::create('areas', function (Blueprint $table){
            $table->increments('id');
            $table->string('description')->nullable();
        });
        
        Schema::create('companies', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('user_id')->unsigned();
            $table->integer('area_id')->unsigned();
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
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('area_id')->references('id')->on('areas')->onDelete('cascade');
        });

        Schema::create('contacts', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('user_id')->unsigned()->nullable();
            $table->integer('company_id')->unsigned()->nullable();
            $table->string('name');
            $table->string('phone');
            $table->string('email');
            
            $table->char('status', 1);
            $table->timestamps();
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
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
            // $table->integer('mining_license_id')->unsigned()->nullable();
            $table->timestamps();
            $table->foreign('company_id')->references('id')->on('companies')->onDelete('cascade');
        });
        Schema::table('concessions', function ($table) {
            DB::statement('ALTER TABLE concessions ADD COLUMN polygon geometry;');
        });
        
        Schema::create('products', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('company_id')->unsigned();
            $table->integer('concession_id')->unsigned()->nullable();
            $table->string('product_name');
            $table->string('typical_quality');
            $table->integer('pit_to_port')->nullable(); // integer ini
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
            $table->foreign('concession_id')->references('id')->on('concessions')->onDelete('cascade');
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
            $table->foreign('company_id')->references('id')->on('companies')->onDelete('cascade');
        });
        
        
        /*
         * kamal 2017-01-12 16:50
         * added atribut river
         */
        Schema::create('ports', function (Blueprint $table) {
            $table->increments('id');
            $table->string('port_name');
            $table->string('owner');
            $table->boolean('is_private');
            $table->string('location');
            $table->integer('size')->unsigned();
            $table->string('river')->nullable();
            $table->integer('river_capacity')->nullable();
            $table->integer('open_sea_distance')->nullable(); // 
            $table->decimal('latitude', 10, 8);
            $table->decimal('longitude', 11, 8);
            $table->integer('anchorage_distance')->nullable();
            $table->boolean('has_conveyor')->nullable()->default(0);
            $table->boolean('has_crusher')->nullable()->default(0);
            $table->boolean('has_blending')->nullable()->default(0);
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
        /*
         * Kamal 2017-01-12 16:40
         * Kamal 2017-01-17 13:00 ganti type data dll
         *
         * Tables untuk coalbizpedia baru
         * concession_files --> files yang dimiliki untuk konsesi ketika daftar
         * mining_license   --> ini IUP
         * spatial_data     --> data untuk apapun yang ada di map kecuali konsesi mining
         */
        Schema::create('concession_files', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('concession_id')->unsigned();
            $table->string('url');
            $table->foreign('concession_id')->references('id')->on('concessions')->onDelete('cascade');
        });
        Schema::create('mining_licenses', function (Blueprint $table) {
            $table->increments('id');
            $table->string('no')->nullable();
            $table->integer('company_id')->unsigned()->nullable(); //integer unsigned reference
            $table->integer('concession_id')->unsigned()->nullable();
            $table->integer('contact_id')->unsigned()->nullable();
            $table->string('source')->nullable();
            $table->string('type')->nullable();
            $table->date('expired')->nullable();
            $table->integer('total_area')->nullable();
            $table->boolean('overlap_other')->nullable(); 
            $table->string('overlap_other_desc')->nullable();
            $table->boolean('release_after')->nullable();
            $table->string('release_after_desc')->nullable();
            $table->boolean('already_production')->nullable();
            $table->string('already_production_desc')->nullable();
            $table->string('restricted_area')->nullable();
            $table->text('description')->nullable(); 
            $table->boolean('overlap_smg')->nullable();
            $table->string('overlap_smg_desc')->nullable();
            $table->boolean('produce_kp')->nullable();
            $table->string('produce_kp_desc')->nullable();
            $table->string('land_use')->nullable();
            $table->string('location')->nullable();
            $table->string('coal_bearing_formation')->nullable();
            $table->text('geological_description')->nullable();
            $table->string('geological_quality')->nullable();
            $table->string('geological_cv')->nullable();
            $table->string('geological_tm')->nullable();
            $table->string('geological_ts')->nullable();
            $table->string('geological_ash')->nullable();
            $table->boolean('geological_reserve')->nullable();
            $table->string('geological_stripping_ratio')->nullable();
            $table->text('notes')->nullable(); //notes dan description bedanya apa?
            $table->integer('created_by')->unsigned()->nullable(); // ini reference ke user
            $table->integer('checked_by')->unsigned()->nullable(); // ini reference ke user
            $table->date('checked_at')->nullable();
            $table->integer('received_by')->unsigned()->nullable(); // ini reference ke user
            $table->date('received_at')->nullable();
            $table->char('status',1);
            $table->timestamps();

            //for advance search
            $table->boolean('troubled_bupati')->nullable();
            $table->boolean('operating')->nullable();
            $table->boolean('close_factory')->nullable();
            $table->boolean('close_iup')->nullable();
            $table->boolean('close_river')->nullable();
            $table->boolean('close_iup_other')->nullable();
            $table->boolean('located_mining')->nullable();
            $table->boolean('located_settlement')->nullable();
            $table->boolean('located_palm')->nullable();
            $table->boolean('located_farm')->nullable();
            $table->boolean('overlay_forest')->nullable();

            $table->foreign('company_id')->references('id')->on('companies')->onDelete('cascade');
            $table->foreign('created_by')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('checked_by')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('received_by')->references('id')->on('users')->onDelete('cascade');
        });
        Schema::table('mining_licenses', function ($table) {
            DB::statement('ALTER TABLE mining_licenses ADD COLUMN polygon geometry;');
        });
        Schema::create('mining_license_files', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('mining_license_id')->unsigned()->nullable();
            $table->string('url')->nullable();
            $table->integer('upload_by')->unsigned()->nullable(); //ini foreign key ke user, again, integer unsigned reference
            $table->timestamps(); 

            $table->foreign('mining_license_id')->references('id')->on('mining_licenses')->onDelete('cascade');
            $table->foreign('upload_by')->references('id')->on('users')->onDelete('cascade');
        });
     
    }
    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('mining_license_files');
        Schema::dropIfExists('mining_licenses');
        Schema::dropIfExists('concession_files');
        Schema::dropIfExists('company_port');
        Schema::dropIfExists('ports');
        Schema::dropIfExists('factories');
        Schema::dropIfExists('products');
        Schema::dropIfExists('concessions');
        Schema::dropIfExists('contacts');
        Schema::dropIfExists('areas');
        Schema::dropIfExists('companies');
    }
}