<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddNewcolumnToPrivateForumInvitesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('private_forum_invites', function (Blueprint $table) {
            //
            $table->unsignedInteger('forum_id');
            $table->foreign('forum_id')->references('id')->on('partner_divisions');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('private_forum_invites', function (Blueprint $table) {
            $table->dropForeign(['forum_id']);
            $table->dropColumn(['forum_id']);
        });
    }
}
