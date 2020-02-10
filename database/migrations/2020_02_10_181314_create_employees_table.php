<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEmployeesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('employees', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name');
            $table->string('phone');
            $table->string('nid',16);
            $table->string('license_number');
            $table->string('qualification');
            $table->unsignedBigInteger('position_id');
            $table->unsignedBigInteger('facility_id');
            $table->date('hired_date');
            $table->date('contract_end');
            $table->timestamps();

            $table->foreign('position_id')->references('id')->on('employee_positions');
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
        Schema::dropIfExists('employees');
    }
}
