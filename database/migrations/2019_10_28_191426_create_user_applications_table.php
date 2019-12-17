<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUserApplicationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('user_applications', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('user_id');
            $table->unsignedBigInteger('application_type_id');
            $table->unsignedBigInteger('facility_id');
            $table->string('status',20);

            $table->string('inspector_status');
            $table->text('inspector_comment');

            $table->string('verifier_status');
            $table->text('verifier_comment');

            $table->string('approval_status');
            $table->text('approval_comment');

            $table->timestamps();

            $table->foreign('user_id')->references('id')->on('users');
            $table->foreign('facility_id')->references('id')->on('facilities');
            $table->foreign('application_type_id')->references('id')->on('application_types');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('user_applications');
    }
}
