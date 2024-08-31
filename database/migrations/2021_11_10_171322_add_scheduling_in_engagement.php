<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddSchedulingInEngagement extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('engagements', function (Blueprint $table) {
            $table->timestamp('scheduled_timestamp')->nullable(true);
            $table->boolean('is_processed')->default(false);
            $table->json('payload')->nullable(true);
            $table->json('target_members')->nullable(true);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('engagements', function (Blueprint $table) {
            $table->dropColumn('scheduled_timestamp');
            $table->dropColumn('is_processed');
            $table->dropColumn('payload');
            $table->dropColumn('target_members');
        });
    }
}
