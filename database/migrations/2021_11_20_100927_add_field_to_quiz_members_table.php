<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddFieldToQuizMembersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('quiz_members', function (Blueprint $table) {
            $table->string('source_type')->nullable();
            $table->unsignedInteger('live_event_member_id')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('quiz_members', function (Blueprint $table) {
            $table->dropColumn('source_type');
            $table->dropColumn('live_event_member_id');
        });
    }
}
