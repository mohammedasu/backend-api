<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddNonMedicalEventMembers extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('live_event_members', function (Blueprint $table) {
            $table->boolean('non_medical_event_member')->default(false);
            $table->string('company',200)->nullable(true);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('live_event_members', function (Blueprint $table) {
            $table->dropColumn('non_medical_event_member');
        });
    }
}
