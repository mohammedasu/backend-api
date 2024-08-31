<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePodcastsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('podcasts', function (Blueprint $table) {
            $table->increments('id');
            $table->string('title', 500)->nullable(false);
            $table->date('date')->nullable(false);
            $table->string('image_name')->nullable();
            $table->string('audio_link')->nullable(false);
            $table->unsignedInteger('community_id')->nullable();
            $table->unsignedInteger('partner_id')->nullable();
            $table->unsignedInteger('expert_id')->nullable();
            $table->longText('description')->nullable(true);
            $table->string('meta_title', 200)->nullable(true);
            $table->string('meta_description', 500)->nullable(true);
            $table->string('meta_keywords')->nullable(true);
            $table->foreign('community_id')->references('id')->on('communities');
            $table->foreign('expert_id')->references('id')->on('experts');
            $table->foreign('partner_id')->references('id')->on('partners');
            $table->boolean('is_active')->default(true);
            $table->ipAddress('ip_address')->nullable();
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
        Schema::table('podcasts', function (Blueprint $table) {
            $table->dropForeign(['partner_id']);
            $table->dropForeign(['expert_id']);
            $table->dropForeign(['community_id']);
        });
        Schema::dropIfExists('podcasts');
    }
}
