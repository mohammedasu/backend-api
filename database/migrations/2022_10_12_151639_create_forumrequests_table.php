<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateForumrequestsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('forumrequests', function (Blueprint $table) {
            $table->id();
            $table->unsignedInteger('member_id');
            $table->foreign('member_id')->references('id')->on('members');
            $table->unsignedInteger('forum_id');
            $table->foreign('forum_id')->references('id')->on('partner_divisions');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('forumrequests');
    }
}
