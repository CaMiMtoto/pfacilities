<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateApplicationApprovalsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('application_approvals', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('user_application_id');
            $table->unsignedBigInteger('signedBy');
            $table->string('ref_number');
            $table->string('reason');
            $table->longText('body');
            $table->string('done_by');
            $table->string('done_by_title');
            $table->dateTime('signed_at')->nullable();
            $table->timestamps();

            $table->foreign('user_application_id')->references('id')
                ->on('user_applications')
                ->onDelete('cascade');

            $table->foreign('signedBy')->references('id')
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
        Schema::dropIfExists('application_approvals');
    }
}
