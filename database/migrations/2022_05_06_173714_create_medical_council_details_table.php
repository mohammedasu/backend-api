<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMedicalCouncilDetailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('medical_council_details', function (Blueprint $table) {
            $table->id();
            $table->string('year_of_registration');
            $table->string('registration_number');
            $table->string('state_medical_councils');
            $table->string('name');
            $table->string('father_name');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('medical_council_details');
    }
}
