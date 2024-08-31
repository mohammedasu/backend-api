<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDiscussionForumFeedBacksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('discussion_forum_feed_backs', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('discussion_details_id')->nullable();
            $table->foreign('discussion_details_id')->references('id')->on('discussion_form_details');

            $table->unsignedInteger('member_id')->nullable();
            $table->foreign('member_id')->references('id')->on('members');

            $table->boolean('like')->default(false);
            $table->boolean('insightful')->default(false);

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
        Schema::dropIfExists('discussion_forum_feed_backs');
    }
}
