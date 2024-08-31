<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddColumnToVideosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('videos', function (Blueprint $table) {
            $table->timestamp('video_timestamp')->nullable(true);
            $table->boolean('video_show')->default(false);
            $table->boolean('video_schedule')->default(false);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('videos', function (Blueprint $table) {
            $table->dropColumn('video_timestamp');
            $table->dropColumn('video_show');
            $table->dropColumn('video_schedule');
        });
    }
}
