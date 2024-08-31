<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddQuizMember extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('quiz_responses', function (Blueprint $table) {
            $table->unsignedInteger('quiz_member_id')->nullable();
            $table->foreign('quiz_member_id')->references('id')->on('quiz_members');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('quiz_responses', function (Blueprint $table) {
            $table->dropForeign(['quiz_member_id']);
            $table->dropColumn('quiz_member_id');
        });
    }
}
