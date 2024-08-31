<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLiveEventImagesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('live_event_images', function (Blueprint $table) {
            $table->increments('id');

            $table->text('pdf_description')->nullable(false);

            $table->string('pdf_name')->nullable(false);

            $table->unsignedInteger('live_event_id')->nullable();

            $table->foreign('live_event_id')->references('id')->on('live_events');

            $table->softDeletes();

            $table->ipAddress('ip_address');
            
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
        Schema::dropIfExists('live_event_images');
    }
}
