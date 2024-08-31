<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLiveEventChatUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('live_event_chat_users', function (Blueprint $table) {
            $table->id();
            $table->unsignedInteger('live_event_id')->nullable();
            $table->string('chat_group')->nullable();
            $table->unsignedInteger('user_id')->nullable();
            $table->json('user')->nullable();
            $table->string('user_type')->nullable();
            $table->string('socket_id')->nullable();
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
        Schema::dropIfExists('live_event_chat_users');
    }
}
