<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSeriesItemsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('series_items', function (Blueprint $table) {
            $table->increments('id');

            $table->boolean('is_active')->default(true);

            $table->unsignedInteger('series_id')->nullable();
            $table->foreign('series_id')->references('id')->on('series');


            $table->unsignedInteger('video_id')->nullable();
            $table->foreign('video_id')->references('id')->on('videos');

            $table->integer('episode_number')->nullable(false);

            $table->ipAddress('ip_address');

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
        Schema::dropIfExists('series_items');
    }
}

