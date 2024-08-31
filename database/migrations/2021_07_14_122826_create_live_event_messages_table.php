<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLiveEventMessagesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('live_event_messages', function (Blueprint $table) {
            $table->id();
            $table->longText('message')->nullable();
            $table->unsignedInteger('live_event_id')->nullable();
            $table->foreign('live_event_id')->references('id')->on('live_events');
            $table->unsignedInteger('group_id')->nullable();
            $table->unsignedInteger('sender_id')->nullable();
            $table->boolean('moderator')->default(false);
            $table->string('deleted_by')->nullable();
            $table->string('starred')->default(false);
            $table->softDeletes();
            // $table->foreign('live_event_id')->on('live_events')->references('id');
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
        Schema::dropIfExists('live_event_messages');
    }
}
