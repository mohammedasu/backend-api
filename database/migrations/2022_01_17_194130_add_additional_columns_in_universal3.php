<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddAdditionalColumnsInUniversal3 extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('universal3', function (Blueprint $table) {
            $table->string('dob')->nullable(true);
            $table->string('institute')->nullable(true);
            $table->string('university')->nullable(true);
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
            $table->dropColumn('dob');
            $table->dropColumn('institute');
            $table->dropColumn('university');

        });
    }
}
