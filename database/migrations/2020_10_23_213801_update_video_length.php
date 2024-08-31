<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdateVideoLength extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('live_events', function (Blueprint $table) {
            $table->text('youtube_video_id')->nullable(true)->change();
            $table->renameColumn('youtube_video_id','video_link');
            $table->renameColumn('is_youtube_event','is_non_vimeo_event');
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
            $table->renameColumn('video_link', 'youtube_video_id');
            $table->renameColumn('is_non_vimeo_event', 'is_youtube_event');
        });
    }
}
