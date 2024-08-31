<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class AddSliderTypeExternal extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('sliders', function (Blueprint $table) {
            DB::statement("ALTER TABLE `sliders` CHANGE `type` `type` ENUM('home','partner','partner_division','community','external') 
                                COLLATE 'utf8mb4_unicode_ci' NOT NULL DEFAULT 'home' AFTER `updated_at`;");

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('sliders', function (Blueprint $table) {
            DB::statement("ALTER TABLE `sliders` CHANGE `type` `type` ENUM('home','partner','partner_division','community')
                                COLLATE 'utf8mb4_unicode_ci' NOT NULL DEFAULT 'home' AFTER `updated_at`;");
        });
    }
}
