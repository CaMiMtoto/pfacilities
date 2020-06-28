<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFacilityLicensesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('facility_licenses', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('user_application_id');
            $table->unsignedBigInteger('user_id');
            $table->string('ref_number');
            $table->string('reason');
            $table->dateTime('signed_at')->nullable();
            $table->longText('body');
            $table->timestamps();

            $table->foreign('user_application_id')->references('id')
                ->on('user_applications')
                ->onDelete('cascade');

            $table->foreign('user_id')->references('id')
                ->on('users')
                ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('facility_licenses');
    }
}
