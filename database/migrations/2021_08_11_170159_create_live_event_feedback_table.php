<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLiveEventFeedbackTable extends Migration
{
    /**
     * Run the migrations.
     *\
     * @return void
     */
    public function up()
    {
        Schema::create('live_event_feedback', function (Blueprint $table) {
            $table->id();
            $table->boolean('insightful')->default(false);
            $table->boolean('like')->default(false);
            $table->unsignedInteger('live_event_member_id')->nullable();
            $table->foreign('live_event_member_id')->references('id')->on('live_event_members');
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
        Schema::dropIfExists('live_event_feedback');
    }
}
