<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateApplicationHistoriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('application_histories', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('user_application_id');
            $table->unsignedBigInteger('shared_to_position_id');
            $table->unsignedBigInteger('shared_by');
            $table->text('comment')->nullable();
            $table->string('status')->nullable();
            $table->timestamps();

            $table->foreign('user_application_id')->on('user_applications')->references('id');
            $table->foreign('shared_to_position_id')->on('positions')->references('id');
            $table->foreign('shared_by')->on('users')->references('id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('application_histories');
    }
}
