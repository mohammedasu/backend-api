<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddLikesInsightfullForMemberVideo extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('member_video_histories', function (Blueprint $table) {
            $table->boolean('liked')->default(false);
            $table->boolean('insightful')->default(false);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('member_video_histories', function (Blueprint $table) {
            $table->dropColumn('liked');
            $table->dropColumn('insightful');
        });
    }
}
