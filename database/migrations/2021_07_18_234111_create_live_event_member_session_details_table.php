<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLiveEventMemberSessionDetailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('live_event_member_session_details', function (Blueprint $table) {
            $table->id();
            $table->string('type')->nullable();
            $table->unsignedInteger('live_event_member_id')->nullable();
            $table->foreign('live_event_member_id')->references('id')->on('live_event_members');
            $table->unsignedInteger('live_event_id')->nullable();
            $table->foreign('live_event_id')->references('id')->on('live_events');
            $table->timestamp('time')->nullable();
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
        Schema::dropIfExists('live_event_member_session_details');
    }
}
