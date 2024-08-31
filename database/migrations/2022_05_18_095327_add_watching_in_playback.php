<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

class AddWatchingInPlayback extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        
        DB::statement("ALTER TABLE `member_video_playbacks` CHANGE `type` `type` enum('play','pause','finish','stop','watching')");

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        DB::statement("ALTER TABLE `member_video_playbacks` CHANGE `type` `type` enum('play','pause','finish','stop')");

    }
}
