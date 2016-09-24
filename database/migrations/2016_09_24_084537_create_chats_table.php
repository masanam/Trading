<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateChatsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('chats', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('trader_id')->unsigned();
            $table->integer('approver_id')->unsigned();
            $table->timestamps();
        });

        Schema::table('chats', function (Blueprint $table) {
            $table->foreign('trader_id')->references('id')->on('user')->onDelete('cascade');
            $table->foreign('approver_id')->references('id')->on('user')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('chats');
    }
}
