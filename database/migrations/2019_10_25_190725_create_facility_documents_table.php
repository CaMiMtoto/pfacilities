<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFacilityDocumentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('facility_documents', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('facility_id');
            $table->unsignedBigInteger('application_type_id');
            $table->unsignedBigInteger('user_id');
            $table->unsignedBigInteger('document_id');
            $table->boolean('available')->nullable();
            $table->string('observation')->nullable();
            $table->string('document_file')->nullable();
            $table->timestamps();

            $table->foreign('facility_id')->on('facilities')->references('id');
            $table->foreign('document_id')->on('documents')->references('id');
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
        Schema::dropIfExists('facility_documents');
    }
}
