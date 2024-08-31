<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUniversalDerivedData extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('universal_derived_data', function (Blueprint $table) {

            $table->unsignedInteger('universal_member_id')->nullable(false)->index();
            $table->unsignedInteger('member_id')->nullable(true);

            $table->integer('articles_read')->nullable(0);
            $table->integer('cases_viewed')->nullable(0);
            $table->integer('live_events_registered')->nullable(0);
            $table->integer('newsletters_viewed')->nullable(0);
            $table->integer('videos_watched')->nullable(0);

            $table->unsignedInteger('last_active_DMR')->nullable(true);

            $table->string('doctor_time_preference')->nullable(true);
            $table->string('digiMR_rating')->nullable(true);
            $table->string('doctor_language')->nullable(true);

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
        Schema::dropIfExists('universal_derived_data');
    }
}
