<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFacilityVisitsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('facility_visits', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('facility_id');
            $table->date('date');
            $table->string('comment');
            $table->string('visitor');
            $table->string('purpose');
            $table->longText('recommendations');
            $table->string('document')->nullable();
            $table->unsignedBigInteger('user_id');
            $table->timestamps();
            $table->foreign('user_id')->references('id')->on('users');
            $table->foreign('facility_id')->references('id')->on('facilities');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('facility_visits');
    }
}
