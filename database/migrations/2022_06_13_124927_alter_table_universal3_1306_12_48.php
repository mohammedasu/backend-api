<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AlterTableUniversal313061248 extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('utm_links_details', function (Blueprint $table) {
            $table->integer('universal_doctor_id')->nullable();

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('utm_links_details', function (Blueprint $table) {
            $table->dropColumn('universal_doctor_id');
        });
    }
}
