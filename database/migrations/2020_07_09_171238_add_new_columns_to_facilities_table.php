<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddNewColumnsToFacilitiesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('facilities', function (Blueprint $table) {
            $table->string('owner_phone')->nullable();
            $table->string('owner_id_number')->nullable();
            $table->string('owner_email')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('facilities', function (Blueprint $table) {
            //
        });
    }
}
