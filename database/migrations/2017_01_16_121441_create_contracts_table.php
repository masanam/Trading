<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateContractsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
      Schema::create('contracts', function (Blueprint $table) {
        $table->increments('id');
        $table->string('contract_no')->nullable();
        $table->string('contract_date')->nullable();
        $table->integer('order_id')->nullable()->unsigned();
        $table->integer('area_id')->nullable()->unsigned();
        $table->integer('company_id')->nullable()->unsigned();
        $table->integer('product_id')->nullable()->unsigned();
        $table->integer('tonnage')->nullable();
        $table->decimal('price', 20, 10)->nullable();
        $table->integer('shipment_count')->nullable();
        $table->string('term')->nullable();
        $table->text('term_desc')->nullable();
        $table->char('currency', 3)->nullable();
        $table->datetime('date_from')->nullable();
        $table->datetime('date_to')->nullable();
        $table->char('label', 1); // t = target || a = actual
        $table->char('status', 1);
        $table->timestamps();

        $table->foreign('order_id')->references('id')->on('orders')->onDelete('restrict');
        $table->foreign('area_id')->references('id')->on('areas')->onDelete('restrict');
        $table->foreign('company_id')->references('id')->on('companies')->onDelete('restrict');
      });

      Schema::create('shipments', function (Blueprint $table) {
          $table->increments('id');
          $table->integer('contract_id')->unsigned();
          $table->integer('supplier_id')->nullable();
          $table->integer('customer_id')->unsigned();
          $table->integer('product_variant_id')->unsigned();
          $table->integer('surveyor_id')->unsigned();
          $table->string('shipment_no');
          $table->integer('vessel_id')->unsigned();
          $table->integer('loader_id')->unsigned();
          $table->integer('shipping_agent_id')->unsigned();          
          //$table->datetime('laycan_start');
          $table->datetime('laycan_start_plan');
          $table->datetime('laycan_start_actual')->nullable();
          $table->datetime('eta')->nullable(); //estimated time of arrival
          $table->datetime('loaded');
          $table->datetime('etd')->nullable(); //estimated time of departure
          $table->datetime('etc'); //estimated time of complete
          //$table->datetime('laycan_end');
          $table->datetime('laycan_end_plan');
          $table->datetime('laycan_end_actual')->nullable();
          $table->integer('volume');
          $table->integer('demurrage_rate');
          $table->integer('loading_rate');
          $table->char('currency', 3);
          $table->decimal('price', 20, 10)->nullable();
          $table->datetime('bl_date')->nullable(); //bill of lading
          $table->integer('cargo_bl')->nullable(); //cargo bill of lading
          $table->boolean('adv_royalty'); // 0 = never request advance royalty payment yet ; 1 = already request advance royalty payment
          $table->char('shipment_status', 1)->nullable();
          $table->char('status', 1);
          $table->integer('stowage_plan')->nullable();
          $table->integer('cargo_status')->nullable();
          $table->integer('cargo_supply')->nullable();
          $table->text('remark')->nullable();

          $table->timestamps();

          $table->foreign('contract_id')->references('id')->on('contracts')->onDelete('restrict');
          $table->foreign('customer_id')->references('id')->on('companies')->onDelete('restrict');
          $table->foreign('product_variant_id')->references('id')->on('product_variants')->onDelete('restrict');
          $table->foreign('surveyor_id')->references('id')->on('companies')->onDelete('restrict');
      });

      Schema::create('shipment_history', function (Blueprint $table) {
          $table->increments('id');
          $table->integer('shipment_id')->unsigned();
          $table->integer('user_id')->unsigned();
          $table->integer('contract_id')->unsigned();
          $table->integer('supplier_id')->nullable();
          $table->integer('customer_id')->unsigned();
          $table->integer('product_variant_id')->unsigned();
          $table->integer('surveyor_id')->unsigned();
          $table->integer('loader_id')->unsigned();
          $table->string('shipment_no');
          $table->string('vessel');
          $table->datetime('laycan_start_actual')->nullable();
          $table->datetime('laycan_start_plan');
          $table->datetime('eta')->nullable(); //estimated time of arrival
          $table->datetime('loaded');
          $table->datetime('etd')->nullable(); //estimated time of departure
          $table->datetime('etc'); //estimated time of complete
          $table->datetime('laycan_end_actual')->nullable();
          $table->datetime('laycan_end_plan');
          $table->integer('volume');
          $table->integer('demurrage_rate');
          $table->integer('loading_rate');
          $table->integer('price');
          $table->datetime('bl_date')->nullable(); //bill of lading
          $table->integer('cargo_bl')->nullable(); //cargo bill of lading          
          $table->text('remark')->nullable();
          $table->char('status', 1);

          $table->timestamps();

          $table->foreign('shipment_id')->references('id')->on('shipments')->onDelete('restrict');
          $table->foreign('user_id')->references('id')->on('users')->onDelete('restrict');
          $table->foreign('contract_id')->references('id')->on('contracts')->onDelete('restrict');
          $table->foreign('customer_id')->references('id')->on('companies')->onDelete('restrict');
          $table->foreign('product_variant_id')->references('id')->on('product_variants')->onDelete('restrict');
          $table->foreign('surveyor_id')->references('id')->on('companies')->onDelete('restrict');
      });

      Schema::create('shipment_log', function (Blueprint $table) {
          $table->integer('shipment_id')->unsigned();
          $table->integer('user_id')->unsigned();
          $table->integer('stowage_plan')->nullable();
          $table->integer('cargo_status')->nullable();
          $table->integer('cargo_supply')->nullable(); //cargo supply      
          $table->text('remark')->nullable();
          $table->string('shipment_status')->nullable(); // loading , unloading , loaded , unloaded , not started
          $table->timestamps();

          $table->foreign('shipment_id')->references('id')->on('shipments')->onDelete('restrict');
          $table->foreign('user_id')->references('id')->on('users')->onDelete('restrict');
      });

      Schema::create('shipment_plans', function (Blueprint $table) {
        $table->increments('id');
        $table->integer('contract_id')->unsigned();
        $table->integer('product_variant_id')->unsigned();
        $table->datetime('laycan_start');
        $table->datetime('laycan_end');
        $table->decimal('volume', 20, 5);
        $table->char('status', 1);

        $table->timestamps();

        $table->foreign('contract_id')->references('id')->on('contracts')->onDelete('restrict');
      });

      Schema::create('shipping_instructions', function (Blueprint $table) {
        //LC no --> get from document of shipment
        //vessel --> get from shipment
        //shipping agent --> get from shipment
        //notify party --> get from shipment
        //surveyor --> get from shipment
        //contract --> get from shipment

        $table->integer('shipment_id')->unsigned();
        $table->string('si_no')->nullable();
        $table->date('si_date')->nullable();
        $table->string('shipper_details')->nullable();
        $table->string('consignee')->nullable();
        $table->string('loading_port')->nullable();
        $table->string('destination_port')->nullable();
        $table->string('goods_desc')->nullable();
        $table->integer('qty')->nullable();
        $table->float('qty_tolerence', 5, 2)->nullable();
        $table->string('witness')->nullable();
        $table->string('lc_no')->nullable();
        $table->text('docs_berau')->nullable();
        $table->text('docs_shipping')->nullable();
        $table->text('docs_surveyor')->nullable();
        $table->string('analysis_method')->nullable();
        $table->string('sample_size')->nullable();
        $table->string('sample_weight')->nullable();
        $table->string('sample_address')->nullable();
        $table->char('status', 1);


        $table->timestamps();

        $table->foreign('shipment_id')->references('id')->on('shipments')->onDelete('cascade');
        $table->primary('shipment_id');
      });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('shipping_instructions');
        Schema::dropIfExists('shipment_plans');
        Schema::dropIfExists('shipment_log');
        Schema::dropIfExists('shipment_history');
        Schema::dropIfExists('shipments');
        Schema::dropIfExists('contracts');
    }
}
