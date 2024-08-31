<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddQuizToLiveEventsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('live_events', function (Blueprint $table) {
            $table->unsignedInteger('quiz_id')->nullable();
            $table->boolean('quiz_active')->default(false);
        });
        Schema::table('quiz', function (Blueprint $table) {
            $table->string('source_type')->nullable();
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
            $table->dropColumn('quiz_id');
            $table->dropColumn('quiz_active');
        });
        Schema::table('quiz', function (Blueprint $table) {
            $table->dropColumn('source_type');
        });
    }
}
