<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddDataFilterInEngagement extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('engagements', function (Blueprint $table) {
            $table->unsignedInteger('data_filter_id')->nullable(true);
            $table->foreign('data_filter_id')->references('id')->on('data_filters');
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
            $table->dropForeign(['data_filter_id']);
            $table->dropColumn('data_filter_id');
        });
    }
}
