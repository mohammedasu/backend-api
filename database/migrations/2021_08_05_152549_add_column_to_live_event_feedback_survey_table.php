<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddColumnToLiveEventFeedbackSurveyTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('live_event_feedback_survey', function (Blueprint $table) {
            $table->json('option')->nullable();
            
            $table->boolean('is_active')->default(true);

            $table->boolean('que_case')->default(false);
            
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('live_event_feedback_survey', function (Blueprint $table) {
            $table->dropColumn('option');
        });
    }
}
