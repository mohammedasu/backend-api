<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AlterSeries extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('series', function (Blueprint $table) {
            $table->unsignedInteger('partner_division_id')->nullable();
            $table->foreign('partner_division_id')->references('id')->on('partner_divisions');
            $table->string('month_added')->nullable(true)->default(null);
            $table->timestamp('last_watched_at')->nullable(true)->default(null);
            $table->integer('series_view_count')->default(0);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('series', function (Blueprint $table) {
            $table->dropForeign(['partner_division_id']);
            $table->dropColumn(['series_view_count', 'last_watched_at', 'month_added', 'partner_division_id']);
        });
    }
}
