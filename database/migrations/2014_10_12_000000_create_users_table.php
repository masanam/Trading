<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->increments('id');

            // $table->integer('manager_id')->nullable();
            
            $table->string('name');
            $table->string('title');
            
            $table->string('image');
            $table->string('email')->unique();
            $table->string('phone');
            $table->string('password');

            $table->string('role');
            
            $table->char('status', 1); // A = Active , X = Deleted
            $table->rememberToken();
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
        Schema::drop('users');
    }
}
