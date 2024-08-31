<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AlterUniversalDerivedData extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('universal_derived_data', function (Blueprint $table) {

            $table->integer('articles_read')->nullable(true)->default(0)->change();
            $table->integer('cases_viewed')->nullable(true)->default(0)->change();
            $table->integer('live_events_registered')->nullable(true)->default(0)->change();
            $table->integer('newsletters_viewed')->nullable(true)->default(0)->change();
            $table->integer('videos_watched')->nullable(true)->default(0)->change();

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
            //no need to revert
    }
}
