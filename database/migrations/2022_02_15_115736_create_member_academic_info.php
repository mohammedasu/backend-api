<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMemberAcademicInfo extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('member_academic_info', function (Blueprint $table) {
            $table->id();
            $table->string("member_academic_info_ref_no");
            $table->unsignedInteger('member_id');
            $table->string("institute_master_ref_no")->nullable();
            $table->string("qualification")->nullable();
            $table->string("start_date")->nullable();
            $table->string("end_date")->nullable();
            $table->integer("currently_pursuing")->default(0);
            $table->text("other_institute_name")->nullable();
            $table->foreign('member_id')->references('id')->on('members');
            // $table->foreign('institute_master_ref_no')->references('institute_master_ref_no')->on('institute_master');
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
        Schema::dropIfExists('member_academic_info');
    }
}
