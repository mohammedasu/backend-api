<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddFieldsToDoctorLastCallHistories29081611 extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('doctor_last_call_histories', function (Blueprint $table) {
            $table->string('project_name')->nullable();
            $table->string('telecaller_name')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('doctor_last_call_histories', function (Blueprint $table) {
            $table->dropColumn(['project_name', 'telecaller_name']);
        });
    }
}
