<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateInvoicesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('invoices', function (Blueprint $table) {
            $table->integer('shipment_id')->unsigned()->primary();
            $table->text('price_calculation');
            $table->text('tonnage_calculation');
            $table->char('base_currency_id',3);
            $table->decimal('base_price', 20, 10);
            $table->decimal('final_base_price', 20, 10);
            $table->char('deal_currency_id',3);
            $table->decimal('deal_price', 20, 10);
            $table->decimal('final_deal_price', 20, 10);
            $table->decimal('exchange_rate', 20, 10);
            $table->char('status',1);

            $table->foreign('shipment_id')->references('id')->on('shipments')->onDelete('restrict');
            $table->timestamps();
        });

        Schema::create('contract_calculations', function (Blueprint $table) {
            $table->integer('contract_id')->unsigned()->primary();
            $table->text('price_calculation');
            $table->text('tonnage_calculation');


            $table->foreign('contract_id')->references('id')->on('contracts')->onDelete('restrict');
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
        Schema::dropIfExists('invoices');
        Schema::dropIfExists('contract_calculations');
    }
}
