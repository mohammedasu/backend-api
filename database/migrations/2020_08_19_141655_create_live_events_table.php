<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLiveEventsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('live_events', function (Blueprint $table) {
            $table->increments('id');
            $table->string('link_id', 10);
            $table->dateTime('session_time')->nullable(false);
            $table->integer('buffer_time')->default(0);
            $table->string('title', 50)->nullable(false);
            $table->unsignedInteger('partner_id')->nullable();
            $table->string('banner_image')->nullable();
            $table->string('mobile_banner_image')->default(null)->nullable();
            $table->boolean('is_active')->default(true);
            $table->string('register_image1')->nullable();
            $table->string('register_image2')->nullable();
            $table->string('video_id', 50)->nullable(false);
            $table->string('vchat_id', 50)->nullable(false);
            $table->string('live_event_text', 100)->nullable(false);
            $table->string('description', 200)->nullable(true);
            $table->longText('tnc_detail')->nullable(true);
            $table->ipAddress('ip_address');
            $table->foreign('partner_id')->references('id')->on('partners');
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
        Schema::table('live_events', function (Blueprint $table) {
            $table->dropForeign(['partner_id']);
        });
        Schema::dropIfExists('live_events');
    }
}
