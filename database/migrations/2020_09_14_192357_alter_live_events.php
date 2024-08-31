<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AlterLiveEvents extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('live_events', function (Blueprint $table) {
            $table->unsignedInteger('partner_division_id')->nullable();
            $table->foreign('partner_division_id')->references('id')->on('partner_divisions');
            $table->unsignedInteger('community_id')->nullable();
            $table->foreign('community_id')->references('id')->on('communities');
            $table->unsignedInteger('knowledge_category_id')->nullable();
            $table->foreign('knowledge_category_id')->references('id')->on('knowledge_categories');
            $table->string('event_month')->nullable(true)->default(null);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('live_events', function (Blueprint $table) {
            $table->dropForeign(['knowledge_category_id']);
            $table->dropForeign(['community_id']);
            $table->dropForeign(['partner_division_id']);
            $table->dropColumn(['event_month', 'knowledge_category_id', 'community_id', 'partner_division_id']);
        });
    }
}
