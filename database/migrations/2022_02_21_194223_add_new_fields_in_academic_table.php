<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddNewFieldsInAcademicTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('member_academic_info', function (Blueprint $table) {
            $table->string('qualification_detail_master_ref_no')->after('qualification')->nullable();
            // $table->foreign('qualification_detail_master_ref_no')->references('qualification_detail_master_ref_no')->on('qualification_detail_master');
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
            $table->dropColumn('qualification_detail_master_ref_no');
        });
    }
}
