<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateNotificationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('notifications', function (Blueprint $table) {
            $table->increments('id');

            $table->string("title")->nullable(false);
            $table->string("text")->nullable(true);

            $table->string("action_type")->nullable(true);
            $table->string("action_id")->nullable(true);

            $table->boolean("all_selected")->default(true);

            $table->unsignedInteger('speciality_id')->nullable();
            $table->foreign('speciality_id')->references('id')->on('specialities');

            $table->string("state")->nullable(true);
            $table->string("qualification")->nullable(true);

            $table->unsignedInteger('live_event_id')->nullable();
            $table->foreign('live_event_id')->references('id')->on('live_events');

            $table->string("device_type_filter")->nullable(true);

            $table->string("device_type")->nullable(true);

            $table->longText("response")->nullable(true);

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
        Schema::dropIfExists('notifications');
    }
}
