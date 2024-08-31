<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class AddSchedulingInNotifications extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');

        Schema::table('notifications', function (Blueprint $table) {
            $table->timestamp('notification_timestamp')->nullable(true);
            $table->boolean('is_active')->default(true);

            $table->dropForeign(['speciality_id']);
            $table->dropColumn('speciality_id');

            $table->unsignedInteger('community_id')->nullable();
            $table->foreign('community_id')->references('id')->on('communities');

        });

        DB::statement('SET FOREIGN_KEY_CHECKS=1;');


    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('notifications', function (Blueprint $table) {
            $table->dropColumn('notification_timestamp');
            $table->dropColumn('is_active');
        });
    }
}
