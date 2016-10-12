<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSellersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sellers', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('user_id');
            $table->string('company_name');
            $table->boolean('is_trade');
            $table->boolean('is_affiliated');
            $table->string('hauling_road');
            $table->integer('remaining_volume');
            $table->string('license_type');
            $table->date('license_expiration_date');
            $table->string('preferred_trading_term');
            $table->string('preferred_payment_term');
            $table->string('purchasing_countries');
            $table->string('phone');
            $table->string('email');
            $table->string('web');
            $table->string('industry');
            $table->string('city');
            $table->string('address');
            $table->decimal('latitude', 10, 8);
            $table->decimal('longitude', 11, 8);
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
        Schema::drop('sellers');
    }
}
