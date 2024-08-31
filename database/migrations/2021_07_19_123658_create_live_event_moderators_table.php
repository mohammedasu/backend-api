<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLiveEventModeratorsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('live_event_moderators', function (Blueprint $table) {
            $table->id();
            $table->string('fname')->nullable();
            $table->string('ip_address');
            $table->unsignedInteger('link_id')->nullable();
            $table->foreign('link_id')->references('id')->on('live_events');
            $table->softDeletes();
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
        Schema::dropIfExists('live_event_moderators');
    }
}
