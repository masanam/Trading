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
            $table->string('employee_id')->nullable();
            $table->string('manager_id')->nullable();

            $table->datetime('last_login')->nullable();
            
            $table->char('status', 1); // A = Active , X = Deleted
            $table->rememberToken();
            $table->timestamps();
        });

        Schema::create('password_resets', function (Blueprint $table) {
            $table->string('email')->index();
            $table->string('token')->index();
            $table->timestamp('created_at')->nullable();
        });

        Schema::create('login_user', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('user_id');
            $table->integer('num_login');
            $table->timestamps();
        });
        
        Schema::create('activities', function (Blueprint $table) {
            $table->increments('id');

            $table->integer('user_id');
            $table->string('action');
            $table->string('table')->nullable();
            $table->string('entity_id')->nullable();

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
        Schema::dropIfExists('activities');
        Schema::dropIfExists('login_user');
        Schema::dropIfExists('password_resets');
        Schema::dropIfExists('users');
    }
}
