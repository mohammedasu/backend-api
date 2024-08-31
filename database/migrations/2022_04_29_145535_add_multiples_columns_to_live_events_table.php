<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddMultiplesColumnsToLiveEventsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('live_events', function (Blueprint $table) {
            $table->string('live_event_country')->nullable();
            $table->integer('is_mmc_number')->default(0);
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
            $table->dropColumn(['live_event_country','is_mmc_number']);
        });
    }
}
