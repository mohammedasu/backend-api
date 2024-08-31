<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddColumnToMemberSeriesHistoriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('member_series_histories', function (Blueprint $table) {
            $table->unsignedInteger('series_item_id')->nullable();
            $table->foreign('series_item_id')->references('id')->on('series_items');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('member_series_histories', function (Blueprint $table) {
            $table->dropForeign(['series_item_id']);
            $table->dropColumn('series_item_id');
        });
    }
}
