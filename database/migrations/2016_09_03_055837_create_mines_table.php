<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMinesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('mines', function (Blueprint $table) {
            $table->increments('id');

            $table->integer('seller_id')->unsigned();
            
            $table->decimal('latitude', 10, 8);
            $table->decimal('longitude', 11, 8);

            $table->string('mine_name');

            $table->integer('mineable_reserve');
            $table->decimal('stripping_ratio', 4, 2);
            
            $table->string('road_accessibility');
            $table->decimal('port_distance', 6, 2);
            $table->integer('road_capacity');
            $table->string('port_name');
            $table->string('river_capacity');
            
            $table->string('license_type');
            $table->date('license_expired_date');

            $table->char('status', 1); // A = Active , X = Deleted

            $table->timestamps();
        });

        Schema::table('mines', function (Blueprint $table) {
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
        Schema::drop('mines');
    }
}
