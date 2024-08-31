<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddSourceColumns extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('case_members', function (Blueprint $table) {
            $table->enum('source', ['app','website'])->nullable(true);
        });

        Schema::table('member_video_histories', function (Blueprint $table) {
            $table->enum('source', ['app','website'])->nullable(true);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {

        Schema::table('case_members', function (Blueprint $table) {
            $table->dropColumn('source');
        });

        Schema::table('member_video_histories', function (Blueprint $table) {
            $table->dropColumn('source');
        });
    }
}
