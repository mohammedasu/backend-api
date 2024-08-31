<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLiveEventSurveysTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('live_event_surveys', function (Blueprint $table) {
            $table->increments('id');

            $table->unsignedInteger('live_event_member_id');

            $table->foreign('live_event_member_id')->references('id')->on('live_event_members');

            $table->longText('q1')->nullable()->comment('What would be the most suitable day of the week for you to be able to attend such webinars?');
            $table->longText('q2')->nullable()->comment('What would be the most suitable time for you to be able to attend such webinars?');
            $table->boolean('q3')->nullable()->comment('Do you use Molecular Diagnostics tests for diagnosis/ treatment choice in your patients?');
            $table->longText('q4')->nullable()->comment('What are the molecular diagnostics tests you normally prescribe for your patients?');
            $table->longText('q5')->nullable()->comment('Please suggest 3 ideas to make molecular diagnostics test accessible to more patients?');
            $table->longText('q6')->nullable()->comment('What are the topics you want to know more about in Molecular diagnostics from the National or International experts?');

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
        Schema::dropIfExists('live_event_surveys');
    }
}
