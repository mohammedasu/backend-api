<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddMoreIndexInUniversal3 extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('universal3', function (Blueprint $table) {
            $table->index(['mobile_number', 'country_code']);

            $table->index('cases_viewed');
            $table->index('live_events_registered');
            $table->index('newsletters_viewed');
            $table->index('videos_watched');

            $table->integer('cases_viewed')->default(0)->change();
            $table->integer('live_events_registered')->default(0)->change();
            $table->integer('newsletters_viewed')->default(0)->change();
            $table->integer('videos_watched')->default(0)->change();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('universal3', function (Blueprint $table) {
            $table->dropIndex(['mobile_number', 'country_code']);

            $table->dropIndex(['cases_viewed']);
            $table->dropIndex(['live_events_registered']);
            $table->dropIndex(['newsletters_viewed']);
            $table->dropIndex(['videos_watched']);

            $table->integer('cases_viewed')->nullable(true)->change();
            $table->integer('live_events_registered')->nullable(true)->change();
            $table->integer('newsletters_viewed')->nullable(true)->change();
            $table->integer('videos_watched')->nullable(true)->change();
        });
    }
}
