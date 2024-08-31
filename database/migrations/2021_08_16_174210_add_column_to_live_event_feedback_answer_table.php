<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddColumnToLiveEventFeedbackAnswerTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('live_event_feedback_answer', function (Blueprint $table) {

            $table->string('link_id')->nullable();

            $table->string('live_event_id')->nullable();

            $table->string('live_event_text')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('live_event_feedback_answer', function (Blueprint $table) {
            $table->dropColumn('link_id');
            $table->dropColumn('live_event_id');
            $table->dropColumn('live_event_text');
        });
    }
}
