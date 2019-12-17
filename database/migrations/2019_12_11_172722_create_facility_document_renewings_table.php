<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFacilityDocumentRenewingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('facility_document_renewings', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('facility_id');
            $table->unsignedBigInteger('user_id');
            $table->string('app_letter');
            $table->string('district_report');
            $table->string('status')->default('pending');
            $table->string('comment',512)->nullable();
            $table->timestamps();

            $table->foreign('facility_id')->references('id')->on('facilities');
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
        Schema::dropIfExists('facility_document_renewings');
    }
}
