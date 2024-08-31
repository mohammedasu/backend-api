<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdateRepDoctorMappings extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('representative_doctor_mappings', function (Blueprint $table) {
            $table->enum('status',['new','registered','video_seen'])->default('new');
            $table->unsignedInteger('doctor_id')->nullable(true);
            $table->text('response')->nullable(true);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('representative_doctor_mappings', function (Blueprint $table) {
            $table->dropColumn('status');
            $table->dropColumn('doctor_id');
            $table->dropColumn('response');
        });
    }
}
