<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCertificatePickingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('certificate_pickings', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('user_application_id');
            $table->dateTime('picking_date');
            $table->string('picked_by')->nullable();
            $table->dateTime('picked_at')->nullable();
            $table->string('nid',16)->nullable();
            $table->text('comment')->nullable();
            $table->timestamps();

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
        Schema::dropIfExists('certificate_pickings');
    }
}
