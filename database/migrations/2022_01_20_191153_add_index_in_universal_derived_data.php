<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddIndexInUniversalDerivedData extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('universal_derived_data', function (Blueprint $table) {
            $table->index('cases_viewed');
            $table->index('live_events_registered');
            $table->index('newsletters_viewed');
            $table->index('videos_watched');
            $table->index('member_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('universal_derived_data', function (Blueprint $table) {
            $table->dropIndex(['cases_viewed']);
            $table->dropIndex(['live_events_registered']);
            $table->dropIndex(['newsletters_viewed']);
            $table->dropIndex(['videos_watched']);
            $table->dropIndex(['member_id']);

        });
    }
}
