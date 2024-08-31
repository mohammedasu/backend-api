<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMemberWorkplaceInfo extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('member_workplace_info', function (Blueprint $table) {
            $table->id();
            $table->string("member_workplace_info_ref_no");
            $table->unsignedInteger("member_id");
            $table->string("place_of_work")->nullable();
            $table->string("work_place_type")->nullable();
            $table->string("designation")->nullable();
            $table->string("city")->nullable();
            $table->string("start_date")->nullable();
            $table->string("end_date")->nullable();
            $table->integer("currently_working")->default(0);
            $table->longText("address")->nullable();
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
        Schema::dropIfExists('member_workplace_info');
    }
}
