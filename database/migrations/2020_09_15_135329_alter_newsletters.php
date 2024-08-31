<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AlterNewsletters extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('newsletters', function (Blueprint $table) {
            $table->unsignedInteger('partner_division_id')->nullable();
            $table->foreign('partner_division_id')->references('id')->on('partner_divisions');
            $table->unsignedInteger('knowledge_category_id')->nullable();
            $table->foreign('knowledge_category_id')->references('id')->on('knowledge_categories');
            $table->integer('view_count')->default(0);
            $table->timestamp('last_seen_at')->nullable(true)->default(null);
            $table->boolean('part_of_video')->default(true);
            $table->unsignedInteger('video_id')->nullable();
            $table->foreign('video_id')->references('id')->on('videos');
            $table->string('month_added')->nullable(true)->default(null);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('newsletters', function (Blueprint $table) {
            $table->dropForeign(['video_id']);
            $table->dropForeign(['knowledge_category_id']);
            $table->dropForeign(['partner_division_id']);
            $table->dropColumn(['month_added', 'video_id', 'part_of_video', 'last_seen_at', 'view_count', 'knowledge_category_id', 'partner_division_id']);
        });
    }
}
