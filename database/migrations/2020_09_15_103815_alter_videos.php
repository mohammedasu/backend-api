<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AlterVideos extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('videos', function (Blueprint $table) {
            $table->unsignedInteger('partner_division_id')->nullable();
            $table->foreign('partner_division_id')->references('id')->on('partner_divisions');
            $table->unsignedInteger('knowledge_category_id')->nullable();
            $table->foreign('knowledge_category_id')->references('id')->on('knowledge_categories');
            $table->boolean('is_part_of_series')->default(false);
            $table->string('month_added')->nullable(true)->default(null);
            $table->timestamp('last_watched_at')->nullable(true)->default(null);
            $table->boolean('visible_on_main_page')->default(true);
        });

        if (Schema::hasColumn('videos', 'vendor_id')) {
            Schema::table('videos', function (Blueprint $table) {
                $table->dropForeign(['vendor_id']);
                $table->dropColumn('vendor_id');
            });
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('videos', function (Blueprint $table) {
            $table->dropForeign(['knowledge_category_id']);
            $table->dropForeign(['partner_division_id']);
            $table->dropColumn(['visible_on_main_page', 'last_watched_at', 'month_added', 'is_part_of_series', 'knowledge_category_id', 'partner_division_id']);
        });
    }
}
