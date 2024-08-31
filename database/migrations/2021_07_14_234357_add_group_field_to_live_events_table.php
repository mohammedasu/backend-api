<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class AddGroupFieldToLiveEventsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('live_events', function (Blueprint $table) {
            $table->unsignedBigInteger('live_event_chat_group')->nullable();
            $table->foreign('live_event_chat_group')->references('id')->on('chat_groups');
            $table->string('moderator_password')->nullable();
            $table->boolean('active_chat')->default(true);
            $table->boolean('chat_type')->default(true);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('live_events', function (Blueprint $table) {
            $table->dropForeign(['live_event_chat_group']);
            $table->dropColumn('live_event_chat_group');
            $table->dropColumn('moderator_password');
            $table->dropColumn('active_chat');
            $table->dropColumn('chat_type');
        });
    }
}
