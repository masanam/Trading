<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateBuyersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('buyers', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('user_id');
            $table->string('company_name');
            $table->boolean('is_trader');
            $table->boolean('is_affiliated');
            $table->string('phone');
            $table->string('email');
            $table->string('web')->nullable();;
            $table->string('address');
            $table->string('city');
            $table->string('country');
            $table->decimal('latitude', 10, 8)->nullable();;
            $table->decimal('longitude', 11, 8)->nullable(); ;
            $table->string('industry'); //cement, powerplant, pulp paper, general
            $table->integer('annual_demand');
            $table->string('preferred_trading_term');
            $table->string('preferred_payment_term');
            $table->text('description');
            $table->char('status', 1); // A = Active , X = Deleted
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
        Schema::drop('buyers');
    }
}
