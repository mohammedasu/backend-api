<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddFieldsInQualificationDetailMasterTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('qualification_detail_master', function (Blueprint $table) {
            $table->unsignedInteger('speciality_id')->after('qualification_master_ref_no')->default(0);
            // $table->foreign('speciality_id')->references('id')->on('specialities');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('qualification_detail_master', function (Blueprint $table) {
            $table->dropColumn('speciality_id');
        });
    }
}
