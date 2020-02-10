<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateApplicationSharesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('application_shares', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('user_application_id');
            $table->unsignedBigInteger('position_id');
            $table->unsignedBigInteger('shared_by');
            $table->timestamps();
            $table->foreign('user_application_id')->on('user_applications')->references('id');
            $table->foreign('position_id')->on('positions')->references('id');
            $table->foreign('shared_by')->on('users')->references('id');

            $table->unique(['user_application_id','position_id','shared_by'],'ui_uapp_pos_shaby');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('application_shares');
    }
}
