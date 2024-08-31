<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

class AddNewcolumnToUniversal3Table extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('universal3', function (Blueprint $table) {
            //
            DB::statement("ALTER TABLE `universal3` CHANGE `sms_active` `sms_active` enum('not sent','delivered','clicked','failed','submitted')");
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
            //
            DB::statement("ALTER TABLE `universal3` CHANGE `sms_active` `sms_active` enum('not sent','delivered','clicked')");
        });
    }
}
