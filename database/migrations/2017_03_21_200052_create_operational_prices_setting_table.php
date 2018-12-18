<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateOperationalPricesSettingTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('operational_price', function (Blueprint $table) {
            $table->increments('id');

            $table->string('name');
            $table->string('province');            
            $table->Integer('price');
            $table->timestamp('last_updated');
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
        Schema::dropIfExists('operational_price');        
    }
}
