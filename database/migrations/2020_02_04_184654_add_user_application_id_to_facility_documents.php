<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddUserApplicationIdToFacilityDocuments extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('facility_documents', function (Blueprint $table) {
            $table->unsignedBigInteger('user_application_id')->nullable();
            $table->foreign('user_application_id')->on('user_applications')->references('id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('facility_documents', function (Blueprint $table) {
            //
        });
    }
}
