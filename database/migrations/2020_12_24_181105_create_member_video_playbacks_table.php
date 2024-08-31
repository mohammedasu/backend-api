<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMemberVideoPlaybacksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('member_video_playbacks', function (Blueprint $table) {
            $table->increments('id');

            $table->unsignedInteger('member_id')->nullable();
            $table->foreign('member_id')->references('id')->on('members');

            $table->unsignedInteger('video_id')->nullable();
            $table->foreign('video_id')->references('id')->on('videos');

            $table->integer('start_position')->nullable(true);
            $table->integer('end_position')->nullable(true);
            $table->integer('total_duration')->nullable(true);

            $table->enum('type', ['play', 'pause','finish'])->default('play');

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
        Schema::dropIfExists('member_video_playbacks');
    }
}
