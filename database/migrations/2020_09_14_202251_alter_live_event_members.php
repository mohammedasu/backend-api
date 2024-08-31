<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AlterLiveEventMembers extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('live_event_members', function (Blueprint $table) {
            $table->string('mobile_number',20)->nullable(false)->change();
            $table->unsignedInteger('community_id')->nullable()->change();

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('live_event_members', function (Blueprint $table) {
            //
        });
    }
}
