<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateVesselsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
      Schema::create('vessels', function (Blueprint $table) {
        $table->increments('id');
        $table->string('vessel_name');
        $table->string('flag')->nullable();
        $table->string('build')->nullable();
        $table->decimal('deadweight_tonnage', 10, 2)->nullable();
        $table->decimal('length_overall', 10, 2)->nullable();
        $table->decimal('beam', 10, 2)->nullable();
        $table->string('containers')->nullable();
        $table->char('status', 1);
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
        Schema::dropIfExists('vessels');
    }
}
