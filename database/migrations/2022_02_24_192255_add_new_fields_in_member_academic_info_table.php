<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddNewFieldsInMemberAcademicInfoTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('member_academic_info', function (Blueprint $table) {
            $table->string('other_course_name')->after('qualification_detail_master_ref_no')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('member_academic_info', function (Blueprint $table) {
            $table->dropColumn('other_course_name');
        });
    }
}
