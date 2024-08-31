<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddFieldsToDoctorAcademicInfosTable14031649 extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('doctor_academic_infos', function (Blueprint $table) {
            $table->string('other_institute_name')->nullable();
            $table->string('other_course_name')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('doctor_academic_infos', function (Blueprint $table) {
            $table->dropColumn('other_institute_name');
            $table->dropColumn('other_course_name');
        });
    }
}
