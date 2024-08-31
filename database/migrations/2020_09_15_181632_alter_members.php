<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AlterMembers extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('members', function (Blueprint $table) {
            $table->renameColumn('is_verified', 'phone_no_verified');

            $table->boolean('is_verified_with_mci')->default(false);

            $table->integer('profile_complete')->default(0);

            $table->date('last_active_date')->nullable(true)->default(null);

            $table->unsignedInteger('last_video_watched')->nullable()->default(null);

            $table->foreign('last_video_watched')->references('id')->on('videos');

            $table->integer('monthly_video_count')->default(0);

            $table->integer('lifetime_video_count')->default(0);

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('members', function (Blueprint $table) {
            //
        });
    }
}
