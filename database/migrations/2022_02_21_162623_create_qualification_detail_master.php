<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateQualificationDetailMaster extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('qualification_detail_master', function (Blueprint $table) {
            $table->id();
            $table->string('qualification_detail_master_ref_no');
            $table->string('qualification_master_ref_no');
            $table->string('course_name');
            $table->foreign('qualification_master_ref_no')->references('qualification_master_ref_no')->on('qualifications');
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
        Schema::dropIfExists('qualification_detail_master');
    }
}
