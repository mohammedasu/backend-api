<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateWhatsappLog extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('whatsapp_log', function (Blueprint $table) {
            $table->increments('id');

            $table->unsignedInteger('live_event_member_id')->nullable();
            $table->foreign('live_event_member_id')->references('id')->on('live_event_members');

            $table->string('type')->nullable(false);

            $table->text('response')->nullable(true);

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
        Schema::dropIfExists('whatsapp_log');
    }
}
