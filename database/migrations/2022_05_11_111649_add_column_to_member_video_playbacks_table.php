<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddColumnToMemberVideoPlaybacksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('member_video_playbacks', function (Blueprint $table) {
            $table->string('ip_address')->nullable();
            $table->string('ip_country')->nullable();
            $table->string('ip_state')->nullable();
            $table->string('ip_city')->nullable();
            $table->string('utm_source')->nullable();
            $table->string('utm_campaign')->nullable();
            $table->string('utm_medium')->nullable();
            $table->string('utm_id')->nullable();
            $table->string('device_name')->nullable();
            $table->string('source')->nullable()->default('android');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('member_video_playbacks', function (Blueprint $table) {
            $table->dropColumn(['utm_source', 'utm_campaign', 'utm_medium', 'utm_id', 'ip_address', 'ip_country', 'ip_state', 'ip_city', 'device_name','source']);
        });
    }
}
