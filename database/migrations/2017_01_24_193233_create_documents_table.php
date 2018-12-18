<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDocumentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('templates', function (Blueprint $table) {
            $table->increments('id');
            $table->string('template_name');
            $table->string('desc');
            $table->string('category');
            $table->integer('sequence');
            $table->text('fields');
            $table->char('status', 1);
            $table->timestamps();
        });

        Schema::create('documents', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('template_id')->unsigned();
            $table->integer('shipment_id')->unsigned();
            $table->integer('user_id')->unsigned();
            $table->string('title');
            $table->string('remarks');
            $table->string('url');
            $table->integer('older_version')->nullable()->unsigned();
            $table->integer('newer_version')->nullable()->unsigned();
            $table->integer('version')->unsigned();
            $table->integer('progress')->nullable();
            $table->string('progress_desc')->nullable();
            $table->char('status', 1);
            $table->timestamps();

            $table->foreign('template_id')->references('id')->on('templates')->onDelete('cascade');
            $table->foreign('shipment_id')->references('id')->on('shipments')->onDelete('cascade');
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
        });

        Schema::create('document_details', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('document_id')->unsigned();
            $table->string('field');
            $table->text('content');
            $table->timestamps();

            $table->foreign('document_id')->references('id')->on('documents')->onDelete('cascade');
        });

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('document_details');
        Schema::dropIfExists('documents');
        Schema::dropIfExists('templates');
    }
}
