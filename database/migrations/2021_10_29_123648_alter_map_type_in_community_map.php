<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class AlterMapTypeInCommunityMap extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::statement("ALTER TABLE `community_maps` CHANGE `map_type` `map_type` enum('video','cases','expert','partner_division')
    COLLATE 'utf8mb4_unicode_ci' NOT NULL DEFAULT 'video' AFTER `map_id`;");
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        DB::statement("ALTER TABLE `community_maps` CHANGE `map_type` `map_type` enum('video','cases','expert')
    COLLATE 'utf8mb4_unicode_ci' NOT NULL DEFAULT 'video' AFTER `map_id`;");
    }
}
