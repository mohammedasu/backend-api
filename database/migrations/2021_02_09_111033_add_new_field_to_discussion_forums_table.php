<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddNewFieldToDiscussionForumsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('discussion_forms', function (Blueprint $table) {
            $table->string('slug')->unique()->nullable();
            $table->unsignedBigInteger('video_id')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('discussion_forms', function (Blueprint $table) {
            // $table->dropColumn('slug');
            // $table->dropColumn('video_id');
        });
    }
}
