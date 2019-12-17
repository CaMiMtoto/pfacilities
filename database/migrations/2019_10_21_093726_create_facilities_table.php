<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFacilitiesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('facilities', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name');
            $table->string('ref_number');
            $table->unsignedBigInteger('category_id');
            $table->unsignedBigInteger('sector_id');
            $table->unsignedBigInteger('user_id');
            $table->unsignedBigInteger('cell_id')->nullable();
            $table->unsignedBigInteger('service_id');
            $table->string('manager_name');
            $table->string('email');
            $table->string('phone');
            $table->string('nationalId',50);
            $table->dateTime('license_issued_at')->nullable();
            $table->dateTime('license_expires_at')->nullable();
            $table->string('app_letter')->nullable();
            $table->string('district_report')->nullable();
            $table->string('license_status')->nullable();
            $table->timestamps();

            $table->foreign('service_id')->references('id')->on('services');
            $table->foreign('sector_id')->references('id')->on('sectors');
            $table->foreign('category_id')->references('id')->on('categories');
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
        Schema::dropIfExists('facilities');
    }
}
