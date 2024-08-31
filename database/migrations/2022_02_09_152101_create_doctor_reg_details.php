<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDoctorRegDetails extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('doctor_reg_details', function (Blueprint $table) {
            $table->id();
            $table->string("doctor_reg_detail_ref_no");
            $table->unsignedInteger("member_id");
            $table->string("association_name")->nullable();
            $table->string("registration_no")->nullable();
            $table->string("registration_year")->nullable();
            $table->string("state")->nullable();
            $table->foreign('member_id')->references('id')->on('members');
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
        Schema::dropIfExists('doctor_reg_details');
    }
}
