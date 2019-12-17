<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateApplicationTypeDocumentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('application_type_documents', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('application_type_id');
            $table->unsignedBigInteger('document_id');
            $table->unsignedBigInteger('user_id');
            $table->timestamps();

            $table->foreign('application_type_id')->references('id')->on('application_types');
            $table->foreign('document_id')->references('id')->on('documents');
            $table->foreign('user_id')->references('id')->on('users');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('application_type_documents');
    }
}
