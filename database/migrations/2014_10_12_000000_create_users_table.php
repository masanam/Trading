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


        Schema::create('acting_users', function (Blueprint $table) {
            $table->integer('user_id')->unsigned();
            $table->integer('acting_as')->unsigned();
            $table->datetime('date_start')->nullable();
            $table->datetime('date_end')->nullable();
            
            $table->char('role', 1); // t = trade_approval
            $table->char('status', 1); // a = Active , x = Deleted

            $table->foreign('user_id')->references('id')->on('users')->onDelete('restrict');
            $table->foreign('acting_as')->references('id')->on('users')->onDelete('restrict');
        });

        Schema::create('roles', function (Blueprint $table) {
            $table->increments('id');
            $table->string('role');
            $table->timestamps();
        });

        Schema::create('user_role', function (Blueprint $table) {
            $table->integer('user_id');
            $table->integer('role_id');
            $table->timestamps();

            $table->unique(['user_id', 'role_id']);
        });

        Schema::create('password_resets', function (Blueprint $table) {
            $table->string('email')->index();
            $table->string('token')->index();
            $table->timestamp('created_at')->nullable();
        });

        Schema::create('login_user', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('user_id')->unsigned();
            $table->integer('num_login');
            $table->timestamps();

            $table->foreign('user_id')->references('id')->on('users')->onDelete('restrict');
        });
        
        Schema::create('activities', function (Blueprint $table) {
            $table->increments('id');

            $table->integer('user_id')->unsigned();
            $table->string('action');
            $table->string('table')->nullable();
            $table->string('entity_id')->nullable();
            $table->timestamps();

            $table->foreign('user_id')->references('id')->on('users')->onDelete('restrict');
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
        Schema::dropIfExists('roles');
        Schema::dropIfExists('user_role');
        Schema::dropIfExists('permissions');
        Schema::dropIfExists('permission_role');
        Schema::dropIfExists('password_resets');
        Schema::dropIfExists('acting_users');
        Schema::dropIfExists('users');
    }
}
