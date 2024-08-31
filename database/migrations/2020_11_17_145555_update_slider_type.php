<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class UpdateSliderType extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('sliders', function (Blueprint $table) {
            DB::statement("ALTER TABLE `sliders` 
                                  CHANGE `type` `type` enum('home','partner','partner_division','community') COLLATE 'utf8mb4_unicode_ci' 
                                  NOT NULL DEFAULT 'home'");

            $table->unsignedInteger('type_id')->nullable(true);
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
            DB::statement("ALTER TABLE `sliders` 
                                  CHANGE `type` `type` enum('home','partner','partner_division') COLLATE 'utf8mb4_unicode_ci' 
                                  NOT NULL DEFAULT 'home'");

            $table->dropColumn('type_id');

        });


    }
}
