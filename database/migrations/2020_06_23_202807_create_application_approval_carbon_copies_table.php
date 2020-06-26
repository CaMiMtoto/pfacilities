<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateApplicationApprovalCarbonCopiesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('application_approval_carbon_copies', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('application_approval_id');
            $table->string('name');
            $table->timestamps();

            $table->foreign('application_approval_id', 'app_approval_cc_app_approval_id_fk')
                ->references('id')
                ->on('application_approvals')
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
        Schema::dropIfExists('application_approval_carbon_copies');
    }
}
