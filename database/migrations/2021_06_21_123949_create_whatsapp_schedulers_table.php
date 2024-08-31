<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateWhatsappSchedulersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('whatsapp_schedulers', function (Blueprint $table) {
            $table->increments('id');

            $table->unsignedInteger('whatsapp_template_id')->nullable();
            $table->foreign('whatsapp_template_id')->references('id')->on('whatsapp_templates');

            $table->unsignedInteger('live_event_id')->nullable();
            $table->foreign('live_event_id')->references('id')->on('live_events');

            $table->boolean('is_sent')->default(false);

            $table->timestamp('scheduled_timestamp')->nullable(false);

            $table->unique(['whatsapp_template_id', 'live_event_id']);

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
        Schema::dropIfExists('whatsapp_schedulers');
    }
}
