<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddMemberIdInCases extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('cases', function (Blueprint $table) {
            $table->unsignedInteger('created_by_member_id')->nullable();
            $table->foreign('created_by_member_id')->references('id')->on('members');

            $table->unsignedInteger('expert_id')->nullable(true)->change();

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('cases', function (Blueprint $table) {
            $table->dropForeign(['created_by_member_id']);
            $table->dropColumn('created_by_member_id');
        });
    }
}
